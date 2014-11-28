	<div class="tab-inner">

	<?php if($module['enable_development_mode'] && $warning_development_files_permission ) {  ?>
		<?php foreach( $warning_development_files_permission as $warning ) { ?>
			<div class="warning"><?php echo $warning; ?></div>
		<?php } ?>

	<?php } ?>	
	<table class="form">
 
		<tr class="highlight">
		<td><?php echo $this->getLang('entry_enable_copyright');?></td>
		<td>
			<select name="themecontrol[enable_custom_copyright]">
			
			<?php foreach( $yesno as $v=>$op ): ?>
				<option value="<?php echo $v;?>" <?php if( $v==$module['enable_custom_copyright']){ ?> selected="selected" <?php } ?>><?php echo $op;?></option>
			<?php endforeach;?>
			</select>
		</td>
	</tr>
		<tr>
			<td><?php echo $this->getLang('copyright');?></td>
			<td>
				<textarea cols="40" rows="3" name="themecontrol[copyright]"><?php echo $module['copyright'];?></textarea>
			</td>
		</tr>
		<tr>
			<td><?php echo $this->getLang('entry_enable_offsidebars');?></td>
			<td>
				<select name="themecontrol[enable_offsidebars]">
					<option value="0" <?php if( $module['enable_offsidebars'] == 0 ){ echo 'selected="selected"';} ;?>><?php echo $this->getLang('no');?></option>
					<option value="1" <?php if( $module['enable_offsidebars'] == 1 ){ echo 'selected="selected"';} ;?>><?php echo $this->getLang('yes');?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $this->getLang('entry_enable_footer_center');?></td>
			<td>
				<select name="themecontrol[enable_footer_center]">
					<option value="0" <?php if( $module['enable_footer_center'] == 0 ){ echo 'selected="selected"';} ;?>><?php echo $this->getLang('no');?></option>
					<option value="1" <?php if( $module['enable_footer_center'] == 1 ){ echo 'selected="selected"';} ;?>><?php echo $this->getLang('yes');?></option>
				</select>
			</td>
		</tr>
	
		
		
	
	</table>
</div>