<div id="auth0-login-form" style=" min-height: 440px;"></div>

<script type="text/javascript">

    var a0lock = new Auth0Lock('<?php echo $client_id; ?>', '<?php echo $domain; ?>');

    var a0options = <?php echo $params_json; ?>;

<?php if ($sso_enabled) { ?>
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
