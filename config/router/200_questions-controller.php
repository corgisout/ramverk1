<?php
/**
 * Router to Controller for user functions
 */
return [
    "routes" => [
        [
            "info" => "Controller for user.",
            "mount" => "question",
            "handler" => "\Anax\Question\QuestionController",
        ],
    ]
];
