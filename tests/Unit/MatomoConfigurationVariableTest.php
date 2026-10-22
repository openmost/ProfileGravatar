<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

declare(strict_types=1);

namespace Piwik\Plugins\ProfileGravatar\tests\Unit;

use PHPUnit\Framework\TestCase;
use Piwik\Plugins\ProfileGravatar\TagManager\MatomoConfigurationVariable;
use Piwik\Plugins\TagManager\Template\Variable\MatomoConfigurationVariable as CoreMatomoConfigurationVariable;

/**
 * @group ProfileGravatar
 * @group ProfileGravatarMatomoConfigurationVariableTest
 * @group Plugins
 */
class MatomoConfigurationVariableTest extends TestCase
{
    public function test_extendVariables_wrapsTheVariableOfAnotherPlugin_insteadOfReplacingIt(): void
    {
        // another plugin extending the same variable, eg ProfileGravatar or EcommerceEnhanced
        $otherPlugin = new class extends CoreMatomoConfigurationVariable {
            public function getInnerVariable(): CoreMatomoConfigurationVariable
            {
                return new CoreMatomoConfigurationVariable();
            }
        };
        $variables = [$otherPlugin];

        MatomoConfigurationVariable::extendVariables($variables);

        $this->assertInstanceOf(MatomoConfigurationVariable::class, $variables[0]);
        $this->assertSame($otherPlugin, $variables[0]->getInnerVariable());
        $this->assertSame(CoreMatomoConfigurationVariable::ID, $variables[0]->getId());
    }

    public function test_extendVariables_wrapsTheVariableOnlyOnce(): void
    {
        $core = new CoreMatomoConfigurationVariable();
        $variables = [$core];

        MatomoConfigurationVariable::extendVariables($variables);
        $extended = $variables[0];
        // the same plugin further down the chain, under another plugin
        $variables = [new class ($extended) extends CoreMatomoConfigurationVariable {
            private $inner;

            public function __construct(CoreMatomoConfigurationVariable $inner)
            {
                $this->inner = $inner;
            }

            public function getInnerVariable(): CoreMatomoConfigurationVariable
            {
                return $this->inner;
            }
        }];
        $outer = $variables[0];

        MatomoConfigurationVariable::extendVariables($variables);

        $this->assertSame($outer, $variables[0]);
        $this->assertSame($core, $extended->getInnerVariable());
    }
}
