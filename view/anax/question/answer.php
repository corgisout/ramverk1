<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$question = isset($question) ? $question : null;
$user = isset($user) ? $user : null;

// Create urls for navigation
$urlToQuestion = url("question/question/$question->id");


?><h1>Answer question</h1>

<p><?= $question->content ?></p>

<?= $form ?>

<p>
    <a href="<?= $urlToQuestion ?>">back to question</a>
</p>
