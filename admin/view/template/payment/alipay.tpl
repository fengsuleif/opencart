<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 ><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
		
	  	<tr>
          <td><span class="required">*</span> <?php echo $entry_partner; ?></td>
          <td><input type="text" name="alipay_partner" value="<?php echo $alipay_partner; ?>" size="50" />
	  <?php if ($error_partner) { ?>
            <span class="error"><?php echo $error_partner; ?></span>
            <?php } ?></td>
        </tr>

		<tr>
          <td><span class="required">*</span> <?php echo $entry_security_code; ?></td>
          <td><input type="text" name="alipay_security_code" value="<?php echo $alipay_security_code; ?>" size="50" />
	  <?php if ($error_secrity_code) { ?>
            <span class="error"><?php echo $error_secrity_code; ?></span>
            <?php } ?></td>
        </tr>
	   <tr>
          <td><span class="required">*</span> <?php echo $entry_seller_email; ?></td>
          <td><input type="text" name="alipay_seller_email" value="<?php echo $alipay_seller_email; ?>" size="50" />
            <?php if ($error_email) { ?>
            <span class="error"><?php echo $error_email; ?></span>
            <?php } ?></td>
        </tr>
		
		<!--
			<tr>
		          <td><span class="required">*</span> <?php echo $entry_anti_phishing; ?></td>
		          <td>
				   <?php if ($alipay_anti_phishing==1) { ?>
						Yes:&nbsp;<input type="radio" name="alipay_anti_phishing" value="1" checked="true"/>&nbsp;&nbsp;
						No:&nbsp;<input type="radio" name="alipay_anti_phishing" value="0"/>&nbsp;&nbsp;
					<?php } else { ?>
						Yes:&nbsp;<input type="radio" name="alipay_anti_phishing" value="1"/>&nbsp;&nbsp;
						No:&nbsp;<input type="radio" name="alipay_anti_phishing" value="0" checked="true"/>&nbsp;&nbsp;
					<?php } ?>
				</td>
			</tr>
		-->
        <tr>
          <td><?php echo $entry_order_status; ?></td>
          <td><select name="alipay_order_status_id">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $alipay_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_status; ?></td>
          <td><select name="alipay_status">
              <?php if ($alipay_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input type="text" name="alipay_sort_order" value="<?php echo $alipay_sort_order; ?>" size="1" /></td>
        </tr>
		 <tr>
          <td>&nbsp;</td>
          <td>使用注意已经存在CNY的人民币汇率设置。Code为CNY</td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>