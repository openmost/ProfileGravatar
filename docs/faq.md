## FAQ

__How to install this plugin__

This plugin is available in the official marketplace of Matomo. You have to install it the same way as other plugins:

- Go to the administration panel
- Look for the Marketplace section and select "Plugins" in the dropdown
- Then search for "**ProfileGravatar**", install and activate the plugin.
- Follow the documentation to send the hash of the visitor email address from your tracking code.

__Which versions of Matomo are supported ?__

Version 5.x of the plugin supports Matomo 5.10.0 or later. Use version 6.x of the plugin for Matomo 6.

__Does the plugin need the email address of my visitors ?__

No, never. Your website provides the SHA256 hash of the email address and only this hash is sent to Matomo. Never send
the email address in clear text in the tracking code.

__Is a hash of an email address personal data ?__

Yes. A hash of an email address is a pseudonymous identifier under the GDPR: only send it for visitors who agreed to it,
as you would do for a User ID.

__Is the plugin active for all Matomo users in my instance ?__

Yes, if you choose this plugin for your Matomo instance, all users will be able to use it.

__How can I contribute to this plugin ?__

You can help us develop this plugin by contacting us, or open an issue or a pull request on
[GitHub](https://github.com/openmost/ProfileGravatar). Any way you consider legitimate to contribute is welcome.

__How long will this plugin be maintained ?__

As long as possible. We use Matomo on many projects and are the first users of this plugin: if we see errors, we patch it as fast as possible!
