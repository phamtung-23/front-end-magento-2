<?php

$request = new SoapClient("https://tungpham.cmmage.app/index.php/soap/?wsdl&services=integrationAdminTokenServiceV1", array("soap_version" => SOAP_1_2));

$token = $request->integrationAdminTokenServiceV1CreateAdminAccessToken(array("username"=>"john.smith", "password"=>"password123"));
print_r($token->result);

$request = new SoapClient("https://tungpham.cmmage.app/index.php/soap/default?wsdl&services=catalogProductRepositoryV1", 
  array(
      "soap_version" => SOAP_1_2, 
      'stream_context' => stream_context_create(array(
          'http' => array('header' => "Authorization: Bearer " . $token->result)))));
// get list product by filter
$serviceArgs = array(
  'searchCriteria' =>
    array(
      'filterGroups' =>
        array(
          array(
            'filters' => array(
              array(
                'field' => 'test_ok',
                'value' => '1',
                'condition_type' => 'eq'
              )
            )
          )
        ),
      'sortOrders' =>
        array(
          array(
            'field' => 'created_at',
            'direction' => 'DESC'
          )
        )
    )
);
$respone = $request->catalogProductRepositoryV1GetList($serviceArgs);
print_r($respone);

// use method get to get product by sku
$serviceArgsGet = array(
  'sku' => 'ProductTest1'
);

$response = $request->catalogProductRepositoryV1Get($serviceArgsGet);
print_r($response);
?>
