<?php
    require_once("./services/ordersService.php");
    $dressOrders=getWeddingDressOrders("",0,1000);
    //"code": 0, "msg": "", "count": 1000, "data"
    $result=[
        "code"=>0,
        "msg"=>"",
        "count"=>$dressOrders['totalRows'],
        "data"=>$dressOrders['weddingDressOrders']
    ];
    echo json_encode($result);