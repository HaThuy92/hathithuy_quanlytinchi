<?php
require ("cm-load.php");
$redirect_to = site_url('login.php');
$username='';
$password='';
$remember='';
if(isset($_POST['cm-user']))
$username = $_POST['cm-user'];
if(isset($_POST['cm-pass']))
$password = $_POST['cm-pass'];
if(isset($_POST['cm-remember']))
$remember = $_POST['cm-remember'];
if (isset($_GET['logout'])) {
    cm_logout();
    cm_redirect(site_url('login.php'));

}
if (is_user_logged_in()) {
    if (is_administrator()) {
        cm_redirect(admin_url());
    } else
        cm_redirect(site_url());
}
$logged_in=cm_logon($username, $password, $remember);
if($logged_in)
    cm_redirect($redirect_to);
if ($username)
    if (!$password) {
        $mess = "Xin hãy nhập mật khẩu";
    } else {
        $mess = "Tên đăng nhập hoặc mật khẩu không đúng";

    }



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML dir=ltr lang=vi xmlns="http://www.w3.org/1999/xhtml"><HEAD><TITLE>CCM › Đăng nhập</TITLE>
<META content="text/html; charset=UTF-8" http-equiv=Content-Type>
<style>
* {
	PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px
}
BODY {
	FONT: 11px "Lucida Grande", Verdana, Arial, "Bitstream Vera Sans", sans-serif;
	background: #CCD8E0 url(<?php echo admin_url("template/default/img/bg.jpg"); ?>);
}
FORM {
	BORDER-BOTTOM: #e5e5e5 1px solid; BORDER-LEFT: #e5e5e5 1px solid; PADDING-BOTTOM: 40px; PADDING-LEFT: 16px; PADDING-RIGHT: 16px; BACKGROUND: #CCD8E0; MARGIN-LEFT: 8px; BORDER-TOP: #e5e5e5 1px solid; FONT-WEIGHT: normal; BORDER-RIGHT: #e5e5e5 1px solid; PADDING-TOP: 16px; -moz-border-radius: 11px; -khtml-border-radius: 11px; -webkit-border-radius: 11px; border-radius: 5px; -moz-box-shadow: rgba(200, 200, 200, 1) 0 4px 18px; -webkit-box-shadow: rgba(200, 200, 200, 1) 0 4px 18px; -khtml-box-shadow: rgba(200, 200, 200, 1) 0 4px 18px; box-shadow: rgba(200, 200, 200, 1) 0 4px 18px
}
FORM .forgetmenot {
	MARGIN-BOTTOM: 0px; FLOAT: left; FONT-WEIGHT: normal
}
.button-primary {
	BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; PADDING-BOTTOM: 3px; MARGIN-TOP: -3px; PADDING-LEFT: 10px; PADDING-RIGHT: 10px; FONT-FAMILY: "Lucida Grande", Verdana, Arial, "Bitstream Vera Sans", sans-serif; FONT-SIZE: 12px; BORDER-TOP: 1px solid; CURSOR: pointer; BORDER-RIGHT: 1px solid; TEXT-DECORATION: none; PADDING-TOP: 3px; -moz-border-radius: 11px; -khtml-border-radius: 11px; -webkit-border-radius: 11px; border-radius: 11px
}
#login FORM P {
	MARGIN-BOTTOM: 0px
}
LABEL {
	COLOR: #777; FONT-SIZE: 13px
}
FORM .forgetmenot LABEL {
	LINE-HEIGHT: 19px; FONT-SIZE: 11px
}
FORM .submit {
	FLOAT: right
}
.alignright {
	FLOAT: right
}
FORM P {
	MARGIN-BOTTOM: 24px
}
#nav {
	text-shadow: rgba(255, 255, 255, 1) 0 1px 0
}
#login {
	MARGIN: 10em auto; WIDTH: 320px
}
#login_error {
	BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; PADDING-BOTTOM: 12px; MARGIN: 0px 0px 16px 8px; PADDING-LEFT: 12px; PADDING-RIGHT: 12px; BORDER-TOP: 1px solid; BORDER-RIGHT: 1px solid; PADDING-TOP: 12px; -moz-border-radius: 3px; -khtml-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px;
	color:red;background: #CCD8E0;
}
.message {
	BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; PADDING-BOTTOM: 12px; MARGIN: 0px 0px 16px 8px; PADDING-LEFT: 12px; PADDING-RIGHT: 12px; BORDER-TOP: 1px solid; BORDER-RIGHT: 1px solid; PADDING-TOP: 12px; -moz-border-radius: 3px; -khtml-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px
}
#nav {
	PADDING-BOTTOM: 16px; MARGIN: 0px 0px 0px 8px; PADDING-LEFT: 16px; PADDING-RIGHT: 16px; PADDING-TOP: 16px
}
#user_pass,#user_email,#user_login {
	BORDER-BOTTOM: #e5e5e5 1px solid; BORDER-LEFT: #e5e5e5 1px solid; PADDING-BOTTOM: 3px; MARGIN-TOP: 2px; PADDING-LEFT: 3px; WIDTH: 97%; PADDING-RIGHT: 3px; MARGIN-BOTTOM: 16px; BACKGROUND: #f9f9f9; FONT-SIZE: 24px; BORDER-TOP: #e5e5e5 1px solid; MARGIN-RIGHT: 6px; BORDER-RIGHT: #e5e5e5 1px solid; PADDING-TOP: 3px
}

INPUT {
	COLOR: #555
}
.clear {
	CLEAR: both
}
</style>

<META name=robots content=noindex,nofollow>
<META name=GENERATOR content="MSHTML 8.00.7600.16490"></HEAD>
<BODY>

<DIV id=login>
<?php if ( isset($mess)) { ?>
<div id="login_error">	<strong>Lỗi</strong>: <?php echo $mess; ?>.<br />
</div>
<?php }
; ?>

<FORM id="loginform" method="post" name="loginform" action="login.php">
<P><LABEL>Tên đăng nhập<BR><INPUT id="user_login" class="input" tabIndex="10" size="20" 
type="text" name="cm-user" value="<?php echo $username; ?>"></LABEL> </P>
<P><LABEL>Mật khẩu<BR><INPUT id="user_pass" class="input" tabIndex="20" size="20" 
type="password" name="cm-pass"></LABEL> </P>
<P class=forgetmenot>
<LABEL>
<INPUT id="rememberme" tabIndex=90 value="forever" type="checkbox" name="cm-remember"> Tự động đăng nhập lần sau</LABEL></P>
<P class=submit>
<INPUT class=button-primary tabIndex=100 value="Đăng nhập" type=submit name=cm-login> 
<INPUT value=<?php echo $redirect_to; ?> type=hidden 
name=redirect_to> <INPUT value=1 type=hidden name=testcookie> </P></FORM>
<P id=nav>
<A title="Tạo mật khẩu mới" 
href="login.php?action=lostpassword">Bạn quên 
mật khẩu?</A> </P>
</DIV>
<script type="text/javascript"> 
try{document.getElementById('user_login').focus();}catch(e){}
alert("Bản demo, để đăng nhập vào hệ thống sử dụng\nTên đăng nhập: admin\nMật khẩu: !@#abc");
</script>

</body>
</html>