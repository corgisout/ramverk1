<?php

namespace Anax\View;

$urlToCreate = url("user/create");
$urlToLogin = url("user/login");
?>
<p>you must login to view this page <a href="<?= $urlToLogin ?>">log in</a></p>
<p>if you dont have an account create a user <a href="<?= $urlToCreate ?>" style="">here</a></p>
