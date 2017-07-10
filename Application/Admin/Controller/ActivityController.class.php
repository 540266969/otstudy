<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/9 0009
 * Time: 09:44
 */

namespace Admin\Controller;


use Think\Controller;

class ActivityController extends Controller
{
    public function pass(){
        $id=(int)I('get.id',0);
        //var_dump($id);exit();
        $list=M('Activity');
        $list->where('id='.$id)->setField('status',2);
        //var_dump($list);exit();
        $this->success('审核完成',U('Center/activity'));
    }
    public function nopass(){
        $id=(int)I('get.id',0);
        $list=M('Activity');
        $list->where('id='.$id)->setField('status',0);
        $this->success('审核完成',U('Center/activity'));
    }
}