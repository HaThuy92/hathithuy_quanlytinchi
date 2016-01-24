<?php
get_header();
?>
<?php if(!$editing):?>
<p class="item_top">Thông tin cá nhân (<small><a href="?cm=profile&action=edit">Chỉnh sửa</a></small>)</p>
<div class="user-info">
Họ tên: <?php user_fullname();?> <br />
Mã số sinh viên: <?php user_code();?> <br />
Khoa: <?php faculty_name();?> <br />
Email: <?php user_email();?><br />
Ngày sinh: <?php user_birthday();?><br />
Địa chỉ: <?php user_address();?><br />
</div>
<?php else:?>
<p class="item_top">Chỉnh sửa thông tin cá nhân</p>
<div class="user-info">
<small>Nhập mật khẩu hiện tại để tiếp tục, chỉ nhập mật khẩu mới khi muốn thay đổi</small>
<?php if($message){?>
<div class="message"><?php echo $message;?></div>
<?php }?>
<form action="profile-update.php" method="POST">
<label><span class="label">Mật khẩu hiện tại:</span>  <input type="password" name="password" value=""/></label>
<label><span class="label">Họ tên:</span>  <input type="text" name="full_name" value="<?php user_fullname();?>"/></label>
<label><span class="label">Email: </span> <input type="text" name="email" value="<?php user_email();?>"/></label>
<label><span class="label">Ngày sinh:</span> <input type="text" name="birdthday" value="<?php user_birthday();?>"/></label>
<label><span class="label">Địa chỉ:</span> <input type="text" name="address" value="<?php user_address();?>"/></label>
<label><span class="label">Mật khẩu mới:</span> <input type="password" name="newpass" value=""/></label>
<label><span class="label">Nhập lại:</span> <input type="password" name="newpass_retype" value=""/></label>
<input type="hidden" name="action" value="update"/>
<input type="submit" value="<?php _e("Cập nhật");?>"/> 
<input type="reset" value="<?php _e("Làm lại");?>"/> 
</form>
</div>
<?php endif;?>
<?php
get_footer();
?>