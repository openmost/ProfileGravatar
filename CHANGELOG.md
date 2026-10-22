## Changelog

### v5.1.0

Backport of the 6.x features to Matomo 5, both versions now share the same code.

- The anonymous Matomo avatar is kept for visitors without a hash, so another avatar plugin can provide it ([#2](https://github.com/openmost/ProfileGravatar/issues/2)). Previously a Gravatar default image was displayed for every visitor.
- The visitor profile uses the most recent visit with a valid hash, instead of only the last visit. Only valid SHA256 or MD5 hashes are used.
- Matomo Tag Manager: new "Gravatar hash" field in the Matomo Configuration variable, right after User ID, to send the hash from a Data-Layer variable (e.g. `sha256_email_address`) without Custom HTML tag or code. The field extends the variable instead of replacing it, so it works together with the other plugins extending it, such as Ecommerce Enhanced.
- Display the Gravatar picture in the visits log, next to the visitor details (can be disabled in the system settings).
- `Live.getLastVisitsDetails` returns a `gravatarUrl` for each visit with a hash.
- `ProfileGravatar.resetGravatarHash` tracker method, for logouts.
- The hash is sent with every tracking request (events, goals, downloads, outlinks, ecommerce, content tracking, heartbeat), so it can be set after the page view.
- Settings and dimension translated into 12 languages.
- Documentation: Tag Manager setup, data layer `sha256_email_address`, HTTP API and PHP Tracker examples, privacy FAQ.

### v5.0.11

- Request parameters are read with `Piwik\Request` instead of the deprecated `Common::getRequestVar`, ready for the next Matomo versions.

### v5.0.10

- Plugin translated into 12 languages (Arabic, Chinese simplified and traditional, Dutch, English, French, German, Italian, Japanese, Polish, Portuguese, Spanish).
- Plugin homepage moved to https://openmost.com/matomo/extensions/profile-gravatar, support on openmost.com.
- Shorter Marketplace description that fits the plugin cards, and campaign parameters on the Openmost links of the README.
- Requires Matomo 5.0.0 or later (`>=5.0.0,<6.0.0-b1`).
- README: the plugin description now shows in the Description tab of the Matomo Marketplace.

### v5.0.9

update: marketplace category and cover

### v5.0.8

Update screenshot

### v5.0.7

Update documentation

### v5.0.6

Update documentation URL

### v5.0.5

Add system settings

### v5.0.4

Add extendVisitorDetails in VisitorDetails.php

### v5.0.3

Add archiver

### v5.0.1

Plugin setup
