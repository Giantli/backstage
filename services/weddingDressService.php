<?php 
	require_once("dbHelper.php");
	/**
	* 获取婚纱摆型列表
	* 返回值：执行成功，返回地区列表数组； 执行失败，返回null;
	*/

	function getPendulums(){
		$sql="select id,name from pendulum";
		$result=executeQuery($sql);
		$list=null;
		if($result){
			$list=[];
			foreach($result as $item){
				$list[]=[
					"id"=>$item[0],
					"name"=>$item[1]
				];

			}
			return $list;
		}
		return $list;
	}

	/**
	* 获取婚纱款式列表
	* 返回值：执行成功，返回地区列表数组； 执行失败，返回null;
	*/

	function getStyles(){
		$sql="select id,name from style";
		$result=executeQuery($sql);
		$list=null;
		if($result){
			$list=[];
			foreach($result as $item){
				$list[]=[
					"id"=>$item[0],
					"name"=>$item[1]
				];

			}
			return $list;
		}
		return $list;
	}

	/**
	* 获取婚纱列表
	* 返回值：执行成功，返回地区列表数组； 执行失败，返回null;
	*/

	function getWeddingDresses($pendulumId="",$styleId="",$key="",$startIndex=0,$pageSize=16){
		$sql1="select t1.id,t1.name,t1.image,t2.name,t3.name,t1.price from weddingDress t1 INNER JOIN pendulum t2 on t1.pendulumId=t2.id INNER JOIN style t3 on t1.styleId=t3.id where 1=1 ";
		$sql2="select count(1) from weddingDress t1 INNER JOIN pendulum t2 on t1.pendulumId=t2.id INNER JOIN style t3 on t1.styleId=t3.id where 1=1";
		if(""!=$pendulumId){
            $sql1.=" and t1.pendulumId='{$pendulumId}' ";
            $sql2.=" and t1.pendulumId='{$pendulumId}' ";
        }
        if(""!=$styleId){
            $sql1.=" and t1.styleId='{$styleId}' ";
            $sql2.=" and t1.styleId='{$styleId}' ";
        }
        if(""!=$key){
            $sql1.=" and INSTR(t1.`name`,'{$key}') > 0 ";
            $sql2.=" and INSTR(t1.`name`,'{$key}') > 0 ";
        }
		$sql1.=" limit {$startIndex},{$pageSize};";
		$sql=$sql1.$sql2;
		$result=executeMultiQuery($sql);
		$list=null;

		if(!is_null($result)){
			$lists=[];
			foreach ($result[0] as $item) {
				$lists[]=[
					"id"=>$item[0],
					"name"=>$item[1],
					"images"=>explode(',',$item[2]),
					"pendulumName"=>$item[3],
					"styleName"=>$item[4],
					"price"=>$item[5]
				];

			}
			$list['weddingDresses']=$lists;
			$list['totalRows']=$result[1][0][0];
		}
		return $list;

	}

    /**
     * 通过Id获取单个婚纱
     * 参数：id
     * 返回值：执行成功，返回单肩婚纱；执行失败，返回空
     */
    function getWeddingDressById($id){
        $sql="select t1.id,t1.name,t1.image,t2.name,t3.name,t1.price from weddingDress t1 INNER JOIN pendulum t2 on t1.pendulumId=t2.id INNER JOIN style t3 on t1.styleId=t3.id where 1=1 and t1.id='{$id}'";
        $result=executeQuery($sql);
        $list=null;
        if(!is_null($result)){

            foreach($result as $item) {
                $list = [
                    "id" => $item[0],
                    "name" => $item[1],
                    "images" => explode(',', $item[2]),
                    "pendulumName" => $item[3],
                    "styleName" => $item[4],
                    "price" => $item[5]
                ];
            }


            return $list;
        }
        return $list;
    }

    /**
     * 添加新婚纱
     * 参数：给出婚纱名字，图片，摆型，款型，价格
     * 返回值：执行成功，返回影响的行数； 执行失败，返回false;
     */
    function addWeddingDress($name,$image,$pendulum,$style,$price){
        $sql="insert into weddingdress(id,name,image,pendulumId,styleId,price) value(UUID() , '{$name}',
              '{$image}','{$pendulum}','{$style}','{$price}')";
        return executeNonQuery($sql);
    }

    /**
     * 修改婚纱
     * 参数：给出婚纱名字，图片，摆型，款型，价格
     * 返回值：执行成功，返回影响的行数； 执行失败，返回false;
     */
    function editWeddingDress($id,$name,$image,$pendulum,$style,$price){
        $sql="update weddingdress set name='{$name}',iamge='{$image}',pendulum='{$pendulum}',style='{$style}',
              price='{$price}' where id='{$id}' ";
        return executeNonQuery($sql);
    }


