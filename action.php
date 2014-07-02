<?php

$h = `/bin/hostname`;
$tmp=explode(".",$h);
$site = $tmp[0];

if(!isset($_GET['code'])) {
	header("Location: index.html");
	exit();
}

$checkURL="http://www.guestsuite.tv/pf/checkLogin.php?site={$site}&password={$_GET['code']}";


$fh=fopen($checkURL,'r');
if($fh) {
	$result=fread($fh,100);
	fclose($fh);
} else {
	$result="ERROR";
}

if(!isset($_GET['redirurl'])) {
	$_GET['redirurl']='http://www.google.com';
}

if($result != "OK") {
	header("Location: index.html");
	exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
        <head>
                <title>Welcome</title>
                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        </head>
        <body onLoad="javascript:document.forms.myForm.submit();">
		<!-- <?php echo $checkURL; ?> -->
		<form method="post" name="myForm" id="myForm" action="<?php echo $_GET['portalaction'];?>">
 			<input name="auth_user" type="hidden">
   			<input name="auth_pass" type="hidden">
   			<input name="auth_voucher" type="hidden">
                        <input type="hidden" name="redirurl" value="<?php echo $_GET['redirurl']; ?>">
			<input type="hidden" name="accept" value="Continue">
                        Redirecting: <input type="submit" name="submit_btn" value="Continue">
                </form>
        </body>
</html>

