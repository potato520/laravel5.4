@section('title', '采集列表')

@extends('backend.common.layouts')

@section('content')
<style>
    .am-active span{padding: 6px 12px!important; border-radius: 4px!important;}
    .am-btn-toolbar a{background: #fff;}
</style>

<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> 采集内容
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
    <div class="tpl-block">
        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <button type="button" class="am-btn am-btn-default am-btn-success" onclick="addUser();"><span class="am-icon-plus"></span> 新增</button>
                        <button type="button" class="am-btn am-btn-default am-btn-secondary" onclick="showList();"><span class="am-icon-save"></span> 视频列表</button>
                        <button type="button" class="am-btn am-btn-default am-btn-warning"><span class="am-icon-archive"></span> 审核</button>
                        <button type="button" class="am-btn am-btn-default am-btn-danger"><span class="am-icon-trash-o"></span> 删除</button>
                    </div>
                </div>
            </div>
            <div class="am-u-sm-12 am-u-md-3">
                <div class="am-form-group">
                    <select data-am-selected="{btnSize: 'sm'}">
                        <option value="option1">所有类别</option>
                        <option value="option2">IT业界</option>
                        <option value="option3">数码产品</option>
                        <option value="option3">笔记本电脑</option>
                        <option value="option3">平板电脑</option>
                        <option value="option3">只能手机</option>
                        <option value="option3">超极本</option>
                    </select>
                </div>
            </div>
            <div class="am-u-sm-12 am-u-md-3">
                <div class="am-input-group am-input-group-sm">
                    <form action="{{ url('/Backend/Member') }}" method="GET" id="myform">
                        <input type="text" class="am-form-field" value="" name="search" style="width: 180px;">
                                <span class="am-input-group-btn">
            <button onclick="search1();" class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search" type="button"></button>
          </span>
                    </form>
                </div>
            </div>
        </div>

        <!--采集以后跳转提示信息-->
        @if(Session::has('message'))
        <div class="am-btn am-btn-default am-btn-success"><i class="am-icon-bell-o"></i>
            {{Session::get('message')}} </div>
        @endif
        <div class="am-g">
            <div class="am-u-sm-12">
                <div class="am-g">
                        @foreach($mov as $info)
                            <li style="float:left; width: 70px; margin: 5px; " class="am-btn am-btn-default am-btn-secondary">
                            <a href="{{ $info['url'] }}" style="color: #fff;">{{ $info['title'] }}</a>
                            </li>
                        @endforeach
                </div>
            </div>

        </div>
    </div>
    <div class="tpl-alert"></div>
</div>
@endsection

@section('my-js')
<script type="text/javascript">
    function caiji(url)
    {
        var url = $('.url1').val();
        $.ajax({
            type: "GET",
            url: '{{ url('/Backend/Caiji/begin') }}',
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
            dataType: 'json',
            cache: false,
            data: {'url': url},
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
                        parent.layer.closeAll();
                        window.location.reload();
                    });

                }

            },
            error: function(xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });
    }

    function showList()
    {
        window.location.href = "{{ url('/Backend/Caiji/caijiLists') }}";
    }

    function addUser()
    {
        window.location.href = "{{ url('/Backend/Video/upload2') }}";
    }

    function modVideo(id)
    {
        window.location.href = "{{ url('/Backend/Video/modVideo') }}/" + id;
    }

    function modUser(id)
    {
        layer.open({
            title: '编辑用户',
            type: 2,
            shade:0.1,
            area: ['650px', '450px'],
            fixed: false, //不固定
            maxmin: true,
            content: '{{ url('/Backend/Member/modUser') }}/' + id
        });
    }

    function delUser(id)
    {
        layer.confirm('确定删除吗', {
            btn: ['确定','取消'] //按钮
        }, function(){
            function ityzl_SHOW_LOAD_LAYER(){
                return index = layer.load(1, {
                    shade: [0.1,'#fff'] //0.1透明度的白色背景
                });
            }
            function ityzl_CLOSE_LOAD_LAYER(index){
                layer.close(index);
            }
            $.ajax({
                type: "GET",
                url: '{{ url('/Backend/Video/delVideo') }}/' + id,
                headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                dataType: 'json',
                cache: false,
                // data: $("#myForm").serialize(),
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
                            parent.layer.closeAll();
                            window.location.reload();
                        });

                    }

                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });

        }, function(){
            layer.closeAll();
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