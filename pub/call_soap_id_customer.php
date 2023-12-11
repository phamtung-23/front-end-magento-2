<?php

$request = new SoapClient("https://tungpham.cmmage.app/index.php/soap/?wsdl&services=integrationAdminTokenServiceV1", array("soap_version" => SOAP_1_2));

$token = $request->integrationAdminTokenServiceV1CreateAdminAccessToken(array("username"=>"john.smith", "password"=>"password123"));
print_r($token->result);

$request = new SoapClient("https://tungpham.cmmage.app/index.php/soap/default?wsdl&services=customerCustomerRepositoryV1", 
  array(
      "soap_version" => SOAP_1_2, 
      'stream_context' => stream_context_create(array(
          'http' => array('header' => "Authorization: Bearer " . $token->result)))));

// $customerId = 1; // Replace with the ID of the customer you want to retrieve
// $respone = $request->customerCustomerRepositoryV1GetById(array('customerId' => $customerId));
// print_r($respone);

$serviceArgs = array(
  'searchCriteria' =>
    array(
      'filterGroups' =>
        array(
          array(
            'filters' => array(
              array(
                'field' => 'email',
                'value' => 'roni_cost@example.com',
                'condition_type' => 'like'
              )
            )
          )
        )
    )
);
$respone = $request->customerCustomerRepositoryV1GetList($serviceArgs);
print_r($respone);


?>