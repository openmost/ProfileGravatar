(function () {
    return function (parameters, TagManager) {

        // Same as the core Matomo Configuration variable, plus sharing the Gravatar hash with the
        // ProfileGravatar tracker plugin, which sends it with the requests of the trackers of this site
        function shareGravatarHash(config) {
            if (!TagManager.utils.hasProperty(config, 'gravatarHash') || !config.idSite) {
                return;
            }

            var hashes = window.matomoProfileGravatarHashes = window.matomoProfileGravatarHashes || {};
            var hash = config.gravatarHash ? String(config.gravatarHash) : '';

            hashes[String(config.idSite)] = hash;
        }

        this.get = function () {
            var config = {};
            for (var i in parameters) {
                if (i === 'document' || i === 'window' || i === 'container' || i === 'variable' || TagManager.utils.isFunction(parameters[i])) {
                    continue;
                }

                if (TagManager.utils.hasProperty(parameters, i)) {
                    config[i] = parameters.get(i);
                }
            }

            shareGravatarHash(config);

            return config;
        };

        this.toString = function () {
            return '';
        };
    };
})();
