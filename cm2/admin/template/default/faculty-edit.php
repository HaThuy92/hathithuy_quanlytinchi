<?php
global $all_faculties,$offset;
?>
<p class="title-manager">Quản lý Khoa</h2>
<form action="faculty.php" method="POST">
<table class="widefat fixed" cellspacing="0">
<thead>
	<tr>
    <th scope="col" class="column-stt">STT</th>
	<th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox" /></th>
	<th scope="col" id="faculty-name" class="manage-column column-faculty-name" style="">Khoa</th>
	<th scope="col" id="faculty-description" class="manage-column column-faculty-description" style="">Mô tả</th>
	</tr>
</thead>
<tfoot>
	<tr>
    <th scope="col" class="column-stt">STT</th>
	<th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox" /></th>
	<th scope="col" id="faculty-name" class="manage-column column-faculty-name" style="">Khoa</th>
	<th scope="col" id="faculty-description" class="manage-column column-faculty-description" style="">Mô tả</th>
	</tr>
</tfoot>
<tbody id="the-faculty-list" class="list:faculty">
<?php foreach((array)$all_faculties as $faculty){
     setup_facultydata($faculty);   
?>
<tr id="faculty-<?php faculty_id();?>" valign="top"<?php class_alternate();?>>
<td class="column-stt"><?php echo ++$offset;?></td>
<th scope="row" class="check-column"><input type="checkbox" name="delete_faculties[]" value="<?php faculty_id();?>" /></th>
    <td class="column-faculty-name"><?php faculty_name();?>
    <br />
    <div class="row-actions">
    <span class='edit'><a href="<?php editfacultylink()?>"><?php _e("Edit");?></a> | </span>
    <span class='delete'><a onclick="return confirm('Bạn có chắc muốn xóa khoa <?php faculty_name();?>?');" href="<?php deletefacultylink()?>"><?php _e("Delete");?></a></span>
    </td>
    <td class="column-faculty-description"><?php faculty_desc();?>
    </td>
 </tr>
 <?php }?>
 </tbody>
</table>
<hr />
<br/>
<input type="submit" class="button" name="multidelete" value="Xóa" onclick="return confirm('<?php _e('Bạn có chắc muốn xóa những khoa đã chọn?')?>');"/>
</form>