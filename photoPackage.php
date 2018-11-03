<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="./plugins/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="./css/photoPackage.css">
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./lib/css/bootstrap.min.css">
    <link rel="stylesheet" href="./lib/css/fontello.css">
    <link rel="stylesheet" href="css/page.css">

    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<?php
    require("./services/photographyService.php");
    $versionId="";
    $key="";
    $message="";
    $versionList=getVersions();
    $photoPackageList=[];
    $pageIndex=0;
    $pageSize=14;
    $totalPageCount=0;
    if(array_key_exists('versionId',$_REQUEST)){
        $versionId=$_REQUEST['versionId'];
    }
    if(array_key_exists('key',$_REQUEST)){
        $key=$_REQUEST['key'];
    }
    if(array_key_exists("currentPage" , $_REQUEST)){
        $pageIndex = intval($_REQUEST["currentPage"]);
    }
    $photoPackageList=getPhotographyPackages("",$versionId,$pageIndex*$pageSize,$pageSize);
    if(count($photoPackageList['photographyPackage'])>0&&!is_null($photoPackageList)){

    }

    elseif(is_null($photoPackageList)){
        $message='查询失败';
    }
    else{
        $message='暂无数据';
    }

    $totalPageCount= ceil($photoPackageList['totalRows']/$pageSize);

?>
<body>
<div class="middle">
    <div class="header"><h2>套餐管理</h2></div>
    <a class="addButton" href="addPhotoPackage.php"><i class="icon-plus"></i>添加套餐</a>
    <div class="search">
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <select class="form-control" style="width:80%; display:inline-block;" name="versionId">
                <option value="">全部版本</option>
                <?php foreach ($versionList as $item){ ?>
                    <option <?php echo $versionId==$item['id']?'selected':'' ?> value="<?php echo $item['id']?>"><?php echo $item['name'] ?></option>
                <?php } ?>
            </select>
            <div class="btn-group right" style="display: inline-block">
                <button type="submit"  class="btn btn-default">查询</button>

            </div>

        </form>
    </div>
    <div class="packageContainer">
        <?php if(is_array($photoPackageList['photographyPackage'])&&count($photoPackageList['photographyPackage'])){
            foreach ($photoPackageList['photographyPackage'] as $index=>$item){
                ?>
                <div class="packageItem" >
                    <div class="packageName"><span>名称：</span><?php echo $item['name'] ?></div>
                    <div><span>地区：</span><?php echo $item['areaName'] ?></div>
                    <div><span>版本：</span><?php echo $item['versionName'] ?></div>
                    <div><span>价格：</span><?php echo $item['price'] ?></div>
                    <div class="form-group">
                        <button class="btn btn-danger">详情</button>
                        <a class="btn btn-info" > 修改</a>
                    </div>
                </div>
            <?php }} ?>

    </div>
    <?php if($message){ ?>
        <div><h3 class="text-center"><?php echo $message ?></h3></div>
    <?php } ?>
    <div class="pageContainer">
        <?php for($i = 0 ; $i < $totalPageCount; $i++) {?>

            <a class="<?php echo $pageIndex==$i?'actived':''  ?>"  href="photoPackage.php?currentPage=<?php echo $i; ?>&key=<?php echo $key; ?>&versionId=<?php echo $versionId ?>"><?php echo $i + 1; ?></a>

        <?php } ?>
    </div>


</div>
<script src="./plugins/layui/layui.js"></script>
<script src="./lib/js/jquery.min.js"></script>
<script>

</script>



</body>
</html>