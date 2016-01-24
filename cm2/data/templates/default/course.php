<?php
get_header();
?>
<?php
if($message)
echo "<div class=\"message\">$message</div>";
if($_GET['cm']=='courses-list'):
$courses=$cmdb->get_results($cmdb->prepare("SELECT $cmdb->courses.* FROM $cmdb->courses WHERE faculty_id=%d",get_user_facultyid()))
?>
<p class="item_top">Danh sách các khóa học của khoa <?php faculty_name();?></p>
<div class="courses_list">
<?php foreach($courses as $course){
    setup_coursedata($course);
    ?>
<?php course_name();?>(<?php course_credit()?>tc) <a href="cm-course.php?select=<?php course_id();?>">Chọn</a><br />
<?php }?>
</div>
<br />
<div class="courses-selected">
<p class="item_top">Các khóa học đã chọn</p>
<form action="cm-course.php" method="POST">
<?php
    $courses=get_selected_courses();

    foreach($courses as $course){
    setup_coursedata(get_coursedata($course));
?>
<?php course_name();?> <a href="cm-course.php?unselect=<?php course_id();?>">Bỏ chọn</a><br />
<input type="hidden" name="courses[]" value="<?php course_id();?>"/>
<?php }?>
<br />
<input type="submit" name="join-course" value="Đăng ký" onclick="return confirm('Bạn có chắc chắn muốn đăng ký những khóa học trên đây, bạn không thể hủy bỏ sau khi đã đăng ký');"/>
</form>
</div>
<?php endif;?>
<?php
if($_GET['cm']=='joined-courses'):
$joined_courses=get_courses_by_userid();
?>
<p class="item_top">Các khóa học đã đăng ký </p>
<?php foreach($joined_courses as $course){
    setup_coursedata($course);
    ?>
    <?php course_name();?>(<?php course_credit()?>tc)<br/>

<?php } endif;?>
<?php
get_footer();
?>