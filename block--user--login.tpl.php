<?php global $base_root; ?>
<?php
$state = isset($_SESSION['auth0_state'])?$_SESSION['auth0_state']:false;
if (!$state) {
    $state = $_SESSION['auth0_state'] = uniqid();
}

?>
<script id="auth0" src="<?php echo variable_get('auth0_widget_cdn');?>"></script>
<script type="text/javascript">

    var widget = new Auth0Widget({
        domain:         '<?php echo variable_get("auth0_domain")?>',
        chrome:         true,
        clientID:       '<?php echo variable_get("auth0_client_id")?>',
        callbackURL:    '<?php echo "$base_root/auth0/callback"?>',
        state:          '<?php echo $state ?>',
        showSignup:     <?php echo variable_get('auth0_allow_signup')?'true':'false'?>,
        dict:           { signin: { title: '<?php echo variable_get("auth0_form_title","Sign In")?>' } }
    });

    widget.signin({
        container:      'auth0-login-form',
    });

</script>

<style type="text/css">
<?php echo variable_get("auth0_login_css")?>
</style>

<div id="auth0-login-form" style=" min-height: 440px;"></div>