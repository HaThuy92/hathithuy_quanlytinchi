<?php
global $cmdb;
/*$mysqli = new mysqli("localhost", "root", "", "cm");
echo "<br/><br/>Total students: use query <strong>call getallstudent();</strong><br/>";
$result=mysqli_query($mysqli,"call getallstudent();");
 /* Get field information for all columns 
    while ($finfo = $result->fetch_row()) {

        foreach($finfo as $row)
			echo $row." ";
		echo "<br/>";
    }
    $result->close();
/*echo "<br/><br/>Total students: use query <strong>SELECT getnumstudent()</strong><br/>";
print_r($cmdb->get_results("SELECT getnumstudent()"));
echo "<br/><br/>Total users: use query <strong>SELECT getnumuser('all')</strong><br/>";
print_r($cmdb->get_results("SELECT getnumuser('all')"));
echo "<br/><br/>Total students: use query <strong>SELECT getnumuser('student')</strong><br/>";
print_r($cmdb->get_results("SELECT getnumuser('student')"));
echo "<br/><br/>Total teachers: use query <strong>SELECT getnumuser('teacher')</strong><br/>";
print_r($cmdb->get_results("SELECT getnumuser('teacher')"));
echo "<br/><br/>Total administrator: use query <strong>SELECT getnumuser('admin')</strong><br/>";
print_r($cmdb->get_results("SELECT getnumuser('admin')"));
*/
$static['numstudent']=$cmdb->get_var("SELECT getnumstudent()");
$static['numteacher']=$cmdb->get_var("SELECT getnumuser('teacher')");
$static['numcourses']=$cmdb->get_var("SELECT getnumcourse()");
$static['lh']=$cmdb->get_var("SELECT getnumlh()");
$static['numfaculties']=$cmdb->get_var("select getnumfaculty()");
?>
<h2>Thống kê</h2>
<div class="static" style="margin-left: 10px;margin-top: 10px;">
Số khoa: <?php echo $static['numfaculties'];?>
<br />
Số sinh viên: <?php echo $static['numstudent'];?>
<br />
Số giảng viên: <?php echo $static['numteacher'];?>
<br />
Số khóa học: <?php echo $static['numcourses'];?>
<br />
Số giảng đường: <?php echo $static['lh']?>
</div>