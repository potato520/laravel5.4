<?php
/**
 * Created by PhpStorm.
 * User: youkaili
 * Date: 2017/7/5
 * Time: 18:07
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Vod extends Model
{
    protected $table = 'vod';
    protected $primarykey = 'vod_id';
    //定义可以批量赋值的黑名单,定义白名单是protected $fillable
    protected $guarded = ['vod_id', 'created_at', 'updated_at'];
//    protected $fillable = ['vod_cid', 'vod_name', 'content','vod_title',
//        'vod_keywords','vod_type','vod_color','vod_actor','vod_director',
//        'vod_content','vod_pic','vod_pic_bg','vod_area','vod_year',
//        'vod_continu','vod_total','vod_addtime','vod_hits','vod_url']; # 批量赋值 Student::create($data)

    static public function inser_data($info, $str)
    {
        $data = array(
            'vod_name' => $info[0]['vod_name'],
            'vod_ename' => $info[0]['vod_ename'],
            'vod_type' => $info[0]['vod_type'],
            'vod_director' => $info[0]['vod_director'],
            'vod_actor' => $info[0]['vod_actor'],
            'vod_content' => $info[0]['vod_content'],
            'vod_pic' => $info[0]['vod_pic'],
            'vod_area' => $info[0]['vod_area'],
            'vod_year' => $info[0]['vod_year'],
            'vod_continu' => $info[0]['vod_continu'],
            'vod_total' => $info[0]['vod_total'],
            'vod_rand_code' => time() . 'ssjm' . uniqid(), // 影片的唯一标识
            'vod_url' => $str,
            'vod_addtime' => time()
        );
        return Vod::create($data);
    }

}