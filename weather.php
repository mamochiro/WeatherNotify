<html>
<form action="line.php" method="post" name="form1">
<?php
include('header.php');
$BASE_URL = "http://query.yahooapis.com/v1/public/yql";
    $yql_query = 'select * from weather.forecast where woeid in (select woeid from geo.places(1) where text="kbv")';
    $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";
     //Make call with cURL
    $session = curl_init($yql_query_url);
    curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
    $json = curl_exec($session);
    // Convert JSON to PHP object
    $phpObj =  json_decode($json);
		echo "<div class='columns'>";
		echo "<div class='column is-half is-offset-one-quarter'>";
    echo "<p class='notification is-info'>";
    echo  "<code class='html'>";
    echo $phpObj->query->results->channel->location->city.' Weather  <br/>';
    echo 'Current: '.$phpObj->query->results->channel->item->condition->text.', ';
    echo sprintf("%0.0f", ($phpObj->query->results->channel->item->condition->temp - 32) * 5 / 9).'°C <br/>';

    echo $phpObj->query->results->channel->item->forecast[0]->day.': ';
    echo $phpObj->query->results->channel->item->forecast[0]->text.', ';
    echo '<small>'.sprintf("%0.0f", ($phpObj->query->results->channel->item->forecast[0]->low - 32) * 5 / 9).'Min°C - </small>';
    echo '<small>'.sprintf("%0.0f", ($phpObj->query->results->channel->item->forecast[0]->high - 32) * 5 / 9).'Max°C </small><br/>';

    echo $phpObj->query->results->channel->item->forecast[1]->day.': ';
    echo $phpObj->query->results->channel->item->forecast[1]->text.', ';
    echo '<small>'.sprintf("%0.0f", ($phpObj->query->results->channel->item->forecast[1]->low - 32) * 5 / 9).'Min°C - </small>';
    echo '<small>'.sprintf("%0.0f", ($phpObj->query->results->channel->item->forecast[1]->high - 32) * 5 / 9).'Max°C </small><br/>';
		echo	"<div class='control is-grouped'>";
		echo "<form action='line.php' method='post'>";
    echo  "<p class='control'>";
    echo  "<button class='button is-danger'>";
		echo "SendLine";
		echo "</button>";
    echo  "</p>";
    echo  "</div>";
		echo "</code>";
    echo "</p>";
		echo "</div>";
		echo "</div>";

?>
</form>
</html>
