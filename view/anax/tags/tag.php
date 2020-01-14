<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$questions = isset($questions) ? $questions : null;
$tag = isset($tag) ? $tag : null;
$tagQuestions = [];

foreach ($questions as $question) {
    $tags = explode(" ", $question->tags);

    if (in_array($tag, $tags)) {
        array_push($tagQuestions, $question);
    }
}

?>

<h1>Questions related to '<?= $tag ?>'</h1>
<?php foreach ($tagQuestions as $question) : ?>
<div>
    <a href="<?= url("question/question/{$question->id}"); ?>"><?= $question->content ?></a>
</div>
<?php endforeach; ?>
