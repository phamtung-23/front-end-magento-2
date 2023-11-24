<?php

$request = new SoapClient("https://tungpham.cmmage.app/index.php/soap/?wsdl&services=integrationAdminTokenServiceV1", array("soap_version" => SOAP_1_2));
$token = $request->integrationAdminTokenServiceV1CreateAdminAccessToken(array("username"=>"john.smith", "password"=>"password123"));
// echo $token->result;
$request = new SoapClient("https://tungpham.cmmage.app/index.php/soap/default?wsdl&services=catalogProductRepositoryV1", 
  array(
      "soap_version" => SOAP_1_2, 
      'stream_context' => stream_context_create(array(
          'http' => array('header' => "Authorization: Bearer " . $token->result)))));
$serviceArgs = array(
  'searchCriteria' =>
    array(
      'filterGroups' =>
        array(
          array(
            'filters' => array(
              array(
                'field' => 'sku',
                'value' => 'MH13',
                'condition_type' => 'eq'
              )
            )
          )
        )
    )
);
$respone = $request->catalogProductRepositoryV1GetList($serviceArgs);
print_r($respone);
?>