<?php

return [
    \Piwik\View\SecurityPolicy::class => \Piwik\DI::decorate(function ($previous) {
        /** @var \Piwik\View\SecurityPolicy $previous */

        if (!\Piwik\SettingsPiwik::isMatomoInstalled()) {
            return $previous;
        }

        // Avatars are loaded from Gravatar in the visitor profile and the visits log
        $previous->addPolicy('img-src', 'https://gravatar.com');
        return $previous;
    }),
];
