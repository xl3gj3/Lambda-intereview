<?php
echo "<pre>";
require 'zendesk_api_client_php/vendor/autoload.php';

use Zendesk\API\HttpClient as ZendeskAPI;


$username = "mariya.pak@lambdasolutions.net";
$password = "lambdasecret1";
//$curl = curl_init("https://lambdasolutionsdev.zendesk.com/api/v2/organizations.json");



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://lambdasolutionsdev.zendesk.com/api/v2/organizations.json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
//curl_setopt($ch, CURLOPT_POST,true);
//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
//curl_setopt($ch, CURLOPT_POSTFIELDS,$json_organization );

curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
/*curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json')
);*/

$output = curl_exec($ch);

$newoutput = json_decode($output);

var_dump($newoutput);

//print_r(get_declared_classes());
//var_dump($client);

//var_dump(class_exists('ZendeskAPI'));


curl_close($ch);

//var_dump($test);

echo "</pre>";
?>
