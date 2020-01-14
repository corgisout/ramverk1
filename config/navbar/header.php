<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",

    // Here comes the menu items
    "items" => [
        [
            "text" => "home",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],

        [
            "text" => "about",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ],

        [
            "text" => "Users",
            "url" => "user",
            "title" => "Inlogg och överblick",
        ],
        [
            "text" => "Questions",
            "url" => "question",
            "title" => "Frågeforum",
        ],
        [
            "text" => "Tags",
            "url" => "tags",
            "title" => "Taggar och Kategorier",
        ],

    ],
];
