<?php
global $editing,$course_teacher;
if($editing){
    $head_title="Chỉnh sửa Môn học";
    $action='update';
}else{
    $head_title="Thêm môn học";
    $action='new';
}
?>
<p class="title-manager"><?php echo $head_title;?></p>
<br />
<form class="form" action="course.php" method="POST">
<label for="course-name">Môn học:</label><input type="text" name="name" id="course-name" value="<?php ?>"/>
<label for="course-teacher">Giảng viên:</label><?php teacher_list_select($course_teacher->ID,'course_teacher','course-teacher');?>
    <small><a href="teacher-new.php?redirect_to=<?php echo urlencode(current_url())?>">Thêm Gv</a></small>
<label for="course-faculty">Khoa:</label><select name="faculty_id" id="course-faculty">
    <?php $all_faculties=get_all_faculties();
        foreach($all_faculties as $faculty){
            setup_facultydata($faculty);
    ?>
    <option  value="<?php faculty_id();?>"><?php faculty_name();?></option>
    <?php }?>
  </select>
  <small><a href="faculty-new.php?redirect_to=<?php echo urlencode(current_url())?>">Thêm khoa</a></small>
<label for="course-desc">Mô tả:</label><textarea name="description" id="course-desc"><?php ?></textarea>
<label for="course-maxstudent">Số sinh viên tối đa:</label><input type="text" name="max_student" id="course-maxstudent" value="<?php ?>"/>
<label for="course-credit">Số tín chỉ:</label><input type="text" name="num_credit" id="course-credit" value="<?php ?>"/>

<label for="join-open">Hạn đăng ký từ:</label><input type="text" name="join_open" id="join-open" value="<?php ?>"/>
<label for="join-close">... đến:</label><input type="text" name="join_close" id="join-close" value="<?php ?>"/>
<div class="fixed"></div>
<br/>
<p align="center">
<input type="submit" class="button" name="update-<?php echo $action?>" value="<?php $editing?_e("Cập nhật"):_e("Thêm môn học")?>"/>
<input type="reset" class="button" value="Nhập lại"/>
</p>
<input type="hidden" name="action" value="<?php echo $action?>"/>
<input type="hidden" name="course" value="<?php ?>"/>
</form>