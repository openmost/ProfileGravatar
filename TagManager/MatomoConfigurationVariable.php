<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

declare(strict_types=1);

namespace Piwik\Plugins\ProfileGravatar\TagManager;

use Piwik\Piwik;
use Piwik\Settings\FieldConfig;
use Piwik\Validators\CharacterLength;

/**
 * Adds a "Gravatar hash" field right after "User ID" in the Tag Manager "Matomo Configuration" variable.
 *
 * The class keeps the core short name so the template ID stays "MatomoConfiguration". It lives outside of
 * Template/Variable on purpose: the Tag Manager would otherwise discover it as a second variable template.
 * It replaces the core template through the TagManager.filterVariables event.
 */
class MatomoConfigurationVariable extends \Piwik\Plugins\TagManager\Template\Variable\MatomoConfigurationVariable
{
    public const PARAM_GRAVATAR_HASH = 'gravatarHash';

    private const INSERT_AFTER = 'userId';

    public function getParameters()
    {
        $parameters = parent::getParameters();

        $gravatarHash = $this->makeSetting(self::PARAM_GRAVATAR_HASH, '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = Piwik::translate('ProfileGravatar_TagManagerGravatarHashTitle');
            $field->description = Piwik::translate('ProfileGravatar_TagManagerGravatarHashDescription');
            $field->validators[] = new CharacterLength(0, 500);
            $field->customFieldComponent = self::FIELD_VARIABLE_COMPONENT;
        });

        foreach ($parameters as $index => $parameter) {
            if ($parameter->getName() === self::INSERT_AFTER) {
                array_splice($parameters, $index + 1, 0, [$gravatarHash]);

                return $parameters;
            }
        }

        $parameters[] = $gravatarHash;

        return $parameters;
    }
}
