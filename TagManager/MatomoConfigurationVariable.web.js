(function () {
    // Extension of the Matomo Configuration variable, called with the config built by the core template (and by
    // the other plugins extending it): shares the Gravatar hash with the ProfileGravatar tracker plugin, which
    // sends it with the requests of the trackers of this site
    return function (config, parameters, TagManager) {
        if (!TagManager.utils.hasProperty(config, 'gravatarHash') || !config.idSite) {
            return;
        }

        var hashes = window.matomoProfileGravatarHashes = window.matomoProfileGravatarHashes || {};
        var hash = config.gravatarHash ? String(config.gravatarHash) : '';

        hashes[String(config.idSite)] = hash;
    };
})();
