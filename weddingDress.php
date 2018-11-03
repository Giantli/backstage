<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="./plugins/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="./css/weddingDress.css">
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./lib/css/bootstrap.min.css">
    <link rel="stylesheet" href="./lib/css/fontello.css">
    <link rel="stylesheet" href="css/page.css">

    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<?php
    require("./services/weddingDressService.php");
    $message="";
    $pendulumList=getPendulums();
    $styleList=getStyles();
    $styleId="";
    $pendulumId="";
    $key="";

    $pageIndex=0;
    $pageSize=12;
    $totalPageCount=0;

    $weddingDressList=[];
    if(array_key_exists('styleId',$_REQUEST)){
        $styleId=$_REQUEST['styleId'];
    }
    if(array_key_exists('pendulumId',$_REQUEST)){
        $pendulumId=$_REQUEST['pendulumId'];
    }
    if(array_key_exists("currentPage" , $_REQUEST)){
        $pageIndex = intval($_REQUEST["currentPage"]);
    }
    if(array_key_exists('key',$_REQUEST)){
        $key=$_REQUEST['key'];
    }
    $weddingDressList=getWeddingDresses($pendulumId,$styleId,$key,$pageIndex*$pageSize,$pageSize);

    if(count($weddingDressList['weddingDresses'])>0&&!is_null($weddingDressList)){

    }

    elseif(is_null($weddingDressList)){
        $message='查询失败';
    }
    else{
        $message='暂无数据';
    }

    $totalPageCount= ceil($weddingDressList['totalRows']/$pageSize);

?>
<body>
<div class="middle">
    <div class="header"><h2>婚纱管理</h2></div>
    <a class="addButton" href="addWeddingDress.php"><i class="icon-plus"></i>添加婚纱</a>
    <div class="bookSearch">
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <select class="form-control" style="width:28%; display:inline-block;" name="pendulumId">
                <option value="" name="category" >全部摆型</option>
                <?php if(is_array($pendulumList)){
                    foreach ($pendulumList as $item){
                        ?>
                        <option <?php echo $item['id']==$pendulumId?'selected':'' ?> value="<?= $item['id'] ?>" ><?= $item['name'] ?></option>

                    <?php }} ?>

            </select>

            <select class="form-control" style="width:28%; display:inline-block;" name="styleId">
                <option value="">全部款式</option>
                <?php if(is_array($styleList)){
                    foreach ($styleList as $item){
                        ?>
                        <option <?php echo $item['id']==$styleId?'selected':'' ?>  value="<?= $item['id'] ?>"><?= $item['name'] ?></option>

                    <?php }} ?>
            </select>
            <input class="form-control" style="width:34%; display:inline-block;" name="key" value="<?php echo $key ?>" placeholder="婚纱名" />
            <div class="btn-group right" style="display: inline-block">
                <button type="submit"  class="btn btn-default">查询</button>

            </div>
        </form>
        </div>

        <div id="dressContainer">
            <?php if(is_array($weddingDressList['weddingDresses'])&&count($weddingDressList['weddingDresses'])>0){
                foreach ($weddingDressList['weddingDresses'] as $index=>$item){
                    ?>
                    <div class="dressItem" >
                        <div  class="dressDetail">
                            <div><span>摆型:</span><?php echo $item['pendulumName']?> </div>
                            <div><span>款式:</span><?php echo $item['styleName']?></div>
                            <div><span>价格：</span><?php echo $item['price'] ?></div>
                            <div class="btn-group">
                                <a class="btn btn-default" href="editDress.php?id=<?php echo $item['id']?>">修改</a>
                            </div>
                        </div>
                        <div>
                            <img src="./images/<?php echo $item['images'][0] ?>" alt="">
                            <div class="text-center"><h4><?php echo $item['name'] ?></h4></div>

                        </div>
                    </div>
                <?php }} ?>

        </div>
        <?php if($message){ ?>
            <div><h3 class="text-center"><?php echo $message ?></h3></div>
        <?php } ?>
        <div class="pageContainer">
            <?php for($i = 0 ; $i < $totalPageCount; $i++) {?>

                <a class="<?php echo $pageIndex==$i?'actived':''  ?>"  href="weddingDress.php?currentPage=<?php echo $i; ?>&key=<?php echo $key; ?>&pendulumId=<?php echo $pendulumId  ?>&styleId=<?php echo $styleId ?>"><?php echo $i + 1; ?></a>

            <?php } ?>
        </div>

    </div>


</div>
    <script src="./plugins/layui/layui.js"></script>
    <script src="./lib/js/jquery.min.js"></script>
    <script>

    </script>



</body>
</html>