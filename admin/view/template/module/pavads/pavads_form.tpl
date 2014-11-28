<?php echo $header; ?>
<div id="content">
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<?php if ($error_warning) { ?>
	<div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>
	<?php if ($success) { ?>
	<div class="success"><?php echo $success; ?></div>
	<?php } ?>
	<div class="box">
		<div class="heading">
			<h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
			<div class="buttons">
				<a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
				<?php if($check == "edit"){ ?>
				<a onclick="$('#action').val('save_stay');$('#form').submit();" class="button"><?php echo $this->language->get('button_save_stay'); ?></a>
				<?php } ?>
				<a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
			</div>
		</div>
		<div class="content">
			<form action="<?php echo $actionbanner; ?>" method="post" enctype="multipart/form-data" id="form">
				<input name="action" type="hidden" id="action"/>
				<table class="form">
					<tr>
						<td><span class="required">*</span> <?php echo $entry_banner_name; ?></td>
						<td><input type="text" name="name" value="<?php echo $name; ?>" size="100" />
							<?php if ($error_name) { ?>
							<span class="error"><?php echo $error_name; ?></span>
							<?php } ?></td>
					</tr>
					<tr>
						<td><?php echo $entry_status; ?></td>
						<td><select name="status">
								<?php if ($status) { ?>
								<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								<option value="0"><?php echo $text_disabled; ?></option>
								<?php } else { ?>
								<option value="1"><?php echo $text_enabled; ?></option>
								<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
							</select></td>
					</tr>
				</table>


				<div class="vtabs">
					<?php $image_row = 1; ?>
					<?php foreach ($banner_images as $banner_image) { ?>
					<a href="#tab-module-<?php echo $image_row; ?>" id="module-<?php echo $image_row; ?>"><?php echo $tab_image . ' ' . $image_row; ?>&nbsp;<img src="view/image/delete.png" alt="" onclick="$('.vtabs a:first').trigger('click'); $('#module-<?php echo $image_row; ?>').remove(); $('#tab-module-<?php echo $image_row; ?>').remove(); return false;" /></a>
					<?php $image_row++; ?>
					<?php } ?>
					<span id="module-add"><?php echo $button_add_module; ?>&nbsp;<img src="view/image/add.png" alt="" onclick="addImage();" /></span> 
				</div>
				<div id="banners-content">
					<?php $image_row = 1; ?>
					<?php foreach ($banner_images as $banner_image) { ?>
					<div id="tab-module-<?php echo $image_row; ?>" class="vtabs-content">
						<table class="form">
							<tr>
								<td><?php echo $this->language->get('entry_image') ?></td>
								<td class="left"><div class="image"><img src="<?php echo $banner_image['thumb']; ?>" alt="" id="thumb<?php echo $image_row; ?>" />
									<input type="hidden" name="banners[<?php echo $image_row; ?>][image]" value="<?php echo $banner_image['image']; ?>" id="image<?php echo $image_row; ?>"  />
									<br />
									<a onclick="image_upload('image<?php echo $image_row; ?>', 'thumb<?php echo $image_row; ?>');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb<?php echo $image_row; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image<?php echo $image_row; ?>').attr('value', '');"><?php echo $text_clear; ?></a></div>
								</td>
							</tr>
							<tr>
								<td><?php echo $this->language->get('entry_link') ?></td>
								<td><input name="banners[<?php echo $image_row; ?>][link]" value="<?php echo isset($banner_image['link'])?$banner_image['link']:'';?>" type="text"/></td>
							</tr>
							<?php /*
							<tr>
								<td><?php echo $this->language->get('entry_banner_width_height') ?></td>
								<td>
									<input type="text" size="3" value="<?php echo isset($banner_image['width'])?$banner_image['width']:275; ?>" name="banners[<?php echo $image_row; ?>][width]">
									<input type="text" size="3" value="<?php echo isset($banner_image['height'])?$banner_image['height']:254; ?>" name="banners[<?php echo $image_row; ?>][height]">
								</td>
							</tr>
							*/ ?>
							
						</table>

						<div id="language-<?php echo $image_row;?>" class="htabs">
							<?php foreach ($languages as $language) { ?>
							<a href="#tab-language-<?php echo $image_row."-".$language["language_id"]; ?>"><img src="view/image/flags/<?php echo $language["image"]; ?>" title="<?php echo $language["name"]; ?>" /> <?php echo $language["name"]; ?></a>
							<?php } ?>
						</div>

						<?php foreach ($languages as $language) { ?>
						<div id="tab-language-<?php echo $image_row."-".$language["language_id"]; ?>">
							<table class="form">
								<tr>
									<td><?php echo $this->language->get('entry_caption') ?></td>
									<td>
										<textarea cols="60" rows="5" name="banners[<?php echo $image_row; ?>][caption][<?php echo $language['language_id']; ?>]" id="caption-<?php echo $image_row."-".$language['language_id']; ?>">
											<?php echo isset($banner_image['caption'][$language['language_id']])?$banner_image['caption'][$language['language_id']]:''; ?>
										</textarea>
									</td>
								</tr>
							</table>
						</div>
						<?php } ?>

					</div>
					<?php $image_row++; ?>
					<?php } ?>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript"><!--
	$('.vtabs a').tabs();

	<?php $image_row = 1; ?>
	<?php foreach ($banner_images as $banner_image) { ?>
	$('#language-<?php echo $image_row; ?> a').tabs();
	<?php $image_row++; ?>
	<?php } ?> 
//--></script> 

<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
<?php /* // CKEDITOR */ ?>
<?php $image_row = 1; ?>
<?php foreach ($banner_images as $banner_image) { ?>
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('caption-<?php echo $image_row; ?>-<?php echo $language['language_id']; ?>', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>
<?php $image_row++; ?>
<?php } ?>
//--></script> 

<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImage() {
	html  = '<div id="tab-module-'+image_row+'" class="vtabs-content"><table class="form">';
	html += '	<tr>';
	html += '		<td><?php echo $this->language->get("entry_image"); ?></td>';
	html += '		<td class="left"><div class="image"><img src="<?php echo $no_image; ?>" alt="" id="thumb'+image_row+'" />';
	html += '			<input type="hidden" name="banners['+image_row+'][image]" value="<?php echo $no_image; ?>" id="image'+image_row+'"  />';
	html += '			<br />';
	html += '			<a onclick="image_upload(\'image'+image_row+'\', \'thumb'+image_row+'\');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$(\'#thumb'+image_row+'\').attr(\'src\', \''+image_row+'\'); $(\'#image'+image_row+'\').attr(\'value\', \'\');"><?php echo $text_clear; ?></a></div>';
	html += '		</td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td><?php echo $this->language->get("entry_link"); ?></td>';
	html += '		<td><input name="banners['+image_row+'][link]" value="#" type="text"/></td>';
	html += '	</tr>';
	// html += '	<tr>';
	// html += '		<td><?php echo $this->language->get("entry_banner_width_height") ?></td>';
	// html += '		<td>';
	// html += '			<input type="text" size="3" value="275" name="banners['+image_row+'][width]">';
	// html += '			<input type="text" size="3" value="254" name="banners['+image_row+'][height]">';
	// html += '		</td>';
	// html += '	</tr>';
	html += '</table>';
	//Language Tab
	html += '	<div id="language-' + image_row + '" class="htabs">';
					<?php foreach ($languages as $language) { ?>
	html += '		<a href="#tab-language-'+ image_row + '-<?php echo $language["language_id"]; ?>"><img src="view/image/flags/<?php echo $language["image"]; ?>" title="<?php echo $language["name"]; ?>" /> <?php echo $language["name"]; ?></a>';
					<?php } ?>
	html += '	</div>';
	// Text Editor
				<?php foreach ($languages as $language) { ?>
	html += '	<div id="tab-language-'+ image_row + '-<?php echo $language["language_id"]; ?>">';
	html += '		<table class="form">';
	html += '		<tr>';
	html += '			<td><?php echo $this->language->get("entry_caption"); ?></td>';
	html += '			<td><textarea cols="60" rows="5" name="banners['+image_row+'][caption][<?php echo $language['language_id']; ?>]" id="caption-' + image_row + '-<?php echo $language['language_id']; ?>"></textarea></td>';
	html += '		</tr>';
	html += '	</table></div>';
				<?php } ?>
	html += '</div>'

	$('#banners-content').append(html);


	<?php /* //CKEDITOR */ ?>
	<?php foreach ($languages as $language) { ?>
	CKEDITOR.replace('caption-' + image_row + '-<?php echo $language['language_id']; ?>', {
		filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
	});  
	<?php } ?>

	$('#language-' + image_row + ' a').tabs();

	$('#module-add').before('<a href="#tab-module-' + image_row + '" id="module-' + image_row + '"><?php echo $tab_image; ?> ' + image_row + '&nbsp;<img src="view/image/delete.png" alt="" onclick="$(\'.vtabs a:first\').trigger(\'click\'); $(\'#module-' + image_row + '\').remove(); $(\'#tab-module-' + image_row + '\').remove(); return false;" /></a>');

	$('.vtabs a').tabs();
	
	image_row++;
}
//--></script>
<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 700,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script> 
<?php echo $footer; ?>