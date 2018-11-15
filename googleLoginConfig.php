<?php

//Include Google client library
include_once 'googleLogin-src/Google_Client.php';
include_once 'googleLogin-src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$clientId = '568378075378-nce10tn9m1oa8gk9eukmipuh97g3t3sj.apps.googleusercontent.com'; //Google client ID
$clientSecret = 'nOygLlGsN3VZtD_7xMc9Ia6u'; //Google client secret
$redirectURL = 'http://localhost/cars/googleLoginRedirect.php'; //Callback URL


//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to CodexWorld.com');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>
