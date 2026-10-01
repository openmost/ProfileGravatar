# Profile Gravatar

Display the Gravatar profile picture of your identified visitors in the visitor profile and the visits log.

## Features

- **Visitor profile picture**: when a visit carries the SHA256 hash of the visitor email address, the visitor profile shows the matching [Gravatar](https://gravatar.com) picture instead of the anonymous avatar. The most recent visit with a hash is used.
- **Visits log**: a small profile picture next to the visitor details (can be turned off).
- **Matomo Tag Manager field**: a **Gravatar hash** field is added to the Matomo Configuration variable, right after User ID. Select a Data-Layer variable (for example `sha256_email_address`), no Custom HTML tag or code needed.
- **Other ways to send the hash**: `_paq.push(['ProfileGravatar.setGravatarHash', hash])` (and `resetGravatarHash` on logout) with the JavaScript tracker, the `gravatar_hash` parameter of the Tracking HTTP API, or the PHP Tracker. The hash is attached to every tracking request, so it can be set after the page view.
- **Segment and API**: the hash is stored in a dedicated visit dimension, usable as the `gravatarHash` segment. `Live.getLastVisitsDetails` returns `gravatar_hash` and `gravatarUrl`.
- **Settings**: default image when a visitor has no Gravatar (mystery person, identicon, MonsterID, Wavatar, Retro, RoboHash, blank) and maximum picture rating (G, PG, R, X).
- Only valid SHA256 or MD5 hashes are tracked, any other value is ignored.

## Requirements

- Matomo 6 (`>=6.0.0-b1,<7.0.0-b1`)
- PHP 8.1 or higher
- Matomo Tag Manager is optional, it is only needed for the Gravatar hash field.

## Installation / Configuration

1. Install and activate the plugin from *Administration > Platform > Marketplace*.
2. Send the hash from your website, with Tag Manager or the tracker (see [docs/index.md](docs/index.md)).
3. Optionally adjust the default image, the rating and the visits log display in *Administration > System > General settings > ProfileGravatar*.

## Privacy and data

- The plugin never needs the email address: only its SHA256 (or MD5) hash is tracked and stored in Matomo, like any other visit dimension.
- Pictures are loaded over HTTPS from gravatar.com by the browser of the Matomo users viewing the reports. Visitors themselves never contact Gravatar because of this plugin.
- A hash of an email address is still personal data under the GDPR: send it only for visitors who agreed to it, and include it in your data retention and deletion processes.

## Need help with Matomo?

Openmost is an official Matomo Implementation Partner. We design [Matomo tracking plans](https://openmost.com/matomo/services/tracking-architecture?utm_source=matomo_marketplace&utm_medium=referral&utm_campaign=services&utm_content=profilegravatar), including User ID and cross-device identification where your legal basis allows it, and implement them so your team can maintain them.

## Support

- Homepage: https://openmost.com/matomo/extensions/profile-gravatar
- Issues: https://github.com/openmost/ProfileGravatar/issues
- Email: ronan@openmost.com

## Screenshots

See the `screenshots/` folder, or the plugin page on the Matomo Marketplace.
