<?php

echo $header; ?>
<style type="text/css">
.box-banners div.active {
	border: solid 1px red;
}
.box-banners div {
	width: 171px;
	height: 57px;
	float: left;
	cursor: pointer;
	border: solid 1px #f3f3f3;
	margin: 6px;
}
</style>
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
				<a onclick="$('#action').val('save_stay');$('#form').submit();" class="button"><?php echo $button_save_stay; ?></a>
				<a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
			</div>
		</div>
		<div class="content">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<input name="action" type="hidden" id="action"/>  

			<div id="tabs-modules" class="htabs">
				<a href="#tab-modules"><?php echo $this->language->get('tab_module_assign'); ?></a>
				<a href="#tab-data"><?php echo $this->language->get('tab_banners'); ?></a>
			</div>
			<div id="tab-modules">
				<div class="vtabs">
					<?php $module_row = 1; ?>
					<?php foreach ($modules as $module) { ?>
					<a href="#tab-module-<?php echo $module_row; ?>" id="module-<?php echo $module_row; ?>"><?php echo $tab_module . ' ' . $module_row; ?>&nbsp;<img src="view/image/delete.png" alt="" onclick="$('.vtabs a:first').trigger('click'); $('#module-<?php echo $module_row; ?>').remove(); $('#tab-module-<?php echo $module_row; ?>').remove(); return false;" /></a>
					<?php $module_row++; ?>
					<?php } ?>
					<span id="module-add"><?php echo $button_add_module; ?>&nbsp;<img src="view/image/add.png" alt="" onclick="addModule();" /></span> 
				</div>
				<?php $module_row = 1; ?>
				<?php foreach ($modules as $module) { ?>
				<div id="tab-module-<?php echo $module_row; ?>" class="vtabs-content">
					<table class="form">
						<tr>
							<td><?php echo $this->language->get('prefix_class'); ?></td>
							<td>
								<input name="pavads_module[<?php echo $module_row; ?>][prefix]" value="<?php echo (isset($module['prefix'])?$module['prefix']:''); ?>"/>
							</td>
						</tr>
						<tr>
							<td><?php echo $entry_layout; ?></td>
							<td>
								<select name="pavads_module[<?php echo $module_row; ?>][layout_id]">
									<?php foreach ($layouts as $layout) { ?>
									<?php if ($layout['layout_id'] == $module['layout_id']) { ?>
									<option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
									<?php } else { ?>
									<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
									<?php } ?>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td><?php echo $entry_position; ?></td>
							<td>
								<select name="pavads_module[<?php echo $module_row; ?>][position]">
									<?php foreach( $positions as $pos ) { ?>
									<?php if ($pos == $module['position']) { ?>
									<option value="<?php echo $pos;?>" selected="selected"><?php echo $this->language->get('text_'.$pos); ?></option>
									<?php } else { ?>
									<option value="<?php echo $pos;?>"><?php echo $this->language->get('text_'.$pos); ?></option>
									<?php } ?>
									<?php } ?> 
								</select>
							</td>
						</tr>
						<tr>
							<td><?php echo $entry_status; ?></td>
							<td>
								<select name="pavads_module[<?php echo $module_row; ?>][status]">
									<?php if ($module['status']) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td><?php echo $entry_sort_order; ?></td>
							<td><input type="text" name="pavads_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo isset($module['sort_order'])?$module['sort_order']:''; ?>" size="3" /></td>
						</tr>
						<tr>
							<td><?php echo $this->language->get('entry_banners'); ?></td>
							<td>
								<select name="pavads_module[<?php echo $module_row; ?>][banner]">
									<option value="0"><?php echo $this->language->get('text_none'); ?></option>
									<?php foreach( $selectbanners as $banner ) { ?>
									<?php if ($banner['banner_id'] == $module['banner']) { ?>
									<option value="<?php echo $banner['banner_id'];?>" selected="selected"><?php echo $banner['name']; ?></option>
									<?php } else { ?>
									<option value="<?php echo $banner['banner_id'];?>"><?php echo $banner['name']; ?></option>
									<?php } ?>
									<?php } ?> 
								</select>
							</td>
						</tr>
						<tr>
							<td><?php echo $entry_banner_layouts; ?></td>
							<td>
								<div class="box-banners pavlayout-<?php echo $module_row; ?> clearfix">
									<div class="img1" style="background:url(view/image/pavads/layout1.png);"></div>
									<div class="img2" style="background:url(view/image/pavads/layout2.png);"></div>
									<div class="img3" style="background:url(view/image/pavads/layout3.png);"></div>
									<input name="pavads_module[<?php echo $module_row; ?>][banner_layout]" type="hidden" id="banner_layout_<?php echo $module_row; ?>" value="<?php echo $module['banner_layout']; ?>">
								</div>
							</td>
						</tr>
					</table>
				</div>
				<?php $module_row++; ?>
				<?php } ?>
			</div>

			<!-- tab data -->
			<div id="tab-data">
				<div class="content">
					<div style="float:right;padding-bottom:7px;">
						<a href="<?php echo $createnew; ?>" class="button"><?php echo $this->language->get('create_new'); ?></a>
						<a onclick="$('#action').val('delete');$('#form').submit();" class="button"><?php echo $this->language->get('delete_banner'); ?></a>
					</div>
					<table class="list">
						<thead>
						<tr>
							<td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
							<td class="left"><?php if ($sort == 'name') { ?>
							<a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
							<?php } ?></td>
							<td class="left"><?php if ($sort == 'status') { ?>
							<a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
							<?php } else { ?>
							<a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
							<?php } ?></td>
							<td class="right"><?php echo $column_action; ?></td>
						</tr>
						</thead>
						<tbody>
							<?php if ($banners) { ?>
							<?php foreach ($banners as $banner) { ?>
							<tr>
								<td style="text-align: center;"><?php if ($banner['selected']) { ?>
								<input type="checkbox" name="selected[]" value="<?php echo $banner['banner_id']; ?>" checked="checked" />
								<?php } else { ?>
								<input type="checkbox" name="selected[]" value="<?php echo $banner['banner_id']; ?>" />
								<?php } ?></td>
								<td class="left"><?php echo $banner['name']; ?></td>
								<td class="left"><?php echo $banner['status']; ?></td>
								<td class="right"><?php foreach ($banner['action'] as $action) { ?>
								[ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
								<?php } ?></td>
							</tr>
							<?php } ?>
							<?php } else { ?>
							<tr>
								<td class="center" colspan="4"><?php echo $text_no_results; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<div class="pagination"><?php echo $pagination; ?></div>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
  
<script type="text/javascript"><!--
<?php $module_row = 1; ?>
<?php foreach ($modules as $module) { ?>
	$(".pavlayout-<?php echo $module_row?> div").click( function(){
		$("#banner_layout_<?php echo $module_row?>").val( $(this).attr("class") );
		$(".pavlayout-<?php echo $module_row?> div").removeClass( "active" );
		$(this).addClass( "active" );
	} );
	if($("#banner_layout_<?php echo $module_row?>").val()){ 
		$(".pavlayout-<?php echo $module_row?>").find("."+ $("#banner_layout_<?php echo $module_row?>").val() ).addClass( "active" );
	}
<?php $module_row++; ?>
<?php } ?>
-->				
</script>

<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;
function addModule() {	
	html  = '<div id="tab-module-' + module_row + '" class="vtabs-content">';
	html += '	<table class="form">';
	html += '		<tr>';
	html += '			<td><?php echo $this->language->get("prefix_class");?></td>';
	html += '			<td class="left"><input name="pavads_module['+module_row+'][prefix]" value="preclass'+module_row+'"></td>';
	html += '		</tr>';
	html += '		<tr>';
	html += '			<td><?php echo $entry_layout; ?></td>';
	html += '			<td>';
	html += '				<select name="pavads_module['+module_row+'][layout_id]">';
								<?php foreach ($layouts as $layout) { ?>
								<?php if ($layout['layout_id'] == 1) { ?>
	html += '					<option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>';
								<?php } else { ?>
	html += '					<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
								<?php } ?>
								<?php } ?>
	html += '				</select>';
	html += '			</td>';
	html += '		</tr>';
	html += '		<tr>';
	html += '			<td><?php echo $entry_position; ?></td>';
	html += '			<td>';
	html += '				<select name="pavads_module['+module_row+'][position]">';
								<?php foreach( $positions as $pos ) { ?>
	html += '					<option value="<?php echo $pos;?>"><?php echo $this->language->get("text_".$pos); ?></option>';
								<?php } ?> 
	html += '				</select>';
	html += '			</td>';
	html += '		</tr>';

	html += '		<tr>';
	html += '			<td><?php echo $entry_status; ?></td>';
	html += '			<td>';
	html += '				<select name="pavads_module['+module_row+'][status]">';
	html += '					<option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
	html += '					<option value="0"><?php echo $text_disabled; ?></option>';
	html += '				</select>';
	html += '			</td>';
	html += '		</tr>';
	html += '		<tr>';
	html += '			<td><?php echo $entry_sort_order; ?></td>';
	html += '			<td><input type="text" name="pavads_module['+module_row+'][sort_order]" value="1" size="3" /></td>';
	html += '		</tr>';
	html += '		<tr>';
	html += '			<td><?php echo $this->language->get("entry_banners"); ?></td>';
	html += '			<td>';
	html += '				<select name="pavads_module['+module_row+'][banner]">';
	html += '					<option value="0"><?php echo $this->language->get("text_none"); ?></option>';
								<?php foreach( $selectbanners as $banner ) { ?>
								<?php if ($banner['banner_id'] == 1) { ?>
	html += '					<option value="<?php echo $banner["banner_id"];?>" selected="selected"><?php echo $banner["name"]; ?></option>';
								<?php } else { ?>
	html += '					<option value="<?php echo $banner["banner_id"];?>"><?php echo $banner["name"]; ?></option>';
								<?php } ?>
								<?php } ?> 
	html += '				</select>';
	html += '			</td>';
	html += '		</tr>';
	html += '		<tr>';
	html += '			<td><?php echo $entry_banner_layouts; ?></td>';
	html += '			<td>';
	html += '				<div class="box-banners pavlayout-'+module_row+' clearfix">';
	html += '					<div class="img1" style="background:url(view/image/pavads/layout1.png);"></div>';
	html += '					<div class="img2" style="background:url(view/image/pavads/layout2.png);"></div>';
	html += '					<div class="img3" style="background:url(view/image/pavads/layout3.png);"></div>';
	html += '					<input name="pavads_module['+module_row+'][banner_layout]" type="hidden" id="banner_layout_'+module_row+'" value="img1">';
	html += '				</div>';
	html += '			</td>';
	html += '		</tr>';

	html += '	</table>';
	html += '</div>';


	
	$('#tab-modules').append(html);

	//active layout
	var rs = module_row; 
	$(".pavlayout-"+rs+" div").click( function(){
		$("#banner_layout_"+rs).val( $(this).attr("class") );
		$(".pavlayout-"+rs+" div").removeClass("active");
		$(this).addClass( "active" );
	} );
	if($("#banner_layout_" + rs).val()){ 
		$(".pavlayout-"+rs).find("."+ $("#banner_layout_"+rs).val() ).addClass("active");
	}
	
	$('#language-' + module_row + ' a').tabs();
	
	$('#module-add').before('<a href="#tab-module-' + module_row + '" id="module-' + module_row + '"><?php echo $tab_module; ?> ' + module_row + '&nbsp;<img src="view/image/delete.png" alt="" onclick="$(\'.vtabs a:first\').trigger(\'click\'); $(\'#module-' + module_row + '\').remove(); $(\'#tab-module-' + module_row + '\').remove(); return false;" /></a>');
	
	
	$('.vtabs a').tabs();
	
	//$('#module-' + module_row).trigger('click');
	
	module_row++;

}
//--></script>

<script type="text/javascript"><!--
$("#tabs-modules a").tabs();
$('#tabs-modules a').click( function(){
	$.cookie("sactived_tab", $(this).attr("href") );
} );

if( $.cookie("sactived_tab") !="undefined" ){
	$('#tabs-modules a').each( function(){ 
		if( $(this).attr("href") ==  $.cookie("sactived_tab") ){
			$(this).click();
			return ;
		}
	} );
}
$('.vtabs a').tabs();
//--></script> 

<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: "<?php echo $this->language->get('text_image_manager'); ?>",
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
