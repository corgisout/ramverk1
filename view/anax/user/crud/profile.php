<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$info = isset($info) ? $info : null;
$activeUser = isset($activeUser) ? $activeUser : null;
$profilePicture = isset($profilePicture) ? $profilePicture : null;
$questions = isset($questions) ? $questions : [];
$answers = isset($answers) ? $answers : [];
$urlToUpdate = url("user/update/$info->id");
$urlToPassword = url("user/password/$info->id");
$urlToLogOut = url("user/logout");

$userAnswers = [];
$userQuestions = [];

foreach ($questions as $question) {
    foreach ($answers as $answer) {
        if ($answer->questionId == $question->id && $answer->userId == $info->id) {
            array_push($userAnswers, $question);
        }
    }
    if ($question->userId == $info->id) {
        array_push($userQuestions, $question);
    }
}
?>


<h1>User Profile</h1>

<?php if (!$info) : ?>
    <p>The user you're looking for does not exist.</p>
    <?php
    return;
endif;
?>
<?php if ($activeUserId == $info->id) : ?>
    <p>
        <a href="<?= $urlToUpdate ?>"><button>Update</button></a>
        <a href="<?= $urlToPassword ?>"><button>change password</button></a>
        <a href="<?= $urlToLogOut ?>"><button>Log out</button></a>

    </p>
<?php endif; ?>


<table>
    <tr style="border-top: none;">
        <td>
            <img src="<?= $profilePicture ?>" alt="User Picture" width="128" height="128">
        </td>
        <td>
            <p>username: <?= $info->username ?></p>
            <p>firstname: <?= $info->firstname ?></p>
            <p>lastname: <?= $info->lastname ?></p>

            <p>Email: <?= $info->email ?></p>
        </td>
    </tr>
</table>

<h2>User Activity</h2>
<div>
    <ul>
        <li><h3>User Asked:</h3></li>
    <?php foreach ($userQuestions as $question) : ?>
        <li>
            <a href="<?= url("question/question/$question->id") ?>"><span><?= $question->content ?></span></a>
        </li>
    <?php endforeach; ?>
    </ul>

    <ul>
        <li><h3>User Answered:</h3></li>
    <?php foreach ($userAnswers as $answer) : ?>
        <li>
            <a href="<?= url("question/question/$answer->id") ?>"><span><?= $answer->content ?></span></a>
        </li>
    <?php endforeach; ?>
    </ul>
</div>
