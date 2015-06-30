(function ($) {
  /**
   * Attach the Auth0 Lock widget to the login form.
   */
  Drupal.behaviors.Auth0 = {
    attach: function (context, settings) {
      $('#auth0-login-form', context).once(function() {
        var a0lock = new Auth0Lock(settings.auth0.client_id, settings.auth0.domain);

        // If sso is enabled.
        if (settings.auth0.options.sso) {
          a0lock.$auth0.getSSOData(function(err, data) {
            if (!err && data.sso) {
              // there is! redirect to Auth0 for SSO
              a0lock.$auth0.signin(settings.auth0.options); 
            } else {
              a0lock.show(settings.auth0.options);
            }
          });
        }
        // No sso, show the widget.
        else {
          a0lock.show(settings.auth0.options);
        }
      })
    }
  }
})(jQuery);

// Hacky backport of D7 behavior to D6
Auth0Attach = Drupal.behaviors.Auth0.attach;
Drupal.behaviors.Auth0 = function(context) {Auth0Attach(context, Drupal.settings);};

// Hacky polyfill for .once.
if (!jQuery.fn.once) {
  jQuery.fn.once = function(fn) {
    this.filter(':not(.once-processed)').addClass('.once-processed').each(fn);
  }
}
