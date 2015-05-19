<?php global $base_root; ?>
<?php

$domain = filter_var(variable_get("auth0_domain"), FILTER_SANITIZE_STRING);
$client_id = filter_var(variable_get("auth0_client_id"), FILTER_SANITIZE_STRING);

$params = array(
    'callbackURL' => filter_var("$base_root/auth0/callback", FILTER_VALIDATE_URL),
    'authParams' => array(
        'state' => filter_var(variable_get('$state'), FILTER_SANITIZE_STRING),
    ),
    'disableSignupAction' => !filter_var(variable_get("auth0_allow_signup"), FILTER_VALIDATE_BOOLEAN),
    'container' => 'auth0-login-form'
);

?>

<style type="text/css">
<?php echo variable_get("auth0_login_css")?>
</style>

<div id="auth0-login-form" style=" min-height: 440px;"></div>

<script id="auth0" src="<?php echo filter_var(variable_get('auth0_widget_cdn'), FILTER_VALIDATE_URL);?>"></script>
<script type="text/javascript">

    var lock = new Auth0Lock('<?php echo $client_id; ?>', '<?php echo $domain; ?>');

    lock.show(<?php echo json_encode($params); ?>);

</script>
