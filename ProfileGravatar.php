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
use Piwik\Plugins\ProfileGravatar\TagManager\MatomoConfigurationVariable;

class ProfileGravatar extends \Piwik\Plugin
{
    public function registerEvents()
    {
        return [
            'AssetManager.getStylesheetFiles' => 'getStylesheetFiles',
            'TagManager.filterVariables' => 'filterVariables',
        ];
    }

    public function getStylesheetFiles(&$files): void
    {
        $files[] = 'plugins/ProfileGravatar/stylesheets/profileGravatar.less';
    }

    /**
     * Replaces the core "Matomo Configuration" variable template by the one with the "Gravatar hash" field
     */
    public function filterVariables(&$variables): void
    {
        $coreClass = \Piwik\Plugins\TagManager\Template\Variable\MatomoConfigurationVariable::class;

        foreach ($variables as $index => $variable) {
            if (get_class($variable) === $coreClass) {
                $variables[$index] = StaticContainer::get(MatomoConfigurationVariable::class);
                return;
            }
        }
    }
}
