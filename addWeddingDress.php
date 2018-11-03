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
    require("./services/weddingDressService.php");
    $message="";
    $pendulumList=getPendulums();
    $styleList=getStyles();


?>
<body>
<div class="middle">
    <div class="header"><h2>添加婚纱</h2></div>
    <div class="addDressContainer">
        <form class="form-horizontal layui-form" method="post">
            <div class="form-group has-feedback">
                <label class="control-label col-lg-2">名称：</label>
                <div class="col-lg-8"><input type="text" class="form-control layui-input" name="name" lay-verify="name" autocomplete="off" placeholder="请输入婚纱名"  ></div>
            </div>
            <div class="form-group has-feedback">
                <label class="control-label col-lg-2">价格：</label>
                <div class="col-lg-8"><input type="text" name="price" class="form-control" lay-verify="price" autocomplete="off" placeholder="请输入价格"  ></div>
            </div>
            <div class="form-group has-feedback">
                <label class="control-label col-lg-2">摆型：</label>
                <div class="col-lg-8">
                    <select class="form-control" name="pendulumId">
                        <?php if(is_array($pendulumList)){
                            foreach ($pendulumList as $item){
                                ?>
                                <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>

                            <?php }} ?>
                    </select>
                </div>
            </div>
            <div class="form-group has-feedback">
                <label class="control-label col-lg-2">款式：</label>
                <div class="col-lg-8">
                    <select class="form-control" name="styleId">
                        <?php if(is_array($styleList)){
                            foreach ($styleList as $item){
                                ?>
                                <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>

                            <?php }} ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-2">图片：</label>
                <div class="col-lg-10 "><label class="uploadHeader" for="uploadHeader">上传图片</label> <input type="file" style="display: none"  id="uploadHeader"/>
                <div  class="col-lg-12  imageContainer"></div>
            </div>



            <div class="form-group" style="margin-top:120px;">
                <button class="layui-btn col-lg-offset-2" lay-submit="" lay-filter="demo1">立即提交</button>
                <button type="button" class="layui-btn" onclick="javascript:location.href='weddingDress.php';">返回</button>

            </div>


        </form>
    </div>
    <div class="show-dialog"></div>
</div>



<script src="./plugins/layui/layui.js"></script>
<script src="./lib/js/jquery.min.js"></script>


<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    $(function(){
        var container=$('.imageContainer')[0];
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
                            var item = createItem(result.data);
                            container.appendChild(item);
                        }
                    }
                };

                xhr.send(formData);
            }
        };
    });
    function createItem(imageUrl){
        var wrapper=document.createElement('div');
        wrapper.style.display='inline-block';
        wrapper.style.position='relative';
        wrapper.style.width='70px';
        wrapper.style.marginRight='2px';
        var img = document.createElement("img");
        img.src = "images/" + imageUrl;
        img.width = 70;
        img.style.display='block';
        var imgName = document.createElement("input");
        imgName.type = "hidden";
        imgName.value = imageUrl;
        imgName.name = "image";
        var cancelButton=document.createElement('i');
        cancelButton.className='icon-cancel';
        cancelButton.style.position='absolute';
        cancelButton.style.top='-1px';
        cancelButton.style.right='0';
        cancelButton.style.cursor='pointer';
        cancelButton.onclick=function(e) {
            this.parentNode.parentNode.removeChild(this.parentNode);
        };
        wrapper.appendChild(img);
        wrapper.appendChild(imgName);
        wrapper.appendChild(cancelButton);

        return wrapper;
    }

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
            name:[/(\w){2,}$/,'婚纱名必须为两个字以上'],
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
            var images=document.querySelectorAll('input[name=image]');
            var imageName="";
            var arr=[];
            for(var i=0;i<images.length;i++){
                arr.push(images[i].value);
            }
            imageName=arr.join(',');
            data.field.image=imageName;
            var $showDialog=$('.show-dialog');
            $.ajax({
                type:'POST',
                url:'./api/weddingDressAjax.php?method=add',
                data:{name:data.field.name,price:data.field.price,pendulum:data.field.pendulumId,style:data.field.styleId,image:data.field.image},
                success:function(response){
                    if(response.code==100){
                        $showDialog.css('display','block');
                        $showDialog.text('添加成功');
                        window.setTimeout(function(){
                            window.location.href='weddingDress.php';
                        },1500);
                    }
                    else{
                        $showDialog.css('display','block');
                        $showDialog.text(response.message);
                    }
                },
                dataType:'json'

            });
            return false;
        });


    });
</script>





</body>

</html>