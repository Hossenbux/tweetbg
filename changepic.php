<?php

// TWITTER API Control
  require 'tmhOAuth.php';
  require 'tmhUtilities.php';
  $tmhOAuth = new tmhOAuth(array(
    'consumer_key'    => 'lpo4eXEo6TA7cevEX1N2NQ',
    'consumer_secret' => 'XdXkGxoVovp0dsVGJoCG20XLapFy0J1wL83yBVlR78',
    'user_token'      => '10965912-s0UfFqxl9PT3oZ0CZtJgOamwuYLsR3ih5Yo6xLG8Q',
    'user_secret'     => 'KyUgNXSTNYWbHvlXY3kfFQsufSIkYqXTPKPqKAWclE',
  ));

  
  $filename = "jpeg.jpeg";
  
  $params = array(
    // Posting the Image file, irrelephant
    //'image' => "@{$_FILES['image']['tmp_name']};type={$_FILES['image']['type']};filename={$_FILES['image']['name']}",
	'image' => "@$filename;type=JPEG;filename=$filename",
  );

  // if we are setting the background we want it to be displayed
  if ($_REQUEST['method'] == 'update_profile_background_image')
    $params['use'] = 'true';

  $code = $tmhOAuth->request('POST', $tmhOAuth->url("1/account/{$_REQUEST['method']}"),
    $params,
    true, // use auth
    true  // multipart
  );

  if ($code == 200) {
    tmhUtilities::pr(json_decode($tmhOAuth->response['response']));
  }
  tmhUtilities::pr(htmlentities($tmhOAuth->response['response']));


?>