<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

declare(strict_types=1);

namespace Piwik\Plugins\ProfileGravatar;

final class Gravatar
{
    public const AVATAR_BASE_URL = 'https://gravatar.com/avatar/';

    /**
     * Gravatar accepts SHA256 (recommended) or MD5 hashes of the trimmed, lowercased email address
     */
    private const HASH_PATTERN = '/^(?:[0-9a-f]{64}|[0-9a-f]{32})$/';

    /**
     * Returns the lowercased hash, or null when the value is not a valid Gravatar hash
     * (e.g. "false" or "0" stored by versions prior to 6.0.0)
     *
     * @param mixed $value
     */
    public static function normalizeHash($value): ?string
    {
        if (!is_string($value)) {
            return null;
        }

        $hash = strtolower(trim($value));

        return preg_match(self::HASH_PATTERN, $hash) === 1 ? $hash : null;
    }

    public static function buildAvatarUrl(string $hash, int $size, string $defaultImage, string $rating): string
    {
        return self::AVATAR_BASE_URL . rawurlencode($hash) . '?' . http_build_query([
            's' => $size,
            'd' => $defaultImage,
            'r' => $rating,
        ], '', '&', PHP_QUERY_RFC3986);
    }
}
