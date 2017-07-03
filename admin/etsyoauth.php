<?php
  
  //http://windows.php.net/downloads/pecl/releases/oauth/
  $oauth = new OAuth('swb347dphrz1j16j1r0nra5l', 'cphwwygq2p');
  $oauth->disableSSLChecks();
  $req_token = $oauth->getRequestToken("https://openapi.etsy.com/v2/oauth/request_token?scope=email_r%20listings_r", 'oob');
  $login_url = sprintf(
    "%s?oauth_consumer_key=%s&oauth_token=%s",
    $req_token['login_url'],
    $req_token['oauth_consumer_key'],
    $req_token['oauth_token']
  );
  print "go to this url:\n\n  ".$login_url."\n";
  print "then tell me what the verifier code you get back is: \n\n";
  $handle = fopen("php://stdin","r");
  $line = fgets($handle);
  $request_token = $req_token['oauth_token'];
  $request_token_secret = $req_token['oauth_token_secret'];
  $verifier = trim($line);
  print "you said {$verifier}\n\n";
  print "now let's see what we can get back from Etsy...\n\n";
  $oauth->setToken($request_token, $request_token_secret);
  try {
    $access_token = $oauth->getAccessToken("https://openapi.etsy.com/v2/oauth/access_token", null, $verifier);
  } catch (OAuthException $e) {
    print_r($e->getMessage());
  }
  $oauth_token = $access_token['oauth_token'];
  $oauth_token_secret = $access_token['oauth_token_secret'];
  $oauth->setToken($oauth_token, $oauth_token_secret);
  try {
    $data = $oauth->fetch("https://openapi.etsy.com/v2/private/users/__SELF__");
    $json = $oauth->getLastResponse();
    print_r(json_decode($json, true));
  } catch (OAuthException $e) {
    error_log($e->getMessage());
    error_log(print_r($oauth->getLastResponse(), true));
    error_log(print_r($oauth->getLastResponseInfo(), true));
    exit;
  }
?>