<?php
    header("content-type:application/json;charset=utf-8");
    // 获取文件
    $file = $_FILES["img"];

    $code = 101;
    $message = "上传失败";
    $data = "";


    if($file["error"] == UPLOAD_ERR_OK){
        // 检查文件的有效性

        //
        $ext = pathinfo($file["name"] , PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $ext;
        // 保存
        if(move_uploaded_file($file["tmp_name"] , 'images/' . $fileName)){
            $data = $fileName;
            $code = 100;
            $message = "上传成功";
        }
    }

    $result = compact("code" , "message" , "data");



    // 响应
    echo json_encode($result);