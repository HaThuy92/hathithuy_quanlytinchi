<?php
global $all_students,$offset,$all_teachers;
?>
<p class="title-manager"><?php course_name();?></p>
<div class="course-teachers-list">
Giảng viên:
<?php for($i=0;$i<count((array)$all_teachers);$i++){
	setup_userdata($all_teachers[$i]);
 ?>
 <?php user_fullname(); if($i!=count((array)$all_teachers)-1) echo ', ';?>

<?php }?>
</div>
<form action="student.php" method="POST">
<table class="widefat fixed" cellspacing="0">
<thead>
	<tr>
    <th scope="col" class="column-stt">STT</th>
	<th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox" /></th>
	<th scope="col" id="student-code" class="manage-column column-code" style="">Mã Sv</th>
	<th scope="col" id="fullname" class="manage-column column-fullname" style="">Họ tên</th>
	<th scope="col" id="birthday" class="manage-column column-birthday" style="">Ngày sinh</th>
    <th scope="col" id="faculty" class="manage-column column-faculty" style="">Khoa</th>
    <th scope="col" id="address" class="manage-column column-address" style="">Địa chỉ</th>
	</tr>
</thead>
<tfoot>
	<tr>
    <th scope="col" class="column-stt">STT</th>
	<th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox" /></th>
	<th scope="col" id="student-code" class="manage-column column-code" style="">Mã Sv</th>
	<th scope="col" id="fullname" class="manage-column column-fullname" style="">Họ tên</th>
	<th scope="col" id="birthday" class="manage-column column-birthday" style="">Ngày sinh</th>
    <th scope="col" id="faculty" class="manage-column column-faculty" style="">Khoa</th>
    <th scope="col" id="address" class="manage-column column-address" style="">Địa chỉ</th>
	</tr>
</tfoot>
<tbody id="the-student-list" class="list:student">
<?php foreach((array)$all_students as $student){
	setup_userdata($student);
 ?>
<tr id="student-<?php user_id();?>" valign="top"<?php class_alternate();?>>
<td class="column-stt"><?php echo ++$offset;?></td>
<th scope="row" class="check-column"><input type="checkbox" name="delete_students[]" value="<?php user_id();?>" /></th>
    <td class="column-code"><?php user_code();?></td>
    <td class="column-fullname"><?php user_fullname();?>
    <br />
    <div class="row-actions">
    <span class='edit'><a href="<?php editstudentlink()?>"><?php _e("Edit");?></a> | </span>
    <span class='delete'><a onclick="return confirm('Bạn có chắc muốn xóa <?php user_fullname();?>?');" href="<?php deletestudentlink()?>"><?php _e("Delete");?></a></span>
    <!--<span class='email'> | <?php echo make_clickable(user_email());?></span>-->
    </div>

    </td>
    <td class="column-birthday"><?php user_birthday();?></td>
    <td class="column-faculty"><?php faculty_name();?></td>
    <td class="column-address"><?php user_address();?></td>

    
 
 </tr>
 <?php }?>
 </tbody>
</table>
<hr />
<br/>
<input type="submit" class="button" name="multidelete" value="Xóa" onclick="return confirm('<?php _e('Bạn có chắc muốn xóa những sinh viên đã chọn?')?>');"/>

</form>