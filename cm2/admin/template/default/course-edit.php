<?php
global $all_courses,$offset;
?>
<p class="title-manager">Quản lý môn học</p>
<div class="float-right">
<form action="" method="GET">

<input class="search-box" type="text" name="s" value="<?php if(isset($_GET['s'])) echo strip_tags($_GET['s'])?>"/>
<input type="submit" class="button" value="Tìm"/>
</form>
</div>
<div class="pagenavi">
<?php course_pagelink();?>
</div>

<form action="course.php" method="POST">
<table class="widefat fixed" cellspacing="0">
<thead>
	<tr>
    <th scope="col" class="column-stt">STT</th>
	<th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox" /></th>
	<th scope="col" id="cname" class="manage-column column-cname" style="">Môn học</th>
	<th scope="col" id="cfaculty" class="manage-column column-cfaculty" style="">Khoa</th>
	<th scope="col" id="ccredit" class="manage-column column-ccredit" style="">Số tín chỉ</th>
    <th scope="col" id="numstudent" class="manage-column column-numstudent" style="">Số sinh viên</th>
    <th scope="col" id="cexpire" class="manage-column column-cexpire" style="">Hạn đăng ký</th>
	</tr>
</thead>
<tfoot>
	<tr>
    <th scope="col" class="column-stt">STT</th>
	<th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox" /></th>
	<th scope="col" id="cname" class="manage-column column-cname" style="">Môn học</th>
	<th scope="col" id="cfaculty" class="manage-column column-cfaculty" style="">Khoa</th>
	<th scope="col" id="ccredit" class="manage-column column-ccredit" style="">Số tín chỉ</th>
    <th scope="col" id="numstudent" class="manage-column column-numstudent" style="">Số sinh viên</th>
    <th scope="col" id="cexpire" class="manage-column column-cexpire" style="">Hạn đăng ký</th>
	</tr>
</tfoot>
<tbody id="the-course-list" class="list:course">
<?php foreach((array)$all_courses as $course){
    setup_coursedata($course);
	setup_facultydata(get_facultydata(get_course_facultyid()));
    ?>
<tr id="course-<?php course_id();?>" valign="top"<?php class_alternate();?>>
<td class="column-stt"><?php echo ++$offset;?></td>
<th scope="row" class="check-column"><input type="checkbox" name="delete_courses[]" value="<?php course_id();?>" /></th>
    <td class="column-cname"><?php course_name();?>
        <br />
    <div class="row-actions">
    <span class='edit'><a href="<?php editcourselink()?>"><?php _e("Edit");?></a> | </span>
    <span class='delete'><a onclick="return confirm('Bạn có chắc muốn xóa <?php course_name();?>?');" href="<?php deletecourselink()?>"><?php _e("Delete");?></a></span>
    <!--<span class='email'> | <?php echo make_clickable(user_email());?></span>-->
    </div>
    </td>
    <td class="column-cfaculty"><?php faculty_name();?></td>
    <td class="column-ccredit"><?php course_credit();?></td>
    <td class="column-numstudent"><?php course_num_students('',true)?>/<?php course_max();?></td>
    <td class="column-cexpire"><?php course_close();?></td>

    
 
 </tr>
 <?php }?>
 </tbody>
</table>
<hr />
<br/>
<input type="submit" class="button" name="multidelete" value="Xóa" onclick="return confirm('<?php _e('Bạn có chắc chắn muốn xóa những khóa học đã chọn?')?>');"/>
</form>