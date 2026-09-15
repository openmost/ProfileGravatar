(function () {

  function init() {

    // Gravatar accepts SHA256 (recommended) or MD5 hashes
    var HASH_PATTERN = /^(?:[0-9a-f]{64}|[0-9a-f]{32})$/;

    function normalizeHash(hash) {
      if ('string' !== typeof hash) {
        return '';
      }

      hash = hash.replace(/^\s+|\s+$/g, '').toLowerCase();

      return HASH_PATTERN.test(hash) ? hash : '';
    }

    // Hash set in the "Gravatar hash" field of the Tag Manager "Matomo Configuration" variable, per site
    function getTagManagerHash(tracker) {
      var hashes = window.matomoProfileGravatarHashes;
      if (!hashes || 'function' !== typeof tracker.getSiteId) {
        return '';
      }

      var idSite = String(tracker.getSiteId());

      return Object.prototype.hasOwnProperty.call(hashes, idSite) ? normalizeHash(hashes[idSite]) : '';
    }

    Matomo.on('TrackerSetup', function (tracker) {
      var gravatarHash = '';

      tracker.ProfileGravatar = {
        setGravatarHash: function (hash) {
          gravatarHash = normalizeHash(hash);
        },
        resetGravatarHash: function () {
          gravatarHash = '';
        },
        getGravatarHash: function () {
          return gravatarHash || getTagManagerHash(tracker);
        }
      };
    });

    // Send the hash with every request of the tracker, so it is also stored when it is set
    // after the page view (e.g. login in a single page application followed by an event)
    function appendGravatarHash(params) {
      var tracker = params && params.tracker;
      if (!tracker || !tracker.ProfileGravatar) {
        return '';
      }

      var hash = tracker.ProfileGravatar.getGravatarHash();

      return hash ? '&gravatar_hash=' + encodeURIComponent(hash) : '';
    }

    Matomo.addPlugin('ProfileGravatar', {
      log: appendGravatarHash,
      link: appendGravatarHash,
      goal: appendGravatarHash,
      event: appendGravatarHash,
      sitesearch: appendGravatarHash,
      ecommerce: appendGravatarHash,
      contentImpression: appendGravatarHash,
      contentInteraction: appendGravatarHash,
      ping: appendGravatarHash
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
