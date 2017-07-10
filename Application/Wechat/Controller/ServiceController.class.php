<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/8 0008
 * Time: 14:15
 */

namespace Wechat\Controller;


use Think\Controller;

class ServiceController extends Controller
{
    public function index(){
        $User = M('Document');
        $count      = $User->where(['category_id=41'])->count();
        $Page       = new \Think\Page($count,2);
        //$show       = $Page->show();
        $lists= $User->where(['category_id=41','status=1'])->limit($Page->firstRow.','.$Page->listRows)->select();
        if(empty($lists)){
            $this->ajaxreturn(false);
        }
        foreach ($lists as &$list){
            $model=M('Picture')->where(['id='.$list['cover_id']])->find();
            $list['time']=date('Y-m-d H:i:s',$list['create_time']);
            $list['img']=$model['path'];
        }
        //dump($lists);
        $this->ajaxreturn(['data'=>$lists]);

    }
    public function detail(){
        $id=(int)I('get.id',0);
        $document=M('Document')->where('id='.$id)->setInc('view');
        $list=M('Document')->where('id='.$id)->find();
        $row=M('DocumentArticle')->where('id='.$id)->find();
        $this->assign('list',$list);
        $this->assign('row',$row);
        $this->display();
    }
}