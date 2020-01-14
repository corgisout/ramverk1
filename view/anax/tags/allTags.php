<?php

namespace Anax\View;

$questions = isset($questions) ? $questions : null;
$allTags = [];

foreach ($questions as $question) {
    if ($question->tags != null) {
        $tags = explode(" ", $question->tags);
        $allTags = array_merge($allTags, $tags);
    }
}

$countTags = array_count_values($allTags);
?>
<h1>All Tags</h1>

<ul>
<?php foreach ($countTags as $key => $value) :
     ?>
    <li>
        <a href="<?= url("tags/tag/$key") ?>"><span><?= $key ?></span></a>
        <div style="float: right;"><?= $value ?></div>
    </li>
<?php endforeach; ?>
</ul>
