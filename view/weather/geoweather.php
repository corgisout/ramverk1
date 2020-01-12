<?php
/**
 * Main content for ip varifier.
 */
namespace Anax\View
?>
<html>
    <article>
        <h2>Weather</h2>
        <p>search for an IP-address or city to get weather</p>

        <form method="post">
            <input type="text" name="search" value="<?= $search ?>">
            <label><input type="radio" name="when" value="future" checked>Coming 7 days</label>
            <label><input type="radio" name="when" value="past">Past 30 days</label>
            <input action="./api" type="submit" value="Check Weather" name="submit">
        </form>
        <table>
            <tr>
                <th>date</th>
                <th>Weather</th>
                <th>Temperature</th>
            </tr>

            <?php
            if(is_array($time)){
                for ($i = 0; $i < count($time); $i++) {
                ?>
            <tr>
                 <td><?php echo $time[$i]; ?></td>
                 <td><?php echo $weather[$i]; ?></td>
                 <td><?php echo $temp[$i]; ?> °C</td>
            </tr>
        <?php }
    } else {
        ?>  <p style= "color: red"> <?php echo $error;
    }
         ?></p>
        </table>
        <?php if(isset($lon) && isset($lat)){ ?>
        <iframe width="75%"
        height="550"
        frameborder="0"
        scrolling="no"
        marginheight="0"
        marginwidth="0"
        src="http://www.openstreetmap.org/export/embed.html?bbox=<?=$lon+0.1?>%2C<?=$lat+0.1?>%2C<?=$lon-0.1?>%2C<?=$lat-0.1?>&amp;marker=<?=$lat?>%2C<?=$lon?>&amp;layers=ND"
        style="border: 1px solid black">
        </iframe>
    <?php } ?>

        <h2>Weather JSON</h2>
        <p>search for an IP-address or city to get weather and get a json response</p>

        <form action="./api" method="get">
            <input type="text" name="search" value="<?= $search ?>">
            <label><input type="radio" name="when" value="future" checked>Coming 7 days</label>
            <label><input type="radio" name="when" value="past">Past 30 days</label>
            <input type="submit" value="create json" name="submit">
        </form>
        <p> api:et fungerar genom att en GET request skickas till API:et darksky
            som levererar svaret i json format</p>
        <p> det finns 2 olika värden som skickas med för är <b>search</b> som tar emot en plats eller gilitg IP adress<br>
        vi har även <b>when</b> som tar emot past eller future. past ger dig väder för dom senaste 30 dagarna medans future ger kommande veckans väder.</p>

    </article>
</html>
