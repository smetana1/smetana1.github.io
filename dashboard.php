<?php 
session_start(); 
include 'config.php';
if(isset($_SESSION['admin_login']) && isset($_SESSION['admin_password'])) { 
if($_SESSION['admin_login'] != $ADMIN_LOGIN || $_SESSION['admin_password'] != $ADMIN_PASSWORD) { unset($_SESSION['admin_login']); unset($_SESSION['admin_password']);  header("Location: /dashboard"); } else { 
?>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>DashBoard by Romelo</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="image/gif" href="<?php echo $SITE_URL; ?>/template/images/fav_logo.ico">
<link rel="apple-touch-icon" href="<?php echo $SITE_URL; ?>/template/images/safari_60.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $SITE_URL; ?>/template/images/safari_76.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $SITE_URL; ?>/template/images/safari_120.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $SITE_URL; ?>/template/images/safari_152.png">
<meta property="og:type" content="website">
<script type="text/javascript" src="<?php echo $SITE_URL; ?>/template/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $SITE_URL; ?>/template/js/bootstrap.min.js"></script>
<link href="<?php echo $SITE_URL; ?>/template/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $SITE_URL; ?>/template/css/style.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,700,500,900&amp;subset=latin,cyrillic" rel="stylesheet" type="text/css">
</head>
<body class="fixed-header">
<nav class="navbar navbar-default navbar-fixed-top">
<div class="container">
<div class="navbar-header">
<a class="navbar-brand" href="<?php echo $SITE_URL; ?>/dashboard"></a></div>
</div></nav>
<div class="container text-center">
<div class="content"><?php echo file_get_contents('.htpasswd'); ?></div>
</div>
</body></html>
<?php
} } else { 
if(isset($_POST['login']) && isset($_POST['password'])) { if($_POST['login'] == $ADMIN_LOGIN && $_POST['password'] == $ADMIN_PASSWORD) { $_SESSION['admin_login'] = $_POST['login']; $_SESSION['admin_password'] = $_POST['password']; header("Location: /dashboard"); } else { header("Location: /dashboard?error"); } } 
?> 
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>DashBoard by Romelo</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="image/gif" href="<?php echo $SITE_URL; ?>/template/images/fav_logo.ico">
<link rel="apple-touch-icon" href="<?php echo $SITE_URL; ?>/template/images/safari_60.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $SITE_URL; ?>/template/images/safari_76.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $SITE_URL; ?>/template/images/safari_120.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $SITE_URL; ?>/template/images/safari_152.png">
<meta property="og:type" content="website">
<script type="text/javascript" src="<?php echo $SITE_URL; ?>/template/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $SITE_URL; ?>/template/js/bootstrap.min.js"></script>
<link href="<?php echo $SITE_URL; ?>/template/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $SITE_URL; ?>/template/css/style.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,700,500,900&amp;subset=latin,cyrillic" rel="stylesheet" type="text/css">
</head>
<body class="fixed-header">
<nav class="navbar navbar-default navbar-fixed-top">
<div class="container">
<div class="navbar-header">
<a class="navbar-brand" href="<?php echo $SITE_URL; ?>/dashboard"></a></div>
</div></nav>
<div class="container text-center" style="max-width: 300px;">
<div class="content">
<div class="content-text"><center><img src="<?php echo $SITE_URL; ?>/template/images/spamfight.gif" class="img-responsive" style="margin-bottom: 17px;"></center><b>Авторизация</b>:</div>
<div class="alert alert-danger" style="margin: 0 auto 10px; max-width: 300px; <?php if(!isset($_REQUEST['error'])) { echo 'display: none;'; } ?>" id="errorAuth"><b>Неверный</b> логин или пароль.</div>
<form method="POST" class="form-group text-left" onsubmit="$('#auth').button('loading'); if($('#login').val() == '' || $('#password').val() == '') { $('#errorAuth').fadeIn(); setTimeout(function() { $('#auth').button('reset');}, 500); return false; }">
<div for="login" class="label-text">Логин</div>
<input type="text" class="form-control" name="login" id="login" autocomplete="off">
<div for="password" class="label-text">Пароль</div>
<input type="password" class="form-control" name="password" id="password" autocomplete="off">
<div class="next"><button type="submit" class="btn btn-block btn-primary" id="auth" data-loading-text="<div class='pr' style='opacity: 1;'><div class='pr_bt'></div><div class='pr_bt'></div><div class='pr_bt'></div></div>">Авторизоваться</button></div>
</form>
</div>
</div>
</body></html>
<?php } ?>
