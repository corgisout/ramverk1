<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;
$reversed = array_reverse($items);
// Create urls for navigation
$urlToPost = url("question/post");
$urlToQuestion = url("question");

?>
<h1>Questions</h1>

<?php if (!$items) : ?>
    <p>There are no questions posted yet why not be the first?</p>

<?php endif;?>
<div class="main" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">

<p>
    <a href="<?= $urlToPost ?>"><button>create new Question</button></a>
</p>
<?php
foreach ($reversed as $item) : ?>
    <a href="<?= url("question/question/{$item->id}"); ?>"><?= $this->di->get("textfilter")->markdown($item->content); ?></a>
<?php endforeach; ?>
</div>
