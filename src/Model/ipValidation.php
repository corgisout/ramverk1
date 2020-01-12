<?php
namespace Anax\Model;

class IpValidation
{
    /**
     *
     * Returns Array[valid, ip, ipv, domain], get used at view.
     *
     */
    public function toJson($ip) : array
    {
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $ipv = "Ipv4";
            } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $ipv = "Ipv6";
            } else{
                $ipv = null;
            }

            if($ipv != null){
                $details = json_decode(file_get_contents("http://api.ipstack.com/{$ip}?access_key=9e9f05f2e74673444b90a999a579ab3f"));
                $domain = gethostbyaddr($ip);
            return [
                "valid" => "valid IP",
                "ip" => $ip,
                "ipv" => $ipv,
                "domain" => $domain,
                "lat" => $details->latitude,
                "lon" => $details->longitude,
                "country" => $details->country_name,
                "city" => $details->city
            ];
            } else {
                return [
                 "valid" => "Not Valid IP",
                 "ip" => null,
                 "ipv" => null,
                 "domain" => null,
                 "lat" => null,
                 "lon" => null,
                 "country" => null,
                 "city" => null
             ];
            }

    }
}
