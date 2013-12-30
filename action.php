<?php

$action=$_GET['portalaction'];
$h = `/bin/hostname`;
$tmp=explode(".",$h);
$siteid = $tmp[0];

if(isset($_POST['redirurl'])) {
	$_GET['redirurl']=$_POST['redirurl'];
}
if(isset($_POST['portalaction'])) {
	$_GET['portalaction']=$_POST['portalaction'];
}
if(!isset($redirurl)) {
	$redirurl=$_GET['redirurl'];
}

$url="http://www.guestsuite.tv/pf/getPass.php?siteid={$siteid}&redirurl={$redirurl}";

$fh=@fopen($url,'r');
if($fh) {
	$result=fread($fh,100);
	fclose($fh);
} else {
	$result="OK";
}


$temp=array();
if($result != "OK") {
	$temp=explode("\n",$result);
	if(!isset($temp[1])) {
		$temp[1]=$temp[0];
	}
	if($temp[1] == '') {
		$temp[1]=$temp[0];
	}
} else {
    $temp[0]="OK";
    $temp[1]="OK";
}

//var_dump($temp); exit();

$enc_code = md5($_GET['code']);
//print $enc_code."<br>"; print $temp[0]."<br>"; print $temp[1]."<br>";
if(($enc_code != $temp[0]) && ($temp[0] !="OK")) {
	header("Location: /");
	exit();
} else {
?>
<html>
<head>
<title>Login Support Page</title>
</head>
<body onload="document.forms.myForm.submit();">
<form name="myForm" id="myForm" method="post" action="<?php echo $_GET['portalaction']; ?>">
<input type="hidden" name="redirurl" value="<?php echo $_GET['redirurl']; ?>">
<input type="hidden" name="accept" value="Continue">
</form>
</body>
</html>
<?php
}
?>
