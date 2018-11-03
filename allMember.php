<?php
    require_once("./services/memberService.php");
    $members=getAllMembers("",0);
//"code": 0, "msg": "", "count": 1000, "data"
    $result=[
        "code"=>0,
        "msg"=>"",
        "count"=>$members['totalRows'],
        "data"=>$members['members']
    ];
    echo json_encode($result);
