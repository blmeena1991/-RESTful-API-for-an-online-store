<?php
/**
 * Created by PhpStorm.
 * User: blmeena
 * Date: 27/04/17
 * Time: 11:45 PM
 */

function call($url,$type='GET',$payload=null){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL,$url);

    if($type=='POST') {
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    }
    $result=curl_exec($ch);
    curl_close($ch);
    //$result = json_decode($result, true);
    return  $result;
}


//Case 1 :Get API Token //

$username='blmeena1991';
$response=call('http://wingify.local/users/generateToken/blmeena1991');
print_r($response);
$response=json_decode($response,true);
$token=$response['api_token'];
print_r($token);
echo " \r\n=========================================TEST 1 END ============================= \r\n";
//Case 2 :Get Product list  //

$response=call('http://wingify.local/products/index?token='.$token);
print_r($response);
echo " \r\n=========================================TEST 2 END ============================= \r\n";
//Case 3 :FInd Product  //

$response=call('http://wingify.local/products/find?query=test%20product&token='.$token);
print_r($response);
echo " \r\n=========================================TEST 3 END ============================= \r\n";

//Case 4 :View Product info //


$response=call('http://wingify.local/products/view/8?token='.$token);
print_r($response);
echo " \r\n=========================================TEST 4 END ============================= \r\n";

//Case 5:Delete Product info //


$response=call('http://wingify.local/products/delete/4?token='.$token);
print_r($response);
echo " \r\n=========================================TEST 4 END ============================= \r\n";


//Case 6:Add Product //

$payload='{
    "Product": {

        "product_title": "Test Product 1",
    "sku_code": "123",
    "unit_price": "200.00",
    "image_1": "acs",
    "image_2": "asdsa",
    "image_3": "asds",
    "description": "assadsadsamfnavmadvcad",
    "status": "1"
  },
  "Variation": [
    {
        "Variation": {
        "variation_name": "size",
        "variation_value": "SL"
      }
    }
  ]
}';
$response=call('http://wingify.local/products/add?token='.$token,'POST',$payload);
print_r($response);
echo " \r\n=========================================TEST 4 END ============================= \r\n";


//Case 7:Edit Product //

$payload='{
    "Product": {
       "id":8,
       "category_name":"Electrons",
      "product_title": "Test Product 1",
    "sku_code": "123",
    "unit_price": "2000.00",
    "image_1": "acs",
    "image_2": "asdsa",
    "image_3": "asds",
    "description": "assadsadsamfnavmadvcad",
    "status": "1"
  },
  "Variation": [
    {
        "Variation": {
        "variation_name": "size",
        "variation_value": "SL"
      }
    }
  ]
}';
$response=call('http://wingify.local/products/edit?token='.$token,'POST',$payload);
print_r($response);
echo " \r\n=========================================TEST 4 END ============================= \r\n";



//Case 8:Edit Product  with unauthorized user //

$payload='{
    "Product": {
       "id":8,
       "category_name":"Electrons",
      "product_title": "Test Product 1",
    "sku_code": "123",
    "unit_price": "2000.00",
    "image_1": "acs",
    "image_2": "asdsa",
    "image_3": "asds",
    "description": "assadsadsamfnavmadvcad",
    "status": "1"
  },
  "Variation": [
    {
        "Variation": {
        "variation_name": "size",
        "variation_value": "SL"
      }
    }
  ]
}';
$response=call('http://wingify.local/products/edit','POST',$payload);
print_r($response);
echo " \r\n=========================================TEST 4 END ============================= \r\n";
