<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

/**
 * Update the users profile image, or profile background image using OAuth.
 *
 * Although this example uses your user token/secret, you can use
 * the user token/secret of any user who has authorised your application.
 *
 * Instructions:
 * Instructions:
 * 1) If you don't have one already, create a Twitter application on
 *      https://dev.twitter.com/apps
 * 2) From the application details page copy the consumer key and consumer
 *      secret into the place in this code marked with (YOUR_CONSUMER_KEY
 *      and YOUR_CONSUMER_SECRET)
 * 3) From the application details page copy the access token and access token
 *      secret into the place in this code marked with (A_USER_TOKEN
 *      and A_USER_SECRET)
 * 4) Visit this page using your web browser.
 *
 * @author themattharris
 */

  require 'tmhOAuth.php';
  require 'tmhUtilities.php';
  $tmhOAuth = new tmhOAuth(array(
    'consumer_key'    => 'lpo4eXEo6TA7cevEX1N2NQ',
    'consumer_secret' => 'XdXkGxoVovp0dsVGJoCG20XLapFy0J1wL83yBVlR78',
    'user_token'      => '10965912-s0UfFqxl9PT3oZ0CZtJgOamwuYLsR3ih5Yo6xLG8Q',
    'user_secret'     => 'KyUgNXSTNYWbHvlXY3kfFQsufSIkYqXTPKPqKAWclE',
  ));

  // note the type and filename are set here as well
  
  $filename = "jpeg.jpeg";
  
  $params = array(
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