<?php

namespace Anax\View;

$items = isset($items) ? $items : null;
$activeUser = isset($activeUser) ? $activeUser : null;

$urlToCreate = url("user/create");
$urlToStart = url("index.php");

?>

<h1>Log in</h1>
<?= $content ?>
<?php if ($userLoggedIn) : ?>
    <p>
        <a href="<?= $urlToStart ?>">Back to start page</a>
    </p>
    <?php
    return;
endif;
?>
<p>
    <a href="<?= $urlToCreate ?>">Create a new User</a>
</p>
