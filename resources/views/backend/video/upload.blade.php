@section('title', '视频上传测试')

@extends('backend.common.layouts')

@section('content')
    <style>
        .am-active span{padding: 6px 12px!important; border-radius: 4px!important;}
        .am-btn-toolbar a{background: #fff;}
        .preview{width:200px;border:solid 1px #dedede; margin:10px;padding:10px;}

    </style>
    <link rel="stylesheet" href="https://www.helloweba.com/demo/2016/dropzone/dropzone.css">

    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 视频上传测试
            </div>
            <div class="tpl-portlet-input tpl-fz-ml">
                <div class="portlet-input input-small input-inline">
                    <!--
                    <div class="input-icon right">
                        <i class="am-icon-search"></i>
                        <input type="text" class="form-control form-control-solid" placeholder="搜索..."> </div>
                        -->
                </div>
            </div>


        </div>
        <div class="tpl-block ">

            <div class="am-g tpl-amazeui-form">


                <div class="am-u-sm-12 am-u-md-9">
                    <form class="am-form am-form-horizontal" id="myForm" method="post" enctype="multipart/form-data" action="{{ url('/Backend/Video/upload') }}">
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">标题</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-name" placeholder="标题" name="title">
                                <small  id="aa"></small>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">文件</label>
                            <div class="am-u-sm-9">
                                <input type="file" id="user-name" placeholder="标题" name="file">
                                <small  id="aa"></small>
                                <small id="output1"></small>
                                <button>上传预览</button>
                            </div>

                        </div>
                        {{csrf_field()}}




                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <button type="button" class="am-btn am-btn-primary" >保存修改</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="tpl-alert"></div>
    </div>

@endsection

@section('my-js')
    <script src="https://www.helloweba.com/demo/ajaxsubmit/jquery.form.min.js" type="text/javascript"></script>
    <script type="text/javascript">

        $(document).ready(function() {
            var options = {
                target:        '#output1',   // 用服务器返回的数据 更新 id为output1的内容.
                beforeSubmit:  showRequest,  // 提交前
                success:       showResponse,  // 提交后
                //另外的一些属性:
                //url:       url         // 默认是form的action，如果写的话，会覆盖from的action.
                //type:      type        // 默认是form的method，如果写的话，会覆盖from的method.('get' or 'post').
                dataType:  'json',        // 'xml', 'script', or 'json' (接受服务端返回的类型.)
                //clearForm: true        // 成功提交后，清除所有的表单元素的值.
                resetForm: false,        // 成功提交后，重置所有的表单元素的值.
                //由于某种原因,提交陷入无限等待之中,timeout参数就是用来限制请求的时间,
                //当请求大于3秒后，跳出请求.
                //timeout:   3000
                error:function (xhr, status, error){ // 获取laravleValidate严重返回的错误展示
                    var json=JSON.parse(xhr.responseText);
                    if(json.title){
                        var er = json.title;
                        $('#aa').html(""+json.title+"");
                    }else{
                        $('#aa').html("");
                    }
                }
            };

            //'ajaxForm' 方式的表单 .
            //$('#myForm').ajaxForm(options);
            //或者 'ajaxSubmit' 方式的提交.
            $('#myForm').submit(function() {
                $(this).ajaxSubmit(options);
                return false; //来阻止浏览器提交.
            });
        });

        // 提交前
        function showRequest(formData, jqForm, options) {
            // formdata是数组对象,在这里，我们使用$.param()方法把他转化为字符串.
            var queryString = $.param(formData); //组装数据，插件会自动提交数据
            // alert(queryString); //组合传送数据类似 ： name=1&add=2
            return true;
        }

        //  提交后 (返回内容，返回状态)
        function showResponse(responseText, statusText)  {
            if(responseText.status == 1){
                layer.msg(responseText.message, {time: 3000, icon:0});
            }else{
               $('#output1').html(responseText.message);
            }
        }




        function ityzl_SHOW_LOAD_LAYER(){
            return index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
        }
        function ityzl_CLOSE_LOAD_LAYER(index){
            layer.close(index);
        }
        function upload()
        {
            $.ajax({
                type: "POST",
                url: '{{ url('/Backend/Video/upload') }}',
                headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                dataType: 'json',
                cache: false,
                data: $("#myForm").serialize(),
                beforeSend: function () {
                    i =ityzl_SHOW_LOAD_LAYER();
                },
                complete: function () {
                    ityzl_CLOSE_LOAD_LAYER(i);
                },
                success: function(data) {
                    if(data == null) {
                        layer.msg('服务端错误', {time: 3000, icon:0});
                        return;
                    }
                    if(data.status != 0) {
                        layer.msg(data.message, {time: 3000, icon:0});
                        return;
                    }else{
                        layer.msg(data.message, {time: 2000, icon:1},function(){
                            parent.layer.closeAll();
                            // window.location.reload();
                            window.location.href = "{{ url('/Backend/Video')}}";
                        });
                    }
                },
                error: function(xhr, status, error) {
                    var json=JSON.parse(xhr.responseText);
                    if(json.title){
                        var er = json.title;
                        $('#aa').html(""+json.title+"");
                    }else{
                        $('#aa').html("");
                    }
                    if(json.content){
                        var er = json.content;
                        $('#content').html(""+json.content+"");
                    }else{
                        $('#content').html("");
                    }
                    if(json.description){
                        var er = json.description;
                        $('#description').html(""+json.description+"");
                    }else{
                        $('#description').html("");
                    }
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        }

        // 分页样式
        $('.am-fr .active').attr('class', 'am-active');
        $('.am-fr ul').attr('class', 'am-pagination tpl-pagination');
        $('.am-fr .active span').css('padding', '1px');

        // 搜索
        function search1(){
            $('#myform').submit();
        }


    </script>
@endsection