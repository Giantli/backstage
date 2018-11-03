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
    <link rel="stylesheet" href="./lib/css/fontello.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./lib/css/bootstrap.min.css">

    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<?php
    require_once("./services/photographyService.php");
    $message="";
    $areas=getAreas();
    $versions=getVersions();


?>
<body>
<div class="middle">
    <div class="header"><h2>添加套餐</h2></div>
    <div class="addDressContainer">
        <form class="form-horizontal layui-form" method="post">


            <div class="form-group has-feedback">
                <label class="control-label col-lg-2">地区：</label>
                <div class="col-lg-8">
                    <select class="form-control" name="pendulumId">
                        <?php if(is_array($areas)){
                            foreach ($areas as $item){
                                ?>
                                <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>

                            <?php }} ?>
                    </select>
                </div>
            </div>
            <div class="form-group has-feedback">
                <label class="control-label col-lg-2">版本：</label>
                <div class="col-lg-8">
                    <select class="form-control" name="styleId">
                        <?php if(is_array($versions)){
                            foreach ($versions as $item){
                                ?>
                                <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>

                            <?php }} ?>
                    </select>
                </div>
            </div>
            <div class="form-group has-feedback">
                <label class="control-label col-lg-2">价格：</label>
                <div class="col-lg-8"><input type="text" name="price" class="form-control" lay-verify="price" autocomplete="off" placeholder="请输入价格"  ></div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-2">图片：</label>
                <div class="col-lg-10 "><label class="uploadHeader" for="uploadHeader">上传图片</label> <input type="file" style="display: none"  id="uploadHeader"/>
                    <div  class="col-lg-12  imageContainer"><img src="" id="cover" width="70"/><input type="hidden" name="image" ></div>
                </div>



                <div class="form-group" style="margin-top:120px;">
                    <button class="layui-btn col-lg-offset-2" lay-submit="" lay-filter="demo1">立即提交</button>
                    <button type="button" class="layui-btn" onclick="javascript:location.href='photoPackage.php';">返回</button>

                </div>


        </form>
    </div>
</div>


<script src="./plugins/layui/layui.js"></script>
<script src="./lib/js/jquery.min.js"></script>


<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    $(function() {
        var container = $('.imageContainer')[0];
        document.querySelector('#uploadHeader').onchange = function () {
            if(this.files.length>0){
                var file=this.files[0];

                var formData=new FormData();
                formData.append('img',file);
                var xhr = new XMLHttpRequest();
                xhr.open('POST' , "upload.php" , true);
                xhr.onreadystatechange = function(e){
                    if(this.readyState == 4 && this.status == 200){
                        var result = JSON.parse(this.responseText);
                        if(result.code == 100){
                            var fr = new FileReader();
                            fr.onload = function (e) {
                                document.querySelector('#cover').src = this.result;
                            };
                            fr.readAsDataURL(file);
                            $('input[type=hidden]').val(result.data);

                        }
                    }
                };

                xhr.send(formData);
            }
        }
    });



</script>
<script>
    layui.use(['form', 'layedit', 'laydate'], function() {
        var form = layui.form,
            layer = layui.layer,
            layedit = layui.layedit,
            laydate = layui.laydate;

        //日期
        laydate.render({
            elem: '#date'
        });
        laydate.render({
            elem: '#date1'
        });

        //创建一个编辑器
        var editIndex = layedit.build('LAY_demo_editor');

        //自定义验证规则
        form.verify({
            title: function(value) {
                if (value.length < 5) {
                    return '标题至少得5个字符啊';
                }
            },
            pass: [/(.+){6,12}$/, '密码必须6到12位'],
            price:[/(\d){1,}$/,'价格必须为数字'],
            content: function(value) {
                layedit.sync(editIndex);
            }
        });

        //监听指定开关
        form.on('switch(switchTest)', function(data) {
            layer.msg('开关checked：' + (this.checked ? 'true' : 'false'), {
                offset: '6px'
            });
            layer.tips('温馨提示：请注意开关状态的文字可以随意定义，而不仅仅是ON|OFF', data.othis)
        });

        //监听提交
        form.on('submit(demo1)', function(data) {
            console.log(data);

//            $.ajax({
//                type:'POST',
//                url:'',
//                data:{},
//                success:function(response){
//
//                },
//                dataType:'json'
//
//            });
        });


    });
</script>





</body>

</html>