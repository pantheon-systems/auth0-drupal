<?php 

global $base_root; 


$sso_enabled = filter_var(variable_get("auth0_sso"), FILTER_VALIDATE_BOOLEAN);
$domain = filter_var(variable_get("auth0_domain"), FILTER_SANITIZE_STRING);
$client_id = filter_var(variable_get("auth0_client_id"), FILTER_SANITIZE_STRING);

$params = array(
    'callbackURL' => filter_var("$base_root/auth0/callback", FILTER_VALIDATE_URL),
    'authParams' => array(
        'state' => filter_var(variable_get('$state'), FILTER_SANITIZE_STRING),
    ),
    'disableSignupAction' => !filter_var(variable_get("auth0_allow_signup"), FILTER_VALIDATE_BOOLEAN),
    'container' => 'auth0-login-form',
    'sso' => $sso_enabled,
    'rememberLastLogin' => $sso_enabled
);

?>

<style type="text/css">
<?php echo variable_get("auth0_login_css")?>
</style>

<div id="auth0-login-form" style=" min-height: 440px;"></div>

<script id="auth0" src="<?php echo filter_var(variable_get('auth0_widget_cdn'), FILTER_VALIDATE_URL);?>"></script>
<script type="text/javascript">

    var a0lock = new Auth0Lock('<?php echo $client_id; ?>', '<?php echo $domain; ?>');

    var a0options = <?php echo json_encode($params); ?>;

<?php 

$ignoreSSO = false;
if (isset($_SESSION) && isset($_SESSION['ignoreSSO'])) {
    $ignoreSSO = $_SESSION['ignoreSSO'];
    unset($_SESSION['ignoreSSO']);
}

if (!$ignoreSSO && $sso_enabled) { ?>
    a0lock.$auth0.getSSOData(function(err, data) {
		if (!err && data.sso) {
			// there is! redirect to Auth0 for SSO
			a0lock.$auth0.signin(a0options); 
		} else {
			a0lock.show(a0options);
		}
	});
<?php } else { ?>

	a0lock.show(a0options);

<?php } ?>

</script>
