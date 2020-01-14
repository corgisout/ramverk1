<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
$urlToQuestions = url("question");



?><h1>Post a Question</h1>

<?= $form ?>

<p>
    <a href="<?= $urlToQuestions ?>">All active Questions</a>
</p>
