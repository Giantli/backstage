<?php
	header("Content-type:application/json;charset=utf-8");

	// header("Access-Control-Allow-Origin:*"); //*号表示所有域名都可以访问  
 // 	header("Access-Control-Allow-Method:POST,GET");  

	require_once("../services/photographyService.php");
	require_once("util/constants.php");

	// 处理对members对象的操作

	$methodList = ["create" , "edit"];

	$method = $_REQUEST["method"];

	if(!array_key_exists("method", $_REQUEST)){
		echo json_encode(buildResponseResult(CODE_PARAM_INVALID , MESSAGE_PARAM_INVALID));
		exit();
	}

	$method = strtolower($method);

	if(!in_array($method , $methodList)){

		echo json_encode(buildResponseResult(CODE_REQUEST_NOT_FOUND , MESSAGE_REQUEST_NOT_FOUND));
		exit();
	}


	$result = buildResponseResult(CODE_RESPONSE_FAILURE , MESSAGE_RESPONSE_FAILURE);

	/**
	* 创建时传递参数：areaId , versionId，name ，price ，image
	*/
	if($method == "create"){
		$areaId = $_POST["areaId"];
		$versionId = $_POST["versionId"];
		$name = $_POST["name"];
		$price = $_POST["price"];
		$image = $_POST["image"];

		$create = createPhotographyPackage($areaId , $versionId , $name , $price , $image);

		if(!is_null($create)){
			$result = buildResponseResult(CODE_RESPONSE_SUCCESS , MESSAGE_RESPONSE_SUCCESS , $create);
		}
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