<?php

namespace Anax\View;

/**
 * View to update user.
 */

// Create url for navigation
$urlToProfile = url("user/profile/$id");



?><h1>Update user information</h1>

<?= $form ?>

<p>
    <a href="<?= $urlToProfile ?>">Back to profile</a>
</p>
