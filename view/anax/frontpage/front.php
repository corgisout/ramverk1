<?php

namespace Anax\View;

$questions = isset($questions) ? $questions : null;
$users = isset($users) ? $users : null;
$allTags = [];
$allUsers = [];
$userActive = [];

foreach ($questions as $question) {
    if ($question->tags != null) {
        $tags = explode(" ", $question->tags);
        $allTags = array_merge($allTags, $tags);
    }
    foreach ($users as $user) {
        if ($question->userId == $user->id) {
            array_push($userActive, $user->username);
        }
    }
}
$countedUsers = array_count_values($userActive);
$countedTags = array_count_values($allTags);
arsort($countedUsers);
arsort($countedTags);
$questions = array_reverse($questions);

?>

<h1>CorgiClub</h1>
<p>welcome to the corgiClub where you can discuss anything corgi related</p>

<div>
    <ul>
        <li><h3>5 most popular tags</h3></li>
    <?php foreach (array_slice($countedTags, 0, 5) as $key => $value) :
        if (substr($key, 0, 1) == "#") {
            $key = substr($key, 1);
        } ?>
        <li style="width: 15%;">
            <a href="<?= url("tags/tag/$key") ?>"><span><?= $key ?></span></a>
            <div style="float: right;"><?= $value ?></div>
        </li>
    <?php endforeach; ?>
    </ul>

    <ul>
        <li><h3>Latest Questions</h3></li>
    <?php foreach (array_slice($questions, 0, 5) as $question) : ?>
        <li>
            <a href="<?= url("question/question/$question->id") ?>"><span><?= $question->content ?></span></a>
        </li>
    <?php endforeach; ?>
    </ul>

    <ul>
        <li><h3>top 5 users</h3></li>
    <?php foreach (array_slice($countedUsers, 0, 5) as $key => $value) :
        foreach ($users as $user) {
            $id = $user->id;
        } ?>
        <li style="width: 15%;">
            <a href="<?= url("user/profile/$id") ?>"><span><?= $key ?></span></a>
            <div style="float: right;"><?= $value ?></div>
        </li>
    <?php endforeach; ?>
    </ul>
</div>
