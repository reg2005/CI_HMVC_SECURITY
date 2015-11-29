<html>
<body>
	<h3><?php echo sprintf(lang('email_activate_heading'), $identity);?></h3>
	<p><?php echo lang('email_activate_subheading') ?></p>
	<a href="<?php echo site_url().'dev/user/profile/activate/'. $id .'/'. $activation; ?>"><?php echo lang('email_activate_link') ?></a>
</body>
</html>