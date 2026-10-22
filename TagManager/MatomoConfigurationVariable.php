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
use Piwik\Plugins\TagManager\Context\WebContext;
use Piwik\Plugins\TagManager\Template\Variable\MatomoConfigurationVariable as CoreMatomoConfigurationVariable;
use Piwik\Settings\FieldConfig;
use Piwik\Validators\CharacterLength;

/**
 * Adds a "Gravatar hash" field right after "User ID" in the Tag Manager "Matomo Configuration" variable.
 *
 * Other plugins extend the same variable (eg EcommerceEnhanced), so it is never replaced: each plugin wraps the
 * variable it finds, the core one or one already extended, and adds its parameter and its JavaScript to it. The
 * class keeps the core short name so the template ID stays "MatomoConfiguration", and lives outside of
 * Template/Variable so the Tag Manager does not discover it as a second variable template.
 */
class MatomoConfigurationVariable extends CoreMatomoConfigurationVariable
{
    public const PARAM_GRAVATAR_HASH = 'gravatarHash';

    private const INSERT_AFTER = 'userId';

    /**
     * @var CoreMatomoConfigurationVariable
     */
    private $innerVariable;

    public function __construct(?CoreMatomoConfigurationVariable $innerVariable = null)
    {
        $this->innerVariable = $innerVariable ?: new CoreMatomoConfigurationVariable();
    }

    /**
     * Wraps the "Matomo Configuration" variable of the list, unless this plugin already extends it
     *
     * @param \Piwik\Plugins\TagManager\Template\Variable\BaseVariable[] $variables
     */
    public static function extendVariables(array &$variables): void
    {
        foreach ($variables as $index => $variable) {
            if ($variable instanceof CoreMatomoConfigurationVariable && !self::isExtendedBy($variable)) {
                $variables[$index] = new self($variable);
            }
        }
    }

    public function getInnerVariable(): CoreMatomoConfigurationVariable
    {
        return $this->innerVariable;
    }

    public function getParameters()
    {
        $parameters = $this->innerVariable->getParameters();

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

    /**
     * The template of the wrapped variable, whose config is then passed to the extension of this plugin
     * (MatomoConfigurationVariable.web.js, next to this file)
     */
    public function loadTemplate($context, $entity)
    {
        $innerTemplate = $this->innerVariable->loadTemplate(...func_get_args());
        if ($context !== WebContext::ID || empty($innerTemplate)) {
            return $innerTemplate;
        }

        $extension = parent::loadTemplate($context, $entity);
        if (empty($extension)) {
            return $innerTemplate;
        }

        return '(function () {'
            . "\nvar Inner = " . $innerTemplate . "\n;"
            . "\nvar extend = " . $extension . "\n;"
            . "\nreturn function (parameters, TagManager) {"
            . ' Inner.call(this, parameters, TagManager);'
            . ' var get = this.get;'
            . ' this.get = function () { var config = get.call(this); extend(config, parameters, TagManager); return config; };'
            . ' };'
            . "\n})()";
    }

    private static function isExtendedBy(CoreMatomoConfigurationVariable $variable): bool
    {
        while ($variable !== null) {
            if ($variable instanceof self) {
                return true;
            }
            $variable = method_exists($variable, 'getInnerVariable') ? $variable->getInnerVariable() : null;
        }

        return false;
    }
}
