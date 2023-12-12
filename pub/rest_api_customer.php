<?php

// Replace with your actual Magento 2 base URL
$baseUrl = 'https://tungpham.cmmage.app';

// Admin credentials for OAuth authentication
$adminUsername = 'john.smith';
$adminPassword = 'password123';

// REST API endpoint URL
$apiUrl = "{$baseUrl}/rest/V1/customers/1"; // Replace '1' with the customer ID you want to retrieve

// Get access token using OAuth
$accessToken = getAccessToken($baseUrl, $adminUsername, $adminPassword);

// Make REST API call to retrieve customer information
$customerData = makeApiCall($apiUrl, $accessToken);

// Print the customer information
print_r($customerData);

/**
 * Function to get OAuth access token
 *
 * @param string $baseUrl
 * @param string $username
 * @param string $password
 * @return string
 */
function getAccessToken($baseUrl, $username, $password)
{
    $tokenUrl = "{$baseUrl}/rest/V1/integration/admin/token";

    $tokenData = [
        'username' => $username,
        'password' => $password,
    ];

    $ch = curl_init($tokenUrl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($tokenData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

/**
 * Function to make REST API call
 *
 * @param string $apiUrl
 * @param string $accessToken
 * @return mixed
 */
function makeApiCall($apiUrl, $accessToken)
{
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}
