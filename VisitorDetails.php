<?php

namespace Piwik\Plugins\ProfileGravatar;

use Piwik\Plugins\Live\VisitorDetailsAbstract;

class VisitorDetails extends VisitorDetailsAbstract
{
    public function extendVisitorDetails(&$visitor)
    {
        $visitor['gravatar_hash'] = $this->details['gravatar_hash'];
    }


    public function initProfile($visits, &$profile)
    {
        // Get Gravatar hash from last visit
        $hash = $visits->getFirstRow()->getColumn('gravatar_hash') ?? 'unknown';

        // Get settings
        $settings = new \Piwik\Plugins\ProfileGravatar\SystemSettings();
        $defaultImage = $chatBasePrompt = $settings->defaultImage->getValue();
        $rating = $chatBasePrompt = $settings->rating->getValue();

        // Create Gravatar URL
        $gravatarUrl = "//gravatar.com/avatar/$hash.jpg";
        $gravatarUrl .= "?s=240";
        $gravatarUrl .= "&d=$defaultImage";
        $gravatarUrl .= "&r=$rating";

        // Insert URL in user profile
        $profile["visitorAvatar"] = $gravatarUrl;
        $profile["visitorDescription"] = "User gravatar";
    }
}
