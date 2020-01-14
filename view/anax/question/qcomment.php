<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$user = isset($user) ? $user : null;
$question = isset($question) ? $question : null;
$urlToQuestion = url("question/question/$question->id");

// Create urls for navigation

?><h1>Post a comment</h1>

<p><?= $question->content ?></p>

<?= $form ?>
<p>
    <a href="<?= $urlToQuestion ?>">back to questions</a>
</p>
