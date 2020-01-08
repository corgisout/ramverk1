<?php
/**
 * Main content for ip varifier.
 */
namespace Anax\View
?>
<html>
    <article>
        <h2>Ip Validation</h2>
        <p>search for an IP-address</p>
        <form>
            <input type="text" name="ip" value="<?= $ip ?>">
            <input type="submit" value="check Ip" name="submit">
            <input type="button" onclick="window.location.href='http://www.student.bth.se/~sihd17/dbwebb-kurser/ramverk1/me/redovisa/htdocs/makejson?ip=<?=$ip?>'" value="Json"/>
            <b><?= $valid ?></b><br><br>


            Ip: <?= $ip ?><br><br>
            Ipv: <?= $ipv ?><br>
            Domain: <?= $domain ?><br>
            Lon: <?= $lon ?><br><br>

            Lat: <?= $lat ?><br>
            Country: <?= $country ?><br>
            City: <?= $city ?>
        </form>
    </article>
</html>
