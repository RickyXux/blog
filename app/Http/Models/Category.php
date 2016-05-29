<?php

namespace App\http\models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';    //指定表明
    protected $primaryKey = 'cate_id';
    public $timestamps = false;
    protected $guarded = [];    //黑名单，除此之外的字段都可以直接创建


//    public function tree() {
//        $category = Category::all();
//        return (new Category)->getTree($category,'cate_name','cate_id','cate_pid');
//    }

    public function tree() {
        $category = $this->orderBy('cate_order', 'asc')->get();
        return $this->getTree($category,'cate_name','cate_id','cate_pid');
    }

    public function getTree($data,$field_name,$field_id="id",$field_pid="pid",$pid=0)
    {
        $arr=array();
        foreach($data as $k=>$v) {
            if ($v->$field_pid==$pid) {
                $arr[]=$data[$k];
                foreach ($data as $m=>$n) {
                    if ($n->$field_pid==$v->$field_id) {
                        $data[$m][$field_name]="├─".$data[$m][$field_name];
                        $arr[]=$data[$m];
                    }
                }
            }
        }
        return $arr;
    }
}
