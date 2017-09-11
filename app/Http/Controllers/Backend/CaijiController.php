<?php
/**
 * Created by PhpStorm.
 * User: 月下追魂
 * Date: 2017/7/5
 * Time: 16:31
 */
namespace app\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Vod;
use Symfony\Component\HttpFoundation\Request;
use App\Models\M3Result;
use phpQuery;
use QL\QueryList;

class CaijiController extends Controller
{
    public $m3_result;
    public $video;

    public function __construct()
    {
        $this->video = new Video();
        $this->m3_result = new M3Result();
    }

    public function lists()
    {
        return view('backend/caiji/lists');
    }

    public function begin(Request $request)
    {
        $url = $request->input('url');
        $urls = array(
            $url,
        );
        $rang =array(
            'vod_name' => array('.vod-name','text'),
            'vod_ename' => array('.vod-name','text'),
            'vod_type' => array('.list-name','text'),
            'vod_director' => array('.vod-director','text'), # 主演
            'vod_actor' => array('.vod-actor','text'), #导演
            'vod_content' => array('.vod-content','text'), #介绍
            'vod_pic' => array('.vod-pic img','data-original'), #封面
            'vod_area' => array('.vod-area','text'),
            'vod_year' => array('.vod-year','text'),
            'vod_continu' => array('.vod-continu','text'),
            'vod_total' => array('.vod-total','text'),
            'vod_url' => array('.vod-play-list .sohu a', 'text'),
        );

        foreach($urls as $k =>$url){
            $info = QueryList::Query($url,$rang)->data;
        }
        $str = "";
        foreach($info as $k => $v){
            $str .= $v['vod_url'] . "\n";
        }
        $result = Vod::inser_data($info, $str);

        if($result){
            return redirect('/Backend/Caiji')->with('message', '采集成功!');
        }else{
            return redirect('/Backend/Caiji')->with('message', '采集失败!');
        }

        return view('backend/caiji/begin', compact('data', $data));

    }

    // 采集的视频列表
    public function caijiLists()
    {
        $io = Vod::find(22)->toArray();
        $mov =[];
        $arr = explode("\n", $io['vod_url']);
        foreach($arr as $k => $v){
            $str = explode("$", $v);
            @$mov[$k]['title']=$str[0];
            @$mov[$k]['url']=$str[1];
        }
//        p($mov);
//        die;
        return view('backend/caiji/caijiLists', compact('mov', $mov, 'io', $io));


    }




}