<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\ProfileGravatar;

use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;
use Piwik\Validators\NotEmpty;

/**
 * Defines Settings for ProfileGravatar.
 *
 * Usage like this:
 * $settings = new SystemSettings();
 * $settings->metric->getValue();
 * $settings->description->getValue();
 */
class SystemSettings extends \Piwik\Settings\Plugin\SystemSettings
{
    /** @var Setting */
    public $defaultImage;
    public $rating;

    protected function init()
    {
        $this->defaultImage = $this->createDefaultImageSetting();
        $this->rating = $this->createRatingSetting();
    }

    private function createDefaultImageSetting()
    {
        return $this->makeSetting('default_image', $default = 'mp', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = 'Default image';
            $field->uiControl = FieldConfig::UI_CONTROL_SINGLE_SELECT;
            $field->availableValues = array(
                'mp' => 'Mystery person',
                'identicon' => 'Identicon',
                'monsterid' => 'Monsterid',
                'wavatar' => 'Wavatar',
                'retro' => 'Retro',
                'robohash' => 'Robohash',
                'blank' => 'Blank',
            );
            $field->description = 'When you include a default image, Gravatar will automatically serve up that image if there is no image associated with the requested email hash.';
            $field->validators[] = new NotEmpty();
        });
    }

    private function createRatingSetting()
    {
        return $this->makeSetting('rating', $default = 'g', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = 'Rating';
            $field->uiControl = FieldConfig::UI_CONTROL_SINGLE_SELECT;
            $field->availableValues = array(
                'g' => 'G',
                'pg' => 'PG',
                'r' => 'R',
                'x' => 'X',
            );
            $field->description = 'Gravatar allows users to self-rate their images so that they can indicate if an image is appropriate for a certain audience. By default, only G rated images are displayed unless you indicate that you would like to see higher ratings.';
            $field->validators[] = new NotEmpty();
        });
    }
}
