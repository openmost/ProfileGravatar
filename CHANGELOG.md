## Changelog

### v6.0.1

- Remove the `strict_types` declaration from the main plugin file, which the Marketplace syntax check rejects

### v6.0.0

#### Matomo 6

- Compatibility with Matomo 6.x (`>=6.0.0-b1,<7.0.0-b1`)
- Requires PHP 8.1+ and MySQL 8.0+ or MariaDB 10.6+
- Update plugin homepage URL to https://openmost.com/matomo/extensions/profile-gravatar

#### Improvements

- Matomo Tag Manager: new "Gravatar hash" field in the Matomo Configuration variable, right after User ID, to send the hash from a Data-Layer variable (e.g. `sha256_email_address`) without Custom HTML tag or code
- Display the Gravatar picture in the visits log, next to the visitor details (can be disabled in the system settings)
- The visitor profile uses the most recent visit with a hash, instead of only the last visit
- The anonymous Matomo avatar is kept for visitors without a hash (previously a Gravatar default image was displayed for every visitor)
- `Live.getLastVisitsDetails` returns a `gravatarUrl` for each visit with a hash
- `ProfileGravatar.resetGravatarHash` tracker method, for logouts
- The hash is sent with every tracking request (events, goals, downloads, outlinks, ecommerce, content tracking, heartbeat), so it can be set after the page view
- English and French translations for the settings and the dimension
- Documentation: Tag Manager setup, data layer `sha256_email_address`, HTTP API and PHP Tracker examples, privacy FAQ

#### Fixes

- Visits without a hash no longer store `false` (or `0`) in the `gravatar_hash` column, existing invalid values are ignored
- Only valid SHA256 or MD5 hashes are tracked
- Avatars are always loaded over HTTPS
- Only the documented values are accepted for the default image and rating settings

#### Technical

- Remove the unused archiver and record builder (they were never loaded and no report used them)
- Remove the empty tracker config file
- Add unit tests

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
