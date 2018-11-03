<?php 
	require_once("dbHelper.php");

	/**
	* 获取用户列表
	* 返回值：执行成功，返回用户列表数组；执行失败，返回null
	*/

	function getAllMembers($key="",$startIndex=0,$pageSize=1000){
		$sql1="select id,phone,header,nickname from members where 1=1";
		$sql2="select count(1) from members WHERE 1=1";
		if(""!=$key){
            $sql1.=" and INSTR(name,'{$key}')>0 or INSTR(phone,'{$key}')>0 ";
            $sql2.=" and INSTR(name,'{$key}')>0 or INSTR(phone,'{$key}')>0 ";
        }
        $sql1.=" limit {$startIndex},{$pageSize};";
        $sql=$sql1.$sql2;
		$result=executeMultiQuery($sql);
		$list=null;
		if(!is_null($result)){
            $members=[];
            foreach ($result[0] as $item){
                $members[]=[
                    "id"=>$item[0],
                    "phone"=>$item[1],
                    "header"=>$item[2],
                    "nickname"=>$item[3]

                ];
            }
            $list['members']=$members;
            $list['totalRows']=$result[1][0][0];
        }

        return $list;
	}




