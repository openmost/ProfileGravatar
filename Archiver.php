<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\ProfileGravatar;

/**
 * Archiver that aggregates metrics per user ID (user_id field).
 */
class Archiver extends \Piwik\Plugin\Archiver
{
    const GRAVATAR_HASH_RECORD_NAME = 'ProfileGravatar_GravatarHash';

    const GRAVATAR_HASH_DIMENSION = "log_visit.gravatar_hash";
    const GRAVATAR_HASH_ARCHIVE_RECORD = "UserId_users";
}
