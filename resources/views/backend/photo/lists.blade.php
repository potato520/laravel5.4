@section('title', '相册管理')

@extends('backend.common.layouts')

@section('content')
    <style>
        .am-active span{padding: 6px 12px!important; border-radius: 4px!important;}
        .am-btn-toolbar a{background: #fff;}
    </style>

    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 相册管理
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
                            <button type="button" class="am-btn am-btn-default am-btn-secondary"><span class="am-icon-save"></span> 保存</button>
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
            <div class="am-g">
                <div class="am-u-sm-12">
                    <form class="am-form">

                                <div class="am-g">
                                    <div class="tpl-table-images">
                                        @foreach($lists as $list)
                                        <div class="am-u-sm-12 am-u-md-6 am-u-lg-4">
                                            <div class="tpl-table-images-content">
                                                <div class="tpl-table-images-content-i-time">发布时间：{{ $list->created_at }}</div>
                                                <div class="tpl-i-title">
                                                    {{ $list->title }}
                                                </div>
                                                <a href="javascript:;" class="tpl-table-images-content-i">
                                                    <div class="tpl-table-images-content-i-info">
                                                        <span class="ico">
                                                <!-- <img src="assets/img/user02.png" alt="">用户名-->
                                             </span>

                                                    </div>
                                                    <span class="tpl-table-images-content-i-shadow"></span>
                                                    <img src="{{ asset('../storage/app/uploads/zhanwei.jpg') }}" data-original="{{ asset('../storage/app/' . $list->thumb) }}" class="lazy"
                                                         width="272" height="158" alt="缩略图">

                                                </a>
                                                <div class="tpl-table-images-content-block">
                                                    <div class="tpl-i-font">
                                                        你最喜欢的艺术作品，告诉大家它们的------名图画，色彩，交织，撞色，线条雕塑装置当代古代现代作品的照片。
                                                    </div>
                                                    <div class="tpl-i-more">
                                                        <ul>
                                                            <li><span class="am-icon-qq am-text-warning"> 100+</span></li>
                                                            <li><span class="am-icon-weixin am-text-success"> 235+</span></li>
                                                            <li><span class="am-icon-github font-green"> 600+</span></li>
                                                        </ul>
                                                    </div>
                                                    <div class="am-btn-toolbar">
                                                        <div class="am-btn-group am-btn-group-xs tpl-edit-content-btn">
                                                            <button type="button" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 新增</button>
                                                            <button type="button" class="am-btn am-btn-default am-btn-secondary"><span class="am-icon-edit"></span> 编辑</button>
                                                            <button type="button" class="am-btn am-btn-default am-btn-warning"><span class="am-icon-archive"></span> 审核</button>
                                                            <button type="button" class="am-btn am-btn-default am-btn-danger"><span class="am-icon-trash-o"></span> 删除</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                        <div class="am-cf">

                            <div class="am-fr">
                                {{--<ul class="am-pagination tpl-pagination">--}}
                                {{--<li class="am-disabled"><a href="#">«</a></li>--}}
                                {{--<li class="am-active"><a href="#">1</a></li>--}}
                                {{--<li><a href="#">2</a></li>--}}
                                {{--<li><a href="#">3</a></li>--}}
                                {{--<li><a href="#">4</a></li>--}}
                                {{--<li><a href="#">5</a></li>--}}
                                {{--<li><a href="#">»</a></li>--}}
                                {{--</ul>--}}
                                {{ $lists->links() }}
                            </div>
                        </div>
                        <hr>

                    </form>
                </div>

            </div>
        </div>
        <div class="tpl-alert"></div>
    </div>
@endsection

@section('my-js')
    <script type="text/javascript">
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