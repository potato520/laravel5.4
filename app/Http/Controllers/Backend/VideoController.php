<?php
/**
 * Created by PhpStorm.
 * User: 月下追魂
 * Date: 2017/7/25
 * Time: 16:54
 */
namespace app\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Request;
use App\Models\M3Result;
use phpQuery;
use QL\QueryList;

class VideoController extends Controller
{
    public $m3_result;

    public function __construct()
    {
        $this->m3_result = new M3Result();
    }

    // 视频列表
    public function lists()
    {
        $lists = Video::where('id','>','0')->orderBy('id', 'DESC')->paginate($perPage = 8, $columns = ['*'], $pageName = 'page', $page = null);
        return view('backend/video/lists', compact('lists', $lists));
    }

    // 添加视频
    public function addVideo(Request $request)
    {
        if($request->isMethod('post')){
                $video = new Video();

                $this->validate($request, [
                    'title' => 'required|min:2|max:50',
                    'content' => 'required',
                    'description' => 'required',
                ], [
                    'required' => ':attribute 为必填项',
                    'min' => ':attribute 最小长度为2个字符',
                    'integer' => ':attribute 必须为整数',
                    'max' => ':attribute 姓名长度不超过50个字符'
                ],[
                    'title' =>'标题',
                    'content' =>'视频地址',
                    'description' =>'简介',
                ]);
            $video->title = $request->input('title');
            $video->content = $request->input('content');
            $video->description = $request->input('description');
            $video->thumb = 'uploads/' . $request->input('pic', '');

            if($video->save()){
                echo json_encode(array('status'=>0, 'message' => '添加成功'));exit();
            }else{
                echo json_encode(array('status'=>1, 'message' => '添加失败，请重试'));exit();
            }
        }else{
            return view('backend/video/addVideo');
        }
    }


    // 上传图片
    public function upload(Request $request)
    {
        if($request->isMethod('post')) {
            $this->validate($request, [
                'title' => 'required|min:2|max:50',
            ], [
                'required' => ':attribute 为必填项',
                'min' => ':attribute 最小长度为2个字符',
                'integer' => ':attribute 必须为整数',
                'max' => ':attribute 姓名长度不超过50个字符'
            ],[
                'title' =>'标题',
            ]);

            /* 文件上传 */
            $file = $request->file('file');
            if (!$request->hasFile('file')) {
//                echo '上传文件空';exit();
                echo json_encode(array('status'=>1, 'message' => '上传文件为空'));exit();
            }

            if (!$file->isValid()) {
                echo json_encode(array('status'=>1, 'message' => '文件上传出错'));exit();
            } else {
                // 获取文件名称
                $clientName = $file->getClientOriginalName();

                $newFileName = md5(time() . rand(0, 10000)) . '.' . $file->getClientOriginalExtension();
                $savePath = 'uploads/' . $newFileName;
                $bytes = Storage::put(
                    $savePath,
                    file_get_contents($file->getRealPath())
                );
                if (!Storage::exists($savePath)) {
                    echo json_encode(array('status'=>1, 'message' => '保存文件失败'));exit();
                }
                 //echo '<img src="'.'http://localhost/laravel5/storage/app/'.$savePath.'"  class="preview">'; exit();
                echo json_encode(array('status'=>0,'message' => '<img src="'.'http://localhost/laravel5/storage/app/'.$savePath.'"  class="preview">'));exit();

                #echo 'http://localhost/laravel5/storage/app/'.$savePath; exit();

                # 以下两行是用来预览图片的[ 只有在刷新后的新页面才能显示 ]
                # header("Content-Type: ".Storage::mimeType($savePath));
                # echo Storage::get($savePath);
                /* 文件上传 */
            }
        }
        return view('backend/video/upload');

    }

    // ajax 异步上传图片
    public function upload2(Request $request)
    {
        if($request->isMethod('post')) {

            /* 文件上传 */
            $file = $request->file('file');
            if (!$request->hasFile('file')) {
//                echo '上传文件空';exit();
                echo json_encode(array('status'=>1, 'message' => '上传文件为空'));exit();
            }

            if (!$file->isValid()) {
                echo json_encode(array('status'=>1, 'message' => '文件上传出错'));exit();
            } else {
                // 获取文件名称
                $clientName = $file->getClientOriginalName();

                $newFileName = md5(time() . rand(0, 10000)) . '.' . $file->getClientOriginalExtension();
                $savePath = 'uploads/' . $newFileName;
                $bytes = Storage::put(
                    $savePath,
                    file_get_contents($file->getRealPath())
                );
                if (!Storage::exists($savePath)) {
                    echo json_encode(array('status'=>1, 'message' => '保存文件失败'));exit();
                }
                //echo '<img src="'.'http://localhost/laravel5/storage/app/'.$savePath.'"  class="preview">'; exit();
                //echo json_encode(array('status'=>0,'message' => '<img src="'.'http://localhost/laravel5/storage/app/'.$savePath.'"  class="preview">'));exit();

                echo json_encode(array('status'=>0, 'name'=>$newFileName, 'message' => 'http://localhost/laravel5/storage/app/'.$savePath));exit();


                # 以下两行是用来预览图片的[ 只有在刷新后的新页面才能显示 ]
                # header("Content-Type: ".Storage::mimeType($savePath));
                # echo Storage::get($savePath);
                /* 文件上传 */
            }
        }
        return view('backend/video/upload2');
    }

    //删除远程图片
    public function delimg(Request $request)
    {
        if($request->isMethod('post')){
            $pic = $request->input('pic');
            $file = public_path() . '/../storage/app/uploads/'.$pic;
            if(@unlink($file)){
                echo json_encode(array('status'=>0, 'message' => '删除成功'));exit();
            }else{
                echo json_encode(array('status'=>1, 'message' => '删除失败'));exit();
            }
        }
        return null;

    }

    // 编辑视频
    public function modVideo(Request $request, $id)
    {
        if($request->isMethod('get')){
            $find = Video::find($id)->toArray();
            return view('backend/video/modVideo', compact('find', $find));
        }

    }

    public function modVideo2(Request $request)
    {
        if($request->isMethod('post')){
            $id = $request->input('id');
            $video = Video::find($id);

            $this->validate($request, [
                'title' => 'required|min:2|max:10',
                'content' => 'required',
                'description' => 'required',
            ], [
                'required' => ':attribute 为必填项',
                'min' => ':attribute 最小长度为2个字符',
                'integer' => ':attribute 必须为整数',
                'max' => ':attribute 姓名长度不超过10个字符'
            ],[
                'title' =>'标题',
                'content' =>'视频地址',
                'description' =>'简介',
            ]);
            $video->title = $request->input('title');
            $video->content = $request->input('content');
            $video->description = $request->input('description');
            $video->thumb = 'uploads/' . $request->input('pic', '');

            if($video->save()){
                echo json_encode(array('status'=>0, 'message' => '编辑成功'));exit();
            }else{
                echo json_encode(array('status'=>1, 'message' => '编辑失败，请重试'));exit();
            }

        }
    }

    // 删除视频
    public function delVideo(Request $request, $id)
    {
        if($request->isMethod('get')){
            $find = Video::find($id);
            if($find){
                if($find->delete()){
                    $this->m3_result->status = 0;
                    $this->m3_result->message = '删除成功';
                    return $this->m3_result->toJson();
                }else{
                    $this->m3_result->status = 1;
                    $this->m3_result->message = '删除失败';
                    return $this->m3_result->toJson();
                }
            }else{
                $this->m3_result->status = 1;
                $this->m3_result->message = '未找到数据';
                return $this->m3_result->toJson();
            }
        }
    }










    // 采集
    public function caiji()
    {
        phpQuery::newDocumentFile('http://www.helloweba.com/blog.html');
        $artlist = pq(".blog_li");
        foreach($artlist as $li){
            echo pq($li)->find('h2')->html()."<br>";
        }
    }

    // 采集文章列表
    public function caiji2()
    {
        //采集某页面所有的图片
        $data = QueryList::Query('http://www.qushiw.com/jingcaisaishi',array(
            //采集规则库
            //'规则名' => array('jQuery选择器','要采集的属性'),
            'image' => array('.piclist li a img','src'),
            'title' => array('.piclist li a p', 'text'),
            'href' => array('.piclist li a', 'href')
        ),'','UTF-8','GB2312')->data;
//打印结果
        p($data);

    }

    // 采集文章终极页内容
    public function caiji3()
    {
        //需要采集的目标页面
        $html = 'http://www.jeeok.com/jquery_tupian/4615.html';
        $data = QueryList::Query($html,array(
            //采集规则库
            //'规则名' => array('jQuery选择器','要采集的属性'),
            'title' => array('.overflowH .font_s18','text'),
            'images' => array('#viewpic', 'src'),
            'content' => array('.w857 .margin_t15', 'text')
        ),'')->data;
//打印结果
        p($data);

    }

    public function caiji4(Request $request)
    {
        //需要采集的目标页面
        $page = 'http://cms.querylist.cc/news/566.html';
//采集规则
        $reg = array(
            //采集文章标题
            'title' => array('h1','text'),
            //采集文章发布日期,这里用到了QueryList的过滤功能，过滤掉span标签和a标签
            'date' => array('.pt_info','text','-span -a',function($content){
                //用回调函数进一步过滤出日期
                $arr = explode(' ',$content);
                return $arr[0];
            }),
            //采集文章正文内容,利用过滤功能去掉文章中的超链接，但保留超链接的文字，并去掉版权、JS代码等无用信息
            'content' => array('.post_content','html','a -.content_copyright -script',function($content){
                //利用回调函数下载文章中的图片并替换图片路径为本地路径
                //使用本例请确保当前目录下有image文件夹，并有写入权限
                //由于QueryList是基于phpQuery的，所以可以随时随地使用phpQuery，当然在这里也可以使用正则或者其它方式达到同样的目的
                $doc = phpQuery::newDocumentHTML($content);
                $imgs = pq($doc)->find('img');
                foreach ($imgs as $img) {
                    $src = 'http://cms.querylist.cc'.pq($img)->attr('src');
                    $localSrc = app_path() . '/../storage/app/public/'.md5($src).'.jpg';
                    $stream = file_get_contents($src);
                    file_put_contents($localSrc,$stream);
                    pq($img)->attr('src',$localSrc);
                }
                return $doc->htmlOuter();
            })
        );
        $rang = '.content';
        $ql = QueryList::Query($page,$reg,$rang);
        $data = $ql->getData();
//打印结果
        print_r($data);
    }

    public function caiji5()
    {
        //需要采集的目标页面
        $page = 'http://blog.zhuanxu.org/2016-12-06-eloquent-6.html';
//采集规则
        $reg = array(
            //采集文章标题
            'title' => array('.post-header h1','text'),
            //采集文章发布日期,这里用到了QueryList的过滤功能，过滤掉span标签和a标签
            'date' => array('time','text'),
            //采集文章正文内容,利用过滤功能去掉文章中的超链接，但保留超链接的文字，并去掉版权、JS代码等无用信息
            'content' => array('.post-body','html','a -script',function($content){
                //利用回调函数下载文章中的图片并替换图片路径为本地路径
                //使用本例请确保当前目录下有image文件夹，并有写入权限
                //由于QueryList是基于phpQuery的，所以可以随时随地使用phpQuery，当然在这里也可以使用正则或者其它方式达到同样的目的
                $doc = phpQuery::newDocumentHTML($content);
                $imgs = pq($doc)->find('img');
                foreach ($imgs as $img) {
                    $src = pq($img)->attr('src');
                    $localSrc = app_path() . '/../storage/app/public/'.md5($src).'.jpg';
                    $stream = file_get_contents($src);
                    file_put_contents($localSrc,$stream);
                    pq($img)->attr('src',$localSrc);
                }
                return $doc->htmlOuter();
            })
        );
        $rang = '.content';
        $ql = QueryList::Query($page,$reg,$rang);
        $data = $ql->getData();
//打印结果
        p($data);
    }
}