<?php
session_start();
session_unset();
session_destroy();
header("Location: index.php");
setcookie("remember", "", time() - 3600, "/");
exit;