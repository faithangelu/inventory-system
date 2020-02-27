<?php echo form_open(site_url('stores/file_import'), array('class'=>'dropzone', 'id'=>'dropzone')); ?>
<div class="fallback">
	<input name="file" type="file" class="hide" />
</div>
<?php echo form_close(); ?>