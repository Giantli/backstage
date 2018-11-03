<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3
 * Time: 9:56
 */
    require_once("dbHelper.php");
/**
 * 后台管理员登录
 * 返回值：登录成功，返回用户信息；否则返回null
 */
    function login($name,$password){
        $sql="select id,empno,trueName  from managers WHERE empNo='{$name}' AND `password`=PASSWORD('$password')";
        $result=executeQuery($sql);
        $list=null;
        if($result){
            foreach ($result as $item){
                $list=[
                    "id"=>$item[0],
                    "empNo"=>$item[1],
                    "trueName"=>$item[2]
                ];

            }

        }
        return $list;
    }

    function updatePwd($name,$oldPwd,$newPwd){
        $sql="update managers set `password`=PASSWORD('{$newPwd}') WHERE empNo='{$name}' AND `password`=PASSWORD('{$oldPwd}') ";
        return executeNonQuery($sql);
    }
