@section('title', '视频上传测试')

@extends('backend.common.layouts')

@section('content')
    <style>
        .progress { position:relative; margin-left:100px; margin-top:-24px; width:200px;padding: 1px; border-radius:3px; display:none}
        .bar {background-color: green; display:block; width:0%; height:23px; border-radius: 3px; }
        .percent { position:absolute; height:20px; display:inline-block; top:3px; left:2%; color:#fff }
        .files{height:22px; line-height:22px; margin:10px 0}
        .delimg{margin-left:20px; color:#090; cursor:pointer}
        #showimg img{width: 100px;  height: 100px;;}

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
                                {{--<span>添加附件</span>--}}
                                <label for="user-name" class="am-u-sm-3 am-form-label">添加附件</label>
                            <div class="am-u-sm-9">


                            <input id="fileupload" type="file" name="file" style="width: 90px;">
                            <div class="progress">
                                <span class="bar"></span><span class="percent">0%</span >
                            </div>
                            <div class="files"></div>
                            <div id="showimg"></div>
                            </div>
                        </div>
                        {{csrf_field()}}

                        <div class="am-form-group">
                            <label for="user-intro" class="am-u-sm-3 am-form-label" >视频地址</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="user-name" placeholder="输入完整的url地址" name="content">
                                <small id="content"></small>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-intro" class="am-u-sm-3 am-form-label">简介</label>
                            <div class="am-u-sm-9">
                                <textarea class="" rows="5" id="user-intro" placeholder="250字以内写出你的一生..."  name="description"></textarea>
                                <small id="description"></small>
                            </div>
                        </div>

                        <input type="hidden" name="pic" id="pic">

                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <button type="button" class="am-btn am-btn-primary" onclick="upload();">保存修改</button>
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
        $(function () {
            var bar = $('.bar');
            var percent = $('.percent');
            var showimg = $('#showimg');
            var progress = $(".progress");
            var files = $(".files");
            var btn = $(".btn span");
            $("#fileupload").wrap("<form id='myupload' action='{{ url('/Backend/Video/upload2') }}' method='post' enctype='multipart/form-data'></form>");
            $("#fileupload").change(function(){
                $("#myupload").ajaxSubmit({
                    dataType:  'json',
                    headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                    beforeSend: function() {
                        showimg.empty();
                        progress.show();
                        var percentVal = '0%';
                        bar.width(percentVal);
                        percent.html(percentVal);
                        btn.html("上传中...");
                    },
                    uploadProgress: function(event, position, total, percentComplete) {
                        var percentVal = percentComplete + '%';
                        bar.width(percentVal);
                        percent.html(percentVal);
                    },
                    success: function(data) {
                        if(data.status == 0) {
                            files.html("<b>" + data.name + "</b> <span class='delimg' rel='" + data.name + "'>删除</span>");
                            var img = data.message;
                            showimg.html("<img src='" + img + "'>");
                            btn.html("添加附件");
                            $('#pic').val(data.name);
                        }
                        return false;

                    },
                    error:function(xhr){
                        btn.html("上传失败");
                        bar.width('0')
                        files.html(xhr.responseText);
                    }
                });
            });

            // 删除图片的动作
            $(".delimg").live('click',function(){
                var pic = $(this).attr("rel");
                delimg(pic);
            });
        });

        function delimg(pic)
        {
            $.ajax({
                type: "POST",
                url: '{{ url('/Backend/Video/delimg') }}',
                headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                dataType: 'json',
                cache: false,
                data: {'pic':pic},
                beforeSend: function () {
                    i =ityzl_SHOW_LOAD_LAYER();
                },
                complete: function () {
                    ityzl_CLOSE_LOAD_LAYER(i);
                },
                success: function(data) {
                    if(data == null) {
                        layer.msg('服务端错误', {time: 1000, icon:0});
                        return;
                    }
                    if(data.status != 0) {
                        layer.msg(data.message, {time: 1000, icon:0});
                        return;
                    }else{
                        layer.msg(data.message, {time: 1000, icon:1},function(){
                            $('.progress').hide();
                            $('.files').empty();
                            $('#showimg').empty();
                            $('#pic').attr('value','');
                        });
                    }
                }
            });
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
                url: '{{ url('/Backend/Video/addVideo') }}',
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