<?php
ini_set('max_execution_time', 0);
set_time_limit(0);


$adminUrl='https://tungpham.cmmage.app/rest/V1/integration/admin/token';
$ch = curl_init();
$data = array("username" => "john.smith", "password" => "password123");                                                                    
$data_string = json_encode($data);                       
$ch = curl_init($adminUrl); 
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);       
$token = curl_exec($ch);
$token =  json_decode($token);    
echo $token;
// @Todo : foreach youtube video
// get sku + Video ID
// import 

    $sku = 'MH13';
		$ch = curl_init("https://tungpham.cmmage.app/rest/V1/products/" . $sku . "/media"); 
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $token));
		
		$response = curl_exec($ch);
		$responseData = json_decode($response, true);
    print_r($responseData);


// 
// echo $response;
// if ($response == '1'){
//   echo 'video ajoutee ok';
// }
// else {
//   echo 'fial';
// }