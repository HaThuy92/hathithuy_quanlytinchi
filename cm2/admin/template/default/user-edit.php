<?php
global $editing,$usertype;

switch($usertype){
    case 'student': 
    if($editing){
        $head_title="Chỉnh sửa sinh viên";
        $action='update';
    }else{
        $head_title="Thêm sinh viên mới";
        $action='new';
    }

?>
<p class="title-manager"><?php echo $head_title;?></p>
<br />
<form class="form" action="student.php" method="POST">
<label for="full_name">Họ tên:</label><input type="text" name="full_name" id="full_name" value="<?php ?>"/>
<label for="username">Tên đăng nhập:</label><input type="text" name="username" id="username" value="<?php ?>"/>
<label for="code">Mã số SV:</label><input type="text" name="code" id="code" value="<?php ?>"/>
<label for="birthday">Ngày sinh:</label><input type="text" name="birthday" id="birthday" value="<?php ?>"/>
<label for="faculty">Khoa:</label><select name="faculty_id" id="faculty">
    <?php $all_faculties=get_all_faculties();
        foreach($all_faculties as $faculty){
            setup_facultydata($faculty);
    ?>
    <option  value="<?php faculty_id();?>"><?php faculty_name();?></option>
    <?php }?>
  </select>
  <small><a href="faculty-new.php?redirect_to=<?php echo urlencode(current_url())?>">Thêm khoa</a></small>
<label for="address">Địa chỉ:</label><textarea name="address" id="address"><?php ?></textarea>
<label for="email">Email:</label><input type="text" name="email" id="email" value="<?php ?>"/>
<label for="gender">Giới tính:</label><select name="gender" id="gender">
    <option  value="1">Nam</option>
    <option  value="0">Nữ</option>
  </select>

<label for="password">Mật khẩu:<?php if($editing)_e("(Nhập nếu muốn đổi)");?></label><input type="text" name="password" value=""/> 
<div class="fixed"></div>
<br/>
<p align="center">
<input type="submit" class="button" name="update-<?php echo $action?>" value="<?php $editing?_e("Cập nhật"):_e("Thêm sinh viên")?>"/>
<input type="reset" class="button" value="Nhập lại"/>
</p>
<input type="hidden" name="action" value="<?php echo $action?>"/>
<input type="hidden" name="student" value="<?php user_id()?>"/>
</form>
<?php 
if($editing){
?>
<div class="student-courses-list">
<strong>Các khóa học đã đăng ký:</strong>
<br />
<form action="student.php" method="POST">
<?php course_list_select(0,'student_course','student_course');?>

<input type="image" src="<?php admin_template_url()?>/img/add.gif" value="1" alt="Add this course to current student" name="submit"/>
<input type="hidden" name="action" value="addcourse"/>
<input type="hidden" name="student" value="<?php user_id()?>"/>
</form>

<br />
<table class="fixed student-courses">

<?php
    
    $courses=get_courses_by_userid();
    foreach($courses as $course){
        setup_coursedata($course);
?>
    <tr <?php class_alternate();?>>
    <td class="course-name">
        <a href="<?php editcourselink()?>"><?php course_name()?>
    
    </td>
    <td class="course-remove">
  
    <a href="student.php?action=rmcourse&student_course=<?php course_id()?>&student=<?php user_id()?>"><img src="<?php admin_template_url()?>/img/remove.gif"/></a>
  
    </td>
    </tr>

<?php
    }
?>
</table>

</div>

<?php
}
?>
<?php break;
    case 'teacher':
        if($editing){
        $head_title="Chỉnh sửa giảng viên";
        $action='update';
    }else{
        $head_title="Thêm giảng viên mới";
        $action='new';
    }
?>
<p class="title-manager"><?php echo $head_title;?></p>
<br />
<form class="form" action="teacher.php" method="POST">
<label for="full_name">Họ tên</label><input type="text" id="full_name" name="full_name" value="<?php ?>"/>
<label for="username">Tên đăng nhập:</label> <input type="text" id="username" name="username" value="<?php ?>"/>
<label for="code">Mã số GV:</label> <input type="text" id="code" name="code" value="<?php ?>"/></p>
<label for="birthday">Ngày sinh:</label> <input type="text" id="birthday" name="birthday" value="<?php ?>"/>
<label for="faculty_id">Khoa:</label> <select id="faculty_id" name="faculty_id">
    <?php $all_faculties=get_all_faculties();
        foreach($all_faculties as $faculty){
            setup_facultydata($faculty);
    ?>
    <option  value="<?php faculty_id();?>"><?php faculty_name();?></option>
    <?php }?>
  </select>
  <small><a href="faculty-new.php?redirect_to=<?php echo urlencode(current_url())?>">Thêm khoa</a></small>
<label for="address">Địa chỉ:</label><textarea id="address" name="address"><?php ?></textarea>
<label for="email">Email:</label><input type="text" id="email" name="email" value="<?php ?>"/>
<label for="gender">Giới tính:</label> <select id="gender" name="gender">
    <option  value="1">Nam</option>
    <option  value="0">Nữ</option>
  </select>

<label for="password">Mật khẩu:<?php if($editing)_e("(Nhập nếu muốn đổi)");?></label><input type="text" id="password" name="password" value=""/>
<div class="fixed"></div>
<br/>
<p align="center">
<input type="submit" class="button" name="update-<?php echo $action?>" value="<?php $editing?_e("Cập nhật"):_e("Thêm giảng viên")?>"/>
<input type="reset" class="button" value="Nhập lại"/>
</p>
<input type="hidden" name="action" value="<?php echo $action?>"/>
<input type="hidden" name="teacher" value="<?php user_id()?>"/>
</form>
<?php }?>