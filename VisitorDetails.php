<?php

namespace Piwik\Plugins\ProfileGravatar;

use Piwik\Plugins\Live\VisitorDetailsAbstract;

class VisitorDetails extends VisitorDetailsAbstract
{
    public function initProfile($visits, &$profile)
    {
        $hash = $this->details['gravatar_hash'] ?? 'unknown';

        $gravatarUrl = "https://gravatar.com/avatar/$hash.jpg";
        $gravatarUrl .= "?s=240";
        $gravatarUrl .= "&d=mp";

        $profile["visitorAvatar"] = $gravatarUrl;
        $profile["visitorDescription"] = "User gravatar";
    }
}
