<?php
   //echo "hello world";
   require_once('vendor/autoload.php');
   use OCLC\Auth\WSKey;
   use OCLC\User;
   use GuzzleHttp\Client;
   use GuzzleHttp\Exception\RequestException;
   
   $key = '';
   $secret = '';
   $wskey = new WSKey($key, $secret);
   
   $url = 'https://worldcat.org/bib/data/823520553?classificationScheme=LibraryOfCongress&holdingLibraryCode=MAIN';
   
   $user = new User('128807', '', '');
   $options = array('user'=> $user);
   
   $authorizationHeader = $wskey->getHMACSignature('GET', $url, $options);
    
   $client = new Client();
   $headers = array();
   $headers['Authorization'] = $authorizationHeader;
   
   try {
        $response = $client->request('GET', $url, ['headers' => $headers]);
        echo $response->getBody(TRUE);
   } catch (RequestException $error) {
        echo $error->getResponse()->getStatusCode();
        echo $error->getResponse()->getBody(true);
   }
   
   //https://circ.{datacenter}.worldcat.org/LHR?q=oclc:{OCLC_number}
?>