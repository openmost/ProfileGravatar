(function () {

    function init() {

        Matomo.on('TrackerSetup', function (tracker) {
            tracker.ProfileGravatar = {
                setGravatarHash: function (gravatarHash) {

                    var request = "ping=1";
                    request += "&gravatar_hash=" + gravatarHash;

                    tracker.trackRequest(request);
                }
            };
        });

    }

    if ('object' === typeof window.Matomo) {
        init();
    } else {
      // tracker might not be loaded yet
        if ('object' !== typeof window.matomoPluginAsyncInit) {
            window.matomoPluginAsyncInit = [];
        }

        window.matomoPluginAsyncInit.push(init);
    }

})();
