<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

declare(strict_types=1);

namespace Piwik\Plugins\ProfileGravatar;

use Piwik\Piwik;
use Piwik\Settings\FieldConfig;
use Piwik\Settings\Setting;
use Piwik\Validators\NotEmpty;
use Piwik\Validators\WhitelistedValue;

class SystemSettings extends \Piwik\Settings\Plugin\SystemSettings
{
    /** @var Setting */
    public $defaultImage;

    /** @var Setting */
    public $rating;

    /** @var Setting */
    public $showInVisitsLog;

    protected function init()
    {
        $this->defaultImage = $this->createDefaultImageSetting();
        $this->rating = $this->createRatingSetting();
        $this->showInVisitsLog = $this->createShowInVisitsLogSetting();
    }

    private function createDefaultImageSetting(): Setting
    {
        return $this->makeSetting('default_image', 'mp', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = Piwik::translate('ProfileGravatar_DefaultImage');
            $field->uiControl = FieldConfig::UI_CONTROL_SINGLE_SELECT;
            $field->availableValues = [
                'mp' => Piwik::translate('ProfileGravatar_DefaultImageMysteryPerson'),
                'identicon' => 'Identicon',
                'monsterid' => 'MonsterID',
                'wavatar' => 'Wavatar',
                'retro' => 'Retro',
                'robohash' => 'RoboHash',
                'blank' => Piwik::translate('ProfileGravatar_DefaultImageBlank'),
            ];
            $field->description = Piwik::translate('ProfileGravatar_DefaultImageDescription');
            $field->validators[] = new NotEmpty();
            $field->validators[] = new WhitelistedValue(array_keys($field->availableValues));
        });
    }

    private function createRatingSetting(): Setting
    {
        return $this->makeSetting('rating', 'g', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = Piwik::translate('ProfileGravatar_Rating');
            $field->uiControl = FieldConfig::UI_CONTROL_SINGLE_SELECT;
            $field->availableValues = [
                'g' => 'G',
                'pg' => 'PG',
                'r' => 'R',
                'x' => 'X',
            ];
            $field->description = Piwik::translate('ProfileGravatar_RatingDescription');
            $field->validators[] = new NotEmpty();
            $field->validators[] = new WhitelistedValue(array_keys($field->availableValues));
        });
    }

    private function createShowInVisitsLogSetting(): Setting
    {
        return $this->makeSetting('show_in_visits_log', true, FieldConfig::TYPE_BOOL, function (FieldConfig $field) {
            $field->title = Piwik::translate('ProfileGravatar_ShowInVisitsLog');
            $field->uiControl = FieldConfig::UI_CONTROL_CHECKBOX;
            $field->description = Piwik::translate('ProfileGravatar_ShowInVisitsLogDescription');
        });
    }
}
