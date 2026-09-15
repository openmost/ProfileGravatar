<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

declare(strict_types=1);

namespace Piwik\Plugins\ProfileGravatar;

use Piwik\Container\StaticContainer;
use Piwik\DataTable;
use Piwik\Piwik;
use Piwik\Plugins\Live\VisitorDetailsAbstract;

class VisitorDetails extends VisitorDetailsAbstract
{
    private const PROFILE_AVATAR_SIZE = 240;

    // Displayed at 24px, doubled for high density screens
    private const VISITS_LOG_AVATAR_SIZE = 48;

    public function extendVisitorDetails(&$visitor)
    {
        $hash = Gravatar::normalizeHash($this->details['gravatar_hash'] ?? null);

        $visitor['gravatar_hash'] = $hash;
        $visitor['gravatarUrl'] = $hash === null ? null : $this->buildAvatarUrl($hash, self::PROFILE_AVATAR_SIZE);
    }

    public function initProfile($visits, &$profile)
    {
        // Visits are sorted from the most recent one, use the latest known hash
        foreach ($visits->getRows() as $visit) {
            $hash = Gravatar::normalizeHash($visit->getColumn('gravatar_hash'));
            if ($hash === null) {
                continue;
            }

            $profile['visitorAvatar'] = $this->buildAvatarUrl($hash, self::PROFILE_AVATAR_SIZE);
            $profile['visitorDescription'] = Piwik::translate('ProfileGravatar_AvatarDescription');

            return;
        }
    }

    public function renderIcons($visitorDetails)
    {
        if (!$this->getSettings()->showInVisitsLog->getValue()) {
            return '';
        }

        $value = $visitorDetails instanceof DataTable\Row
            ? $visitorDetails->getColumn('gravatar_hash')
            : ($visitorDetails['gravatar_hash'] ?? null);

        $hash = Gravatar::normalizeHash($value);
        if ($hash === null) {
            return '';
        }

        $description = htmlspecialchars(Piwik::translate('ProfileGravatar_AvatarDescription'), ENT_QUOTES, 'UTF-8');
        $url = htmlspecialchars($this->buildAvatarUrl($hash, self::VISITS_LOG_AVATAR_SIZE), ENT_QUOTES, 'UTF-8');

        return '<span class="visitorLogIconWithDetails profileGravatar">'
            . '<img class="profileGravatarAvatar" src="' . $url . '" alt="' . $description . '" loading="lazy"/>'
            . '<ul class="details"><li>' . $description . '</li></ul>'
            . '</span>';
    }

    private function buildAvatarUrl(string $hash, int $size): string
    {
        $settings = $this->getSettings();

        return Gravatar::buildAvatarUrl(
            $hash,
            $size,
            (string) $settings->defaultImage->getValue(),
            (string) $settings->rating->getValue()
        );
    }

    private function getSettings(): SystemSettings
    {
        return StaticContainer::get(SystemSettings::class);
    }
}
