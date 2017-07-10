<?php

namespace Wechat\Controller;

class IndexController extends \Think\Controller
{
    public function index(){
        $this->display();
    }
    public function saler(){
        $lists=M('Saler')->where('status=1')->select();
        $rows=M('Saler')->where('status=2')->select();
        $this->assign('lists',$lists);
        $this->assign('rows',$rows);
        $this->display();
        //echo '你来啦';
    }
    public function report(){
        if(empty(session('user_auth'))){
            $this->error('请先登录',U('user/login'));
        }
        if(IS_POST){
            $model=D('Repair');
            $data=$model->create();
            //var_dump($model);exit();
            if($data){
                $id=$model->add();
                if($id){
                    $this->success('添加成功',U('index'));
                }
            }else{
                $this->error($model->getError());
            }
        }else{
            $this->display();
        }
    }
    public function zsdetail(){
        $id=I('get.id',0);
        $list=D('Saler')->where(['id='.$id])->find();
        if($list){
            $list['text']=$list['unit']==1?'元/月':'万元';
            //var_dump($list);exit();
            $this->assign('list',$list);
            $this->display();
        }else{
            $this->error('该消息不存在');
        }
        //var_dump($list);exit();
    }
    public function notice(){
        $User = M('Document');
        $count      = $User->where(['category_id=40'])->count();
        $Page       = new \Think\Page($count,2);
        $show       = $Page->show();
        //dump($Page);exit();
        $lists= $User->where(['category_id=40'])->limit($Page->firstRow.','.$Page->listRows)->select();
        //$lists=M('Document')->where(['category_id=40'])->select();
        //var_dump($lists);exit();
        if(empty($lists)){
            $this->error('暂时没有新的消息');
        }
        foreach ($lists as &$list){
            $model=M('Picture')->where(['id='.$list['cover_id']])->find();
            $list['img']=$model['path'];
        }
        $this->assign('page',$show);
        $this->assign('lists',$lists);
        $this->display();
    }
    public function nodetail(){
        $id=I('get.id',0);
        $list=M('Document')->where('id='.$id)->find();
        $row=M('DocumentArticle')->where('id='.$id)->find();
        $this->assign('list',$list);
        $this->assign('row',$row);
        $this->display();
    }
    public function service(){
        $this->display();
    }
    public function shop(){
        $this->display();
    }
    public function activity(){
        $this->display();
    }
}