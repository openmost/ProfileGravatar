# Profile Gravatar

Display the Gravatar profile picture of your identified visitors in the visitor profile.

## Features

- **Visitor profile picture**: when the visits carry the SHA256 hash of the visitor email address, the visitor profile shows the matching [Gravatar](https://gravatar.com) picture. The hash of the last visit is used.
- **Send the hash from your tracking code**: `_paq.push(['ProfileGravatar.setGravatarHash', hash])` with the JavaScript tracker (before `trackPageView`), or the `gravatar_hash` parameter of the Tracking HTTP API.
- **Segment and API**: the hash is stored in a dedicated visit dimension, usable as the `gravatarHash` segment, and returned as `gravatar_hash` by `Live.getLastVisitsDetails`.
- **Settings**: default image displayed by Gravatar when no picture matches (mystery person, identicon, monsterid, wavatar, retro, robohash, blank) and maximum picture rating (G, PG, R, X).

## Requirements

- Matomo 5.10.0 or later (`>=5.10.0,<6.0.0-b1`)

## Installation / Configuration

1. Install and activate the plugin from *Administration > Platform > Marketplace*.
2. Send the hash from your website (see [docs/index.md](docs/index.md)).
3. Optionally adjust the default image and the rating in *Administration > System > General settings > ProfileGravatar*.

## Privacy and data

- The plugin never needs the email address: only its hash is tracked and stored in Matomo, like any other visit dimension.
- Pictures are loaded from gravatar.com by the browser of the Matomo users viewing the visitor profile. Visitors themselves never contact Gravatar because of this plugin.
- A hash of an email address is still personal data under the GDPR: send it only for visitors who agreed to it, and include it in your data retention and deletion processes.

## Need help with Matomo?

Openmost is an official Matomo Implementation Partner. We design [Matomo tracking plans](https://openmost.com/matomo/services/tracking-architecture?utm_source=matomo_marketplace&utm_medium=referral&utm_campaign=services&utm_content=profilegravatar), including User ID and cross-device identification where your legal basis allows it, and implement them so your team can maintain them.

## Support

- Homepage: https://openmost.com/matomo/extensions/profile-gravatar
- Issues: https://github.com/openmost/ProfileGravatar/issues
- Email: ronan@openmost.com

## Screenshots

See the `screenshots/` folder, or the plugin page on the Matomo Marketplace.
