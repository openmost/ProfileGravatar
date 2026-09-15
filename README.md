# Profile Gravatar Plugin

## Description

Display the Gravatar profile picture of your identified visitors in Matomo.

Send the SHA256 hash of the visitor email address (for example `sha256_email_address` from your data layer) with your tracking requests and Matomo shows the matching [Gravatar](https://gravatar.com) picture:

- in the **visitor profile**, instead of the anonymous avatar,
- in the **visits log**, next to the visitor details (can be disabled),
- in the **Live API** (`gravatar_hash` and `gravatarUrl` in `Live.getLastVisitsDetails`).

With Matomo Tag Manager, select your Data-Layer variable in the new **Gravatar hash** field of the Matomo Configuration variable (right after User ID): no Custom HTML tag or code needed. You can also use `_paq.push(['ProfileGravatar.setGravatarHash', hash])`, the Tracking HTTP API or the PHP Tracker.

The plugin never needs the email address: only its SHA256 (or MD5) hash is tracked, in a dedicated visit dimension that you can also use as a segment (`gravatarHash`).

In the system settings you can choose the default image displayed when a visitor has no Gravatar, and the maximum rating of the pictures.

__Thank you for installing !__

## Requirements

- Matomo 6.x
- PHP 8.1 or higher
- MySQL 8.0+ or MariaDB 10.6+

## Want more ?

Find the documentation and the other Openmost plugins on https://openmost.com/matomo/extensions/profile-gravatar

If you want to have your own plugin or want to develop a plugin for your customers, please contact me using my email in the marketplace official page or go to https://openmost.com
