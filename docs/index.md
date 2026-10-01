## Documentation

### 1 - Install the plugin from the marketplace or via GitHub and enable it

Install this plugin from the Marketplace as superuser or download the plugin and install it on your server from FTP in
the `/plugins` folder, then activate it.

Requirements: Matomo 5.10.0 or later.

### 2 - Provide the hash of the visitor email address

The plugin never needs the email address of your visitors: your website provides the **SHA256 hash** of the email
address. Gravatar finds the profile when the email address was trimmed and lowercased before hashing.

### 3 - Send the hash to Matomo

#### With the JavaScript tracker

Add this line to your tracking code, before `_paq.push(['trackPageView']);`:

```javascript
_paq.push(['ProfileGravatar.setGravatarHash', 'a8cfcd74832004951b4408cdb0a5dbcd8c7e52d43f7fe244bf720582e05241da']);
```

The hash is sent with the page views tracked after this call.

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

- **Visitor profile**: the picture of the most recent visit replaces the anonymous avatar.
- **Live API**: `Live.getLastVisitsDetails` returns `gravatar_hash` for each visit.
- **Segments**: filter your reports on the `gravatarHash` segment.

### Settings

Go to *Administration > System > General settings > ProfileGravatar*:

- **Default image**: picture displayed when no Gravatar is associated with the hash (mystery person, identicon, retro...).
- **Maximum rating**: pictures rated above this level (G, PG, R, X) are replaced by the default image.

The Matomo 6 version of the plugin adds a Gravatar hash field to Matomo Tag Manager and the picture in the visits log.
