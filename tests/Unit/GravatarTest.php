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
use Piwik\Plugins\ProfileGravatar\Gravatar;

/**
 * @group ProfileGravatar
 * @group Plugins
 */
class GravatarTest extends TestCase
{
    public function test_normalizeHash_acceptsSha256AndMd5(): void
    {
        $sha256 = hash('sha256', 'user.name@mail.com');
        $md5 = md5('user.name@mail.com');

        $this->assertSame($sha256, Gravatar::normalizeHash($sha256));
        $this->assertSame($md5, Gravatar::normalizeHash($md5));
    }

    public function test_normalizeHash_trimsAndLowercases(): void
    {
        $sha256 = hash('sha256', 'user.name@mail.com');

        $this->assertSame($sha256, Gravatar::normalizeHash('  ' . strtoupper($sha256) . "\n"));
    }

    /**
     * @dataProvider getInvalidHashes
     * @param mixed $value
     */
    public function test_normalizeHash_rejectsInvalidValues($value): void
    {
        $this->assertNull(Gravatar::normalizeHash($value));
    }

    public function getInvalidHashes(): array
    {
        return [
            'legacy false value' => ['false'],
            'legacy zero value' => ['0'],
            'empty string' => [''],
            'null' => [null],
            'boolean' => [false],
            'array' => [['abc']],
            'email address' => ['user.name@mail.com'],
            'sha1 length' => [sha1('user.name@mail.com')],
            'non hexadecimal' => [str_repeat('z', 64)],
            'injection' => [md5('a') . '?d=https://evil.example'],
        ];
    }

    public function test_buildAvatarUrl(): void
    {
        $hash = hash('sha256', 'user.name@mail.com');

        $this->assertSame(
            'https://gravatar.com/avatar/' . $hash . '?s=240&d=mp&r=g',
            Gravatar::buildAvatarUrl($hash, 240, 'mp', 'g')
        );
    }
}
