<?php
include_once('../bin/judge.php');
session_start();

if (isset($_SESSION['valid_user'])) {
    $judge = new judge(array("name" => $_SESSION['valid_user']));
    $member_id = $judge->get_member_id();
    if ($member_id == 0) {

        ?>
        <html>
        <head>
            <script>location.href = '../manage';</script>
        </head>
        </html>
        <?php
    } else {

        ?>
        <html>
        <head>
            <script>location.href = '../interview';</script>
        </head>
        </html>
        <?php

    }
    exit;

}

?>
<html>
<head>
    <link rel="stylesheet" href="./css/test.css">

</head>
<body>
<div class="login-card">
    <h1>Log-in</h1><br>

    <form method="post" action="./run_login.php">
        <input type="text" name="name" placeholder="Username" id="name">
        <input type="password" name="password" placeholder="Password" id="key">
        <input type="submit" name="login" class="login login-submit" value="login">
    </form>


</div>


</body>
</html>
