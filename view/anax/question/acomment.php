<?php

namespace Anax\View;

$answer = isset($answer) ? $answer : null;
$user = isset($user) ? $user : null;


?><h1>Post a comment</h1>

<p><?= $answer->content ?></p>

<?= $form ?>
