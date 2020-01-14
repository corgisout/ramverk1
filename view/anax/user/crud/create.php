<?php

namespace Anax\View;

$items = isset($items) ? $items : null;

$urlToViewItems = url("user");

?><h1>Create a new user</h1>

<?= $form ?>

<p>
    <a href="<?= $urlToViewItems ?>">Show all users</a>
</p>
