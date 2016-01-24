<?php
global $editing,$redirect_to;

    if($editing){
        $head_title="Chỉnh sửa khoa";
        $action='update';
    }else{
        $head_title="Thêm khoa mới";
        $action='new';
    }

?>

<p class="title-manager"><?php echo $head_title;?></p>
<br />
<form class="form" action="faculty.php" method="POST">
<label for="faculty_name">Tên khoa:</label><input type="text" id="faculty_name" name="faculty_name" value="<?php ?>"/>

<label for="faculty_desc">Mô tả:</label><textarea name="faculty_desc" id="faculty_desc"><?php ?></textarea>
<div class="fixed"></div>
<br/>
<p align="center">
<input type="submit" class="button" name="update-<?php echo $action?>" value="<?php $editing?_e("Cập nhật"):_e("Thêm khoa mới")?>"/>
<input type="reset" class="button" value="Nhập lại"/>
</p>
<input type="hidden" name="action" value="<?php echo $action?>"/>
<input type="hidden" name="faculty" value="<?php faculty_id()?>"/>
<input type="hidden" name="redirect_to" value="<?php echo $redirect_to;?>"/>
</form>