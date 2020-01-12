<?php
/**
 * Load the sample json controller.
 */
return [
    "routes" => [
        [
            "info" => "Geo Controller.",
            "mount" => "weather",
            "handler" => "\Anax\Controller\weatherController",
        ],
    ]
];
