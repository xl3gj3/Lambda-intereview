<?php
include("../vendor/autoload.php");
echo"<pre>";
use Zendesk\API\HttpClient as ZendeskAPI;

/**
 * Replace the following with your own.
 */
$subdomain = "lambdasolutionsdev";
$username  = "mariya.pak@lambdasolutions.net";
$token     = "rZKnn8VC3H354ijiVNUpfKZAOZsNVsHPka2O7DJT";

$client = new ZendeskAPI($subdomain);
$client->setAuth('basic', ['username' => $username, 'token' => $token]);

try {
    // Get all tickets
    $tickets = $client->tickets()->findAll();
    // Create a new ticket
    $newTicket = $client->tickets()->create(array(
        'subject'  => 'The quick brown fox jumps over the lazy dog',
        'comment'  => array(
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
        ),
        'priority' => 'normal'
    ));

    print_r($tickets);
    print_r($newTicket);
} catch (\Zendesk\API\Exceptions\ApiResponseException $e) {
    echo $e->__toString();
    echo 'Please check your credentials. Make sure to change the $subdomain, $username, and $token variables in this file.';
}
echo"<pre>";
?>
