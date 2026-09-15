## Documentation

### 1 - Install the plugin from the marketplace or via GitHub and enable it

Install this plugin from the Marketplace as superuser or download the plugin and install it on your server from FTP in
the `/plugins` folder, then activate it.

Requirements: Matomo 6.x, PHP 8.1+, MySQL 8.0+ or MariaDB 10.6+.

### 2 - Provide the hash of the visitor email address

The plugin never needs the email address of your visitors: your website provides the **SHA256 hash** of the email
address, for example in the data layer with the `sha256_email_address` key (the same key as Google enhanced conversions).

```javascript
window._mtm = window._mtm || [];
_mtm.push({'sha256_email_address': 'a8cfcd74832004951b4408cdb0a5dbcd8c7e52d43f7fe244bf720582e05241da'});
```

Gravatar finds the profile when the email address was trimmed and lowercased before hashing. MD5 hashes are also
accepted, any other value is ignored by the plugin.

### 3 - Send the hash to Matomo

#### With Matomo Tag Manager (recommended)

No Custom HTML tag and no code are needed:

1. Create a **Data-Layer** variable, for example `sha256_email_address`, reading the `sha256_email_address` key.
2. Edit your **Matomo Configuration** variable and select this variable in the **Gravatar hash** field, right after the User ID field.
3. Publish a new version of your container.

The hash is sent with the requests of your Matomo tags, for the site of the configuration.

#### With the JavaScript tracker

Add this line to your tracking code, before `_paq.push(['trackPageView']);`:

```javascript
_paq.push(['ProfileGravatar.setGravatarHash', 'a8cfcd74832004951b4408cdb0a5dbcd8c7e52d43f7fe244bf720582e05241da']);
```

The hash is sent with every following tracking request (page views, events, goals, downloads, outlinks, ecommerce,
content tracking and heartbeat), so you can also set it later, for example after a login in a single page application.
Call `_paq.push(['ProfileGravatar.resetGravatarHash']);` on logout.

#### With the Tracking HTTP API or the PHP Tracker

Add the `gravatar_hash` parameter to your request:

```
https://matomo.example.com/matomo.php?idsite=1&rec=1&url=https://example.com&gravatar_hash=XXXXXXXXX
```

```php
$tracker->setCustomTrackingParameter('gravatar_hash', $sha256EmailAddress);
$tracker->doTrackPageView('Home');
```

### Where is the picture displayed ?

- **Visitor profile**: the picture of the most recent visit with a hash replaces the anonymous avatar.
- **Visits log**: a small round picture is displayed next to the visitor details. You can hide it in the system settings.
- **Live API**: `Live.getLastVisitsDetails` returns `gravatar_hash` and `gravatarUrl` for each visit.
- **Segments**: filter your reports on the `gravatarHash` segment.

### Settings

Go to *Administration > System > General settings > ProfileGravatar*:

- **Default image**: picture displayed when no Gravatar is associated with the hash (mystery person, identicon, retro...).
- **Maximum rating**: pictures rated above this level (G, PG, R, X) are replaced by the default image.
- **Show the Gravatar picture in the visits log**: enabled by default.
