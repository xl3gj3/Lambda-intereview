<?php
/*
phpinfo();
curl_init();
*/
echo "<pre>";



define("USERNAME", "george.mihailov@lambdasolutions.net");
define("PASSWORD", "lambdasecret1");
define("SECURITY_TOKEN", "zGzLgLtwcoViBkDe5r7gAYQMn");

require 'zendesk/vendor/autoload.php';
require_once ('soapclient/SforceEnterpriseClient.php');
use GuzzleHttp\Handler\CurlFactory;
use Zendesk\API\HttpClient as ZendeskAPI;

$mySforceConnection = new SforceEnterpriseClient();


/*************************************************

sforce is an objects

********************************************************************/
$tempvar = $mySforceConnection->createConnection("soapclient/enterprise.wsdl.xml");

$mySforceConnection->login(USERNAME, PASSWORD.SECURITY_TOKEN);

$information["name"] = 'United Oil & Gas, UK3';
//$query = "SELECT Name from Contact WHERE AccountId = '001o0000006Wa6xAAC'" ;
$response = $mySforceConnection->query($query);

//echo "Results of query '$query'<br/><br/>\n";
foreach ($response->records as $record) {
  //  echo $record->Name ." <br>";
    $information["Account Owner"] = $record->Name;
}



//$query = "SELECT Id, OwnerId, Name, Website, BillingStreet, Phone  from Account WHERE Name = 'United Oil & Gas, UK'" ;
$response = $mySforceConnection->query($query);


//echo "Results of query '$query'<br/><br/>\n";
foreach ($response->records as $record) {

    $information["Website"] = $record->Website;
    $information["Address"] = $record->BillingStreet;
    $information["Phone"] = $record->Phone;

}

var_dump($information);

/****************************************
We got United Oil & Gas, UK above, we are going to put those information in to zendesk
********************************************/

/************
we loging into zendesk fann_get_rprop_increase_factor

******************/
try {
  $subdomain = "lambdasolutionsdev";
  $username  = "mariya.pak@lambdasolutions.net"; // replace this with your registered email
  $token     = "drv5UZaRc7A8WcXwWErssQ6GIEgxIwLO8xiPPYe6"; // replace this with your token
  $client = new ZendeskAPI($subdomain);
  $test = $client->setAuth('basic', ['username' => $username, 'token' => $token]);
  $client->tickets()->findAll();
  //print_r($tickets);
} catch (Exception $e) {
  echo"<br> error happen";
  var_dump($e);
}

echo"<br>";
$update = array(
  "name" => $information["name"],
  "details" => "Address is ". $information["Address"],
  "organization_fields" => array(
  "account_owner" => $information["Account Owner"] ,
  "phone_number"  => $information["Phone"],
  "website" => $information["Website"],
  "address" =>$information["Address"]
  )
);


$total["organization"] = $update;
$json_organization = json_encode($total);
/*

this is for testing

var_dump($total);
echo $json_organization;

echo"<br><br><br><br>";
*/
/*************
Create organization
****************/
$username = "mariya.pak@lambdasolutions.net";
$password = "lambdasecret1";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://lambdasolutionsdev.zendesk.com/api/v2/organizations/9860380587.json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
// PUT should be POST if we are creating. Otherwise, we use PUT to update
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS,$json_organization );
//curl_setopt($ch, CURLOPT_POST,true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json')
);
$output = curl_exec($ch);
curl_close($ch);
/*

this is for debugging

$newoutput = json_decode($output );

var_dump($newoutput);

$info = curl_getinfo($ch);

//var_dump($info);

*/

echo "</pre>";

?>
