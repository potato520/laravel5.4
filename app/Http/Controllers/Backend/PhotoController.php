<?php
/**
 * Created by PhpStorm.
 * User: 月下追魂
 * Date: 2017/7/25
 * Time: 16:54
 */
namespace app\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\M3Result;
use App\Models\Video;

class PhotoController extends Controller
{
    public $m3_result;
    public function __construct()
    {
        $this->m3_result = new M3Result();
    }

    public function lists()
    {
        $lists = Video::where('id','>','0')->orderBy('id', 'DESC')->paginate($perPage = 6, $columns = ['*'], $pageName = 'page', $page = null);
        return view('backend/photo/lists', compact('lists', $lists));
    }
}