<html>
<?php
require 'vendor/autoload.php';

use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\crm\crud\ZCRMRecord;



$client_id = "1000.F6Z6JRG6ANKECQ46V6RC7BV8LF7DXH";
$client_secret = "08101d659dc75042d9a68361232d57157f8fc09c8a";
$redirect_uri = "https://ame-staging.efsnetworks.com/publish/test.php";
$configuration=array("client_id"=>$client_id,"client_secret"=>$client_secret,"redirect_uri"=>"https://ame-staging.efsnetworks.com/publish/test.php","currentUserEmail"=>"miaia@altamontenterprise.com","token_persistence_path"=>".");
ZCRMRestClient::initialize($configuration);
$oAuthClient = ZohoOAuth::getClientInstance();
//$grantToken = "1000.37fc4c247856478bca59d82d6c62a580.2bf6ce5852f1d18dc154f9b18a6d228a";
//$oAuthTokens = $oAuthClient->generateAccessToken($grantToken);
//echo json_encode($oAuthTokens);
//"token_persistence_path"=>"/var/www/html/alta$
$rest=ZCRMRestClient::getInstance();
$record_instance=$rest->getRecordInstance("contacts","1652825000018446001");
$data = (array) $record_instance;
echo $oAuthClient->getDetails();

?>
</html>
