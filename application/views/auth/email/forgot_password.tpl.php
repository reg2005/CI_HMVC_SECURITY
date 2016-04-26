<html>
<body>
	<h3><?php echo sprintf(lang('email_forgot_password_heading'), $identity);?></h3>
	<p><?php echo sprintf(lang('email_forgot_password_subheading'), anchor('app/windows/restore_pass?request_code='. $forgotten_password_code. '&nologon&style=2&buttons=0', lang('email_forgot_password_link')));?></p>
</body>
</html>