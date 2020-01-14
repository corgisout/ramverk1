<?php

namespace Anax\Models;

/**
 * Model for getting gravatar profile picture
 */
class Gravatar
{
    /**
     * calls gravatar with email
     *
     * @param string email
     * @return string
     */
    public function getGravatar($email) : string
    {
        $url = "https://www.gravatar.com/avatar/";
        $default = "https://image.shutterstock.com/image-vector/black-linear-photo-camera-logo-600w-622639151.jpg";
        $size = 40;
        $gravUrl = $url . md5(strtolower(trim($email))) . "?d=" . urlencode($default) . "&s=" . $size;
        return $gravUrl;
    }
}
