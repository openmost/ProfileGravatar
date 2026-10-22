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
use Piwik\DataTable;
use Piwik\Plugins\ProfileGravatar\VisitorDetails;

/**
 * @group ProfileGravatar
 * @group ProfileGravatarVisitorDetailsTest
 * @group Plugins
 */
class VisitorDetailsTest extends TestCase
{
    public function test_initProfile_leavesTheAvatarToOtherPlugins_withoutAValidHash(): void
    {
        $visits = new DataTable();
        foreach ([null, '0', 'false', 'not-a-hash'] as $hash) {
            $visits->addRowFromSimpleArray(['gravatar_hash' => $hash]);
        }

        $profile = ['visitorAvatar' => 'https://example.com/other-plugin.png', 'visitorDescription' => 'Other plugin'];
        (new VisitorDetails())->initProfile($visits, $profile);

        $this->assertSame(['visitorAvatar' => 'https://example.com/other-plugin.png', 'visitorDescription' => 'Other plugin'], $profile);
    }
}
