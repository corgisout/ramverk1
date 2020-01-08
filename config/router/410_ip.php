<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Ip controller",
            "mount" => "ip",
            "handler" => "\Anax\Controller\IpController",
        ],
        [
            "info" => "Ip Validator to json",
            "mount" => "makejson",
            "handler" => "\Anax\Controller\MakeJsonController",
        ],
    ]
];
