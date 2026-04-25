<h1>My captchas</h1>
<?php
include_once("./components/captcha.php");

//generateCaptcha($pdo);
?>
<div style="padding: 64px">
<?php
configCaptchaList($pdo);
?>
</div>
