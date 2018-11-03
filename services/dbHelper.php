<?php
define("DB_HOST" , "127.0.0.1");
define("DB_USER" , "root");
define("DB_PASSWORD", "888");
define("DB_DATABASE" , "weddingdb");

// 执行DML（insert,update,delete语句）
function executeNonQuery($sql){
    $con = new mysqli(DB_HOST , DB_USER , DB_PASSWORD , DB_DATABASE);
    $con->query("set names utf8");
    if($con -> connect_errno){
        return false;
    }
    $result = $con -> query($sql);
    if($result){
        $val = $con -> affected_rows;
        $con -> close();
        return $val;
    }
    else{
        $con -> close();
        return false;
    }
}

// 执行D(select语句)
function executeQuery($sql){
    $con = new mysqli(DB_HOST , DB_USER , DB_PASSWORD , DB_DATABASE);
    $con->query("set names utf8");
    if($con -> connect_errno){
        return false;
    }

    $result = $con -> query($sql);

    if($result){
        $list = [];
        if($result -> num_rows > 0){
            while($row = $result -> fetch_row()){
                $list[] = $row;
            }
        }
        $result -> close();
        $con -> close();
        return $list;
    }
    else{
        $con -> close();
        return false;
    }

}


//批量查询
function executeMultiQuery($sql){
    $con = new mysqli(DB_HOST , DB_USER, DB_PASSWORD , DB_DATABASE);
    $con->query("set names utf8");
    if($con -> connect_errno){
        return null;
    }
    $list = null;
    $result = $con -> multi_query($sql);

    if($result){
        $list = [];
        do{
            $item = null;
            $rs = $con -> store_result();
            if($rs){
                $item = [];
                while($row = $rs -> fetch_row()){
                    $item[] = $row;
                }
                $rs -> close();
            }
            $list[] = $item;
        }while($con -> more_results() && $con -> next_result());
    }
    $con -> close();
    return $list;
}


