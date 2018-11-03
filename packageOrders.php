<?php
require_once("./services/ordersService.php");
$packageOrders=getPhotographyOrders("",0,1000);
//"code": 0, "msg": "", "count": 1000, "data"
$result=[
    "code"=>0,
    "msg"=>"",
    "count"=>$packageOrders['totalRows'],
    "data"=>$packageOrders['photographyOrders']
];
echo json_encode($result);