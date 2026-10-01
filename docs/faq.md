## FAQ

__How to install this plugin__

This plugin is available in the official marketplace of Matomo. You have to install it the same way as other plugins:

- Go to the administration panel
- Look for the Marketplace section and select "Plugins" in the dropdown
- Then search for "**ProfileGravatar**", install and activate the plugin.
- Follow the documentation to send the Gravatar hash with your tracking code or your Tag Manager configuration.

__Which versions of Matomo are supported ?__

Version 6.x of the plugin supports Matomo 6 (PHP 8.1+, MySQL 8.0+ or MariaDB 10.6+). Use version 5.x of the plugin for Matomo 5.

__Does the plugin need the email address of my visitors ?__

No, never. Your website provides the SHA256 hash of the email address (for example in the data layer with the
`sha256_email_address` key) and only this hash is sent to Matomo. Never push the email address in clear text in the
data layer or in the tracking code.

__Where is the "Gravatar hash" field in Matomo Tag Manager ?__

In the **Matomo Configuration** variable, right after the **User ID** field. Select a Data-Layer variable containing the
hash, then publish a new version of your container. The field is only displayed while the ProfileGravatar plugin is
activated.

__Why is the anonymous avatar still displayed in the visitor profile ?__

The picture is only displayed when at least one visit of the visitor has a valid hash. Check that:

- the hash is available before the page view is tracked (or sent with a later tracking request),
- the hash is a SHA256 (64 characters) or MD5 (32 characters) hexadecimal string, other values are ignored,
- the email address was trimmed and lowercased before hashing, otherwise Gravatar does not find the profile and displays the default image.

__Is a hash of an email address personal data ?__

Yes. A hash of an email address is a pseudonymous identifier under the GDPR: only send it for visitors who agreed to it,
as you would do for a User ID. The hash is stored in the `gravatar_hash` column of the visits and is deleted with the raw
data of the visits.

__Does Gravatar receive data from my Matomo instance ?__

When a Matomo user opens a visitor profile or the visits log, the browser loads the pictures from `gravatar.com`, so
Gravatar receives the hash and the IP address of the Matomo user. No request is made to Gravatar from the tracked website.

__Why do I see "false" values in the gravatarHash segment ?__

Versions prior to 6.0.0 stored `false` (or `0`) for visits without a hash. These values are now ignored everywhere in
the plugin and are no longer tracked. They remain in the raw data of old visits, until your raw data is deleted.

__Is the plugin active for all Matomo users in my instance ?__

Yes, if you choose this plugin for your Matomo instance, all users will be able to use it.

__How can I contribute to this plugin ?__

You can help us develop this plugin by contacting us, or open an issue or a pull request on
[GitHub](https://github.com/openmost/ProfileGravatar). Any way you consider legitimate to contribute is welcome.

__How long will this plugin be maintained ?__

As long as possible. We use Matomo on many projects and are the first users of this plugin: if we see errors, we patch it as fast as possible!
