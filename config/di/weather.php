<?php
/**
 * Configuration file for DI container ipgeo.
 */
return [
    // Services to add to the container.
    "services" => [
        "weather" => [
            "active" => false,
            "shared" => true,
            "callback" => function () {
                $weather = new \Anax\Model\Weather();
                $cfg = $this->get("configuration");
                $config = $cfg->load("apiKey.php");
                $locationiqKey = $config["config"]["locationiq"];
                $darkskyKey = $config["config"]["darksky"];
                $weather->setApiKeys($locationiqKey, $darkskyKey);
                return $weather;
            },
        ],
    ],
];
