<ul class="tpl-left-nav-menu">
    <li class="tpl-left-nav-item">
        <a href="{{ url('/Backend/Home') }}" class="nav-link {{ Request::getPathInfo() == '/Backend/Home' ? 'active' : '' }}">
            <i class="am-icon-home"></i>
            <span>控制台</span>
        </a>
    </li>
    <li class="tpl-left-nav-item">
        <a href="{{ url('/Backend/Member') }}" class="nav-link  {{ Request::getPathInfo() == '/Backend/Member' ? 'active' : '' }}">
            <i class="am-icon-user-secret"></i>
            <span>用户管理</span>
            <i class="tpl-left-nav-content tpl-badge-danger">30</i>
        </a>
    </li>

    <li class="tpl-left-nav-item">
        <a href="{{ url('/Backend/Video') }}" class="nav-link
        {{ Request::getPathInfo() == '/Backend/Video' ? 'active' : '' }}
        {{ Request::getPathInfo() == '/Backend/Video/modVideo' ? 'active' : '' }}
        {{ Request::getPathInfo() == '/Backend/Video/upload2' ? 'active' : '' }}">
            <i class="am-icon-film"></i>
            <span>视频管理</span>
        </a>
    </li>

    <li class="tpl-left-nav-item">
        <a href="{{ url('/Backend/Caiji') }}" class="nav-link
        {{ Request::getPathInfo() == '/Backend/Caiji' ? 'active' : '' }}
        ">
            <i class="am-icon-file-powerpoint-o "></i>
            <span>采集内容</span>
        </a>
    </li>

    <li class="tpl-left-nav-item">
        <a href="{{ url('/Backend/Photo') }}" class="nav-link
        {{ Request::getPathInfo() == '/Backend/Photo' ? 'active' : '' }}
                ">
            <i class="am-icon-file-image-o"></i>
            <span>相册管理</span>
            <i class="tpl-left-nav-content tpl-badge-primary">20</i>
        </a>
    </li>

    <li class="tpl-left-nav-item">
        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
            <i class="am-icon-table"></i>
            <span>表格</span>
            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right"></i>
        </a>
        <ul class="tpl-left-nav-sub-menu">
            <li>
                <a href="table-font-list.html">
                    <i class="am-icon-angle-right"></i>
                    <span>文字表格</span>
                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                </a>

                <a href="table-images-list.html">
                    <i class="am-icon-angle-right"></i>
                    <span>图片表格</span>
                    <i class="tpl-left-nav-content tpl-badge-success">
                        18
                    </i>

                    <a href="form-news.html">
                        <i class="am-icon-angle-right"></i>
                        <span>消息列表</span>
                        <i class="tpl-left-nav-content tpl-badge-primary">
                            5
                        </i>


                        <a href="form-news-list.html">
                            <i class="am-icon-angle-right"></i>
                            <span>文字列表</span>

                        </a>
            </li>
        </ul>
    </li>

    <li class="tpl-left-nav-item">
        <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
            <i class="am-icon-wpforms"></i>
            <span>表单</span>
            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right tpl-left-nav-more-ico-rotate"></i>
        </a>
        <ul class="tpl-left-nav-sub-menu" style="display: block;">
            <li>
                <a href="form-amazeui.html">
                    <i class="am-icon-angle-right"></i>
                    <span>Amaze UI 表单</span>
                    <i class="am-icon-star tpl-left-nav-content-ico am-fr am-margin-right"></i>
                </a>

                <a href="form-line.html">
                    <i class="am-icon-angle-right"></i>
                    <span>线条表单</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="tpl-left-nav-item">
        <a href="login.html" class="nav-link tpl-left-nav-link-list">
            <i class="am-icon-key"></i>
            <span>登录</span>

        </a>
    </li>
</ul>