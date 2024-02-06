(function () {

  function init() {

    var gravatarHash = false;

    Matomo.on('TrackerSetup', function (tracker) {
      tracker.ProfileGravatar = {
        setGravatarHash: function (hash) {
          gravatarHash = hash;
        }
      };
    });

    Matomo.addPlugin('ProfileGravatar', {
      log: function () {
        return '&gravatar_hash='+ gravatarHash;
      }
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
