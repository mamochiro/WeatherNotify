
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

$m = "message=";
$a = $phpObj->query->results->channel->location->city.' Weather ';
$a1='Current: '.$phpObj->query->results->channel->item->condition->text.', ';
 $a2=sprintf("%0.0f", ($phpObj->query->results->channel->item->condition->temp - 32) * 5 / 9).'°C ';

$a3=$phpObj->query->results->channel->item->forecast[0]->day.': ';
 $a4=$phpObj->query->results->channel->item->forecast[0]->text.', ';
$a5= sprintf("%0.0f", ($phpObj->query->results->channel->item->forecast[0]->low - 32) * 5 / 9).'Min°C -';
$a6=sprintf("%0.0f", ($phpObj->query->results->channel->item->forecast[0]->high - 32) * 5 / 9).'Max°C ';

$a7= $phpObj->query->results->channel->item->forecast[1]->day.': ';
 $a8=$phpObj->query->results->channel->item->forecast[1]->text.', ';
$a9=sprintf("%0.0f", ($phpObj->query->results->channel->item->forecast[1]->low - 32) * 5 / 9).'Min°C -';
$a10=sprintf("%0.0f", ($phpObj->query->results->channel->item->forecast[1]->high - 32) * 5 / 9).'Max°C ';

$Text = $m.$a.$a1.$a2.$a3.$a4.$a5.$a6.$a7.$a8.$a9.$a10;

echo '<br>';
echo '<br>';

$chOne = curl_init();
curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
// SSL USE
curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
//POST
curl_setopt( $chOne, CURLOPT_POST, 1);
// Message
curl_setopt( $chOne, CURLOPT_POSTFIELDS, $Text);
//ถ้าต้องการใส่รุป ให้ใส่ 2 parameter imageThumbnail และimageFullsize
//curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=hi&imageThumbnail=http://www.wisadev.com/wp-content/uploads/2016/08/cropped-wisadevLogo.png&imageFullsize=http://www.wisadev.com/wp-content/uploads/2016/08/cropped-wisadevLogo.png");
// follow redirects
curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
//ADD header array
$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer W7FOiuVmB4m8oXFE0V6QJ3ulZMEMm3voBPfOdCHNPla', );
curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
//RETURN
curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec( $chOne );
//Check error
if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
else { $result_ = json_decode($result, true);
  echo "<div class='column is-one-quarter'>";
  echo "<div class='column is-half is-offset-one-quarter'>";
  echo "<p class='notification is-success>";
  echo  "<code class='html'>";
echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
echo  "</p>";
echo  "</div>";
echo "</code>";
echo "</p>";
echo "</div>";
echo "</div>";
//Close connect
curl_close( $chOne );



 ?>
