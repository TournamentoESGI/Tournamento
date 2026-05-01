<h1>My captchas</h1>
<?php
include_once("./components/captcha.php");

//generateCaptcha($pdo);
?>
<div style="width: 100%;">
<?php
generateCaptcha($pdo);
?>
</div>
