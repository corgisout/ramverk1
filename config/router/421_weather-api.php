<?php
/**
 * Load the sample json controller.
 */
return [
    "routes" => [
        [
            "info" => "geo to json",
            "mount" => "api",
            "handler" => "\Anax\Controller\weatherApiController",
        ],
    ]
];
