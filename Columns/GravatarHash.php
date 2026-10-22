<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

declare(strict_types=1);

namespace Piwik\Plugins\ProfileGravatar\Columns;

use Piwik\Plugin\Dimension\VisitDimension;
use Piwik\Plugins\ProfileGravatar\Gravatar;
use Piwik\Tracker\Action;
use Piwik\Tracker\Request;
use Piwik\Tracker\Visitor;

class GravatarHash extends VisitDimension
{
    public const TRACKING_PARAMETER = 'gravatar_hash';

    protected $columnName = 'gravatar_hash';

    // Kept as VARCHAR(255) so existing installs do not have to alter the log_visit table
    protected $columnType = 'VARCHAR(255) NULL';

    protected $type = self::TYPE_TEXT;

    protected $nameSingular = 'ProfileGravatar_GravatarHash';

    protected $segmentName = 'gravatarHash';

    protected $acceptValues = 'ProfileGravatar_GravatarHashSegmentHelp';

    /**
     * @param Action|null $action
     * @return string|null
     */
    public function onNewVisit(Request $request, Visitor $visitor, $action)
    {
        return $this->getHashFromRequest($request);
    }

    /**
     * @param Action|null $action
     * @return string|false false keeps the value already stored for the visit
     */
    public function onExistingVisit(Request $request, Visitor $visitor, $action)
    {
        return $this->getHashFromRequest($request) ?? false;
    }

    private function getHashFromRequest(Request $request): ?string
    {
        $params = $request->getParams();

        return Gravatar::normalizeHash($params[self::TRACKING_PARAMETER] ?? null);
    }
}
