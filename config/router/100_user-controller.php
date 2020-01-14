<?php
/**
 * Router to Controller for user functions
 */
return [
    "routes" => [
        [
            "info" => "Controller for user.",
            "mount" => "user",
            "handler" => "\Anax\User\UserController",
        ],
    ]
];
