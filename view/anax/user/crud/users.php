<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;
$activeUser = isset($activeUser) ? $activeUser : null;
$activeUserId = isset($activeUserId) ? $activeUserId : null;


// Create urls for navigation
$urlToCreate = url("user/create");
$urlToLogin = url("user/login");
$urlToProfile = url("user/profile/$activeUserId");

?><h1>Users</h1>

<?php if (!$items) : ?>
    <p>There are no users why not be the first?.</p>
    <p>
        <a href="<?= $urlToCreate ?>"><button>Create new User</button></a>
        <a href="<?= $urlToLogin ?>"><button>Log in</button></a>
    </p>

    <?php
    return;
endif;
?>

<?php if ($activeUser == true) : ?>
    <a href="<?= $urlToProfile ?>"><button>Your Profile</button></a>
<?php else : ?>
    <p>
        <a href="<?= $urlToLogin ?>"><button>Log in</button></a>
        <a href="<?= $urlToCreate ?>"><button>Create new User</button></a>
    </p>
<?php endif; ?>
<table>
    <tr>
        <th style="width: 50%">username</th>
        <th style="width: 50%">Email</th>
    </tr>
    <?php foreach ($items as $item) : ?>
    <tr>
        <td>
            <a href="<?= url("user/profile/{$item->id}"); ?>"><?= $item->username ?></a>
        </td>
        <td><?= $item->email ?></td>
    </tr>
    <?php endforeach; ?>
</table>
