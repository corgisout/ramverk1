<?php

namespace Anax\View;

$question = isset($question) ? $question : null;
$tags = isset($tags) ? $tags : [];
$users = isset($users) ? $users : [];
$answers = isset($answers) ? $answers : [];
$comments = isset($comments) ? $comments : [];

$urlToQuestions = url("question");
$urlToAnswer = url("question/answer/$question->id");
$urlToQuestionComment = url("question/qcomment/$question->id");
?>

<div class="main">
<h1>Question asked by <?= $asker->username ?></h1>
<?php foreach ($tags as $tag) :?>
    <a href="<?= url("tags/tag/$tag") ?>">#<?= $tag ?></a>
<?php endforeach; ?>
<div style="background-color:#ababab; padding: 20px;">
    <img style="margin: 4px;" src="<?= $gravatar->getGravatar($asker->email) ?>" alt="User Picture" width="35" height="35">
    <div>
         <p><?= $this->di->get("textfilter")->markdown($question->content); ?></p>
    </div>
    <div>
        <a href="<?= $urlToAnswer ?>">Answer</a>
        <a href="<?= $urlToQuestionComment ?>">Comment</a>
    </div>
</div>

<?php foreach ($comments as $comment) : ?>
    <?php if ($question->id == $comment->questionId) : ?>
        <div style="background-color:#e8e8e8; margin-top:10px"> question comments:
        <?php foreach ($users as $user) : ?>
            <?php if ($user->id == $comment->userId) : ?>
                <ul style="margin-left: 50px">
                    <table>
                        <td>
                            <img style="margin: 5px; min-width: 35px;" src="<?= $gravatar->getGravatar($user->email) ?>" alt="User Picture" width="35" height="35">
                        </td>
                        <li><p><?php echo $user->username; ?>: </p></li>
                    </ul>
                <?php endif; ?>
            <?php endforeach; ?>
                        <td><p><?= $this->di->get("textfilter")->markdown($comment->content); ?></p></td>
                    </table>
                </div>
    <?php endif; ?>
<?php endforeach; ?>


<?php if ($answers) : ?>
    <?php foreach ($answers as $answer) : ?>
        <?php if ($answer->questionId == $question->id) : ?>
            <div style="background-color:#ababab; padding: 20px;">
            <?php foreach ($users as $user) : ?>
                <?php if ($user->id == $answer->userId) : ?>
                    <td><p><b>Answer: </b></p></td>
                    <li><p><?php echo $user->username; ?>: </p></li>
                        <img style="margin: 4px;" src="<?= $gravatar->getGravatar($user->email) ?>" alt="User Picture" width="35" height="35">
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if ($answer->questionId == $question->id) : ?>
                    <td><p><?= $this->di->get("textfilter")->markdown($answer->content); ?></p></td>
            <?php endif; ?>
                <div>
                    <a href="<?= url("question/acomment/$answer->id") ?>">Comment</a>
                </div>
            </div>
            <div style="background-color:#e8e8e8; margin-top:10px">
                <ul style="margin-left: 50px">
            <?php foreach ($comments as $comment) : ?>
                <?php if ($answer->id == $comment->answerId) : ?>
                    <?php foreach ($users as $user) : ?>
                        <?php if ($user->id == $comment->userId) : ?>
                            <table>
                                <td>
                                    <img style="margin: 4px; min-width: 35px;" src="<?= $gravatar->getGravatar($user->email) ?>" alt="User Picture" width="35" height="35">
                                </td>
                                <li><p><?php echo $user->username; ?>: </p></li>
                            </ul>
                        <?php endif; ?>
                    <?php endforeach; ?>
                                <td><p><?= $this->di->get("textfilter")->markdown($comment->content); ?></p></td>
                            </table>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>
</div>
