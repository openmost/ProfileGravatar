<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\ProfileGravatar;

use Piwik\Plugins\ProfileGravatar\TagManager\MatomoConfigurationVariable;

class ProfileGravatar extends \Piwik\Plugin
{
    public function registerEvents()
    {
        return [
            'Template.afterEventsReport' => 'renderOpenmostCommunicationAfterEvents',
            'Widget.filterWidgets' => 'addOpenmostCommunicationWidgets',
            'Template.beforeContent' => 'renderOpenmostCommunication',
            'AssetManager.getStylesheetFiles' => 'getStylesheetFiles',
            'TagManager.filterVariables' => 'filterVariables',
        ];
    }

    public function getStylesheetFiles(&$files): void
    {
        $files[] = 'plugins/ProfileGravatar/stylesheets/profileGravatar.less';
    }

    /**
     * Adds the "Gravatar hash" field to the "Matomo Configuration" variable, on top of the other plugins extending it
     */
    public function filterVariables(&$variables): void
    {
        MatomoConfigurationVariable::extendVariables($variables);
    }

    public function renderOpenmostCommunication(&$out, $layout, $module = '', $action = '')
    {
        OpenmostCommunication::beforeContent($out, (string) $layout, (string) $module, (string) $action, $this->getPluginName());
    }

    public function addOpenmostCommunicationWidgets($list)
    {
        OpenmostCommunication::filterWidgets($list, $this->getPluginName());
    }

    public function renderOpenmostCommunicationAfterEvents(&$out, $dataTable = null)
    {
        OpenmostCommunication::afterEventsReport($out, $this->getPluginName());
    }
}
