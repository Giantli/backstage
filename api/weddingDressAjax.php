<?php
    header("Content-type:application/json;charset=utf-8");
    require_once("../services/weddingDressService.php");
    require_once("util/constants.php");

    $method = $_REQUEST["method"];

    if(!array_key_exists("method", $_REQUEST)){
        echo json_encode(buildResponseResult(CODE_PARAM_INVALID , MESSAGE_PARAM_INVALID));
        exit();
    }

    $method = strtolower($method);

    $result = buildResponseResult(CODE_RESPONSE_FAILURE , MESSAGE_RESPONSE_FAILURE);

if($method=='add'){
    $name=$_REQUEST["name"];
    $image=$_REQUEST["image"];
    $pendulum=$_REQUEST["pendulum"];
    $style=$_REQUEST["style"];
    $price=$_REQUEST["price"];
    $list=addWeddingDress($name,$image,$pendulum,$style,$price);
    $result = buildResponseResult(CODE_RESPONSE_SUCCESS , MESSAGE_RESPONSE_SUCCESS , $list);
}

if($method=='edit'){
    $id=$_REQUEST["id"];
    $name=$_REQUEST["name"];
    $image=$_REQUEST["image"];
    $pendulum=$_REQUEST["pendulum"];
    $style=$_REQUEST["style"];
    $price=$_REQUEST["price"];
    $list=editWeddingDress($id,$name,$image,$pendulum,$style,$price);
    $result = buildResponseResult(CODE_RESPONSE_SUCCESS , MESSAGE_RESPONSE_SUCCESS , $list);
}

echo json_encode($result);







    /**返回值**/
    function buildResponseResult($code , $msg , $data = null){
        return [
            "code" => $code,
            "message" => $msg,
            "data" => $data
        ];
    }