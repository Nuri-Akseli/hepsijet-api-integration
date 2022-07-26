<?php

    require "Services/TokenService.php";
    require "Services/SettlementService.php";
    require "Services/DeliveryService.php";
    $tokenService=new TokenService();
    //$settlementService=new SettlementService();
    //$deliveryService=new DeliveryService();
    
    echo "<pre>";
    print_r($tokenService->getToken());
    //print_r($settlementService->getCities());
    //print_r($deliveryService->getEndOfTheDay());
    

    //print_r($deliveryService->getDeliveryTracking("deneme1234"));
    //print_r($deliveryService->deleteDeliveryOrder("deneme1234","Test"));
    
    /*$barcodes=array();
    array_push($barcodes,"deneme1234");
    $result=$deliveryService->getDeliveryTrackingWithTrackingUrl($barcodes);
    if($result->status=="OK"){
        print_r($result->data[0]);
    }else{
        echo "something is wrong";
    }*/
?>
    
