<?php
/**
 * Router to Controller for user functions
 */
return [
    "routes" => [
        [
            "info" => "Controller for tags.",
            "mount" => "tags",
            "handler" => "\Anax\Tags\TagsController",
        ],
    ]
];
