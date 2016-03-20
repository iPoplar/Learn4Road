<?php
/**
 * Created by PhpStorm.
 * User: zh
 * Date: 15-10-11
 * Time: 上午11:09
 */
session_start();
unset($_SESSION['valid_user']);

?>
<html>
<head>
    <script>location.href='../../login/index.php';</script>
</head>
</html>