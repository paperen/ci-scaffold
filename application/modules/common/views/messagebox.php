<div class="alert alert-block alert-<?php echo $type; ?> messagebox" msgcode="<?php echo $code; ?>">
	<h4 class="alert-heading"><?php echo $title; ?></h4>
	<?php echo $content; ?>
	<?php echo $extra; ?>
</div>
<?php if( $redirect_url ) { ?>
<script>
	setTimeout("window.location.href='<?php echo $redirect_url; ?>';", <?php echo Common_Messagebox_Module::TIMEOUT * 1000; ?>);
</script>
<?php } ?>
