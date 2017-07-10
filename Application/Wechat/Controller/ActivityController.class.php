<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/8 0008
 * Time: 11:35
 */

namespace Wechat\Controller;


use Think\Controller;

class ActivityController extends Controller
{
    public function index(){
        $User = M('Document');
        $count      = $User->where(['category_id=42'])->count();
        $Page       = new \Think\Page($count,2);
        //$show       = $Page->show();
        $time=time();
        $lists= $User->where(['category_id=42','status=1','deadline>='.$time])->limit($Page->firstRow.','.$Page->listRows)->select();
        //var_dump($lists);exit();
        if(empty($lists)){
            $this->ajaxreturn(false);
        }
        foreach ($lists as &$list){
            $model=M('Picture')->where(['id='.$list['cover_id']])->find();
            $list['create_time']=date('Y-m-d H:i:s',$list['create_time']);
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
    public function activity(){
        $document_id=(int)I('get.document_id');
        $member_id=session('user_auth')['uid'];
        if(!$member_id){
            $this->ajaxreturn('请先登录');
        }
        $model=M('Activity');
        $row=$model->where('member_id='.$member_id.' And document_id='.$document_id)->find();
        if(!empty($row)){
            $this->ajaxreturn('您已经参加过该活动啦');
        }
        $data=[];
        $data['document_id']=$document_id;
        $data['member_id']=$member_id;
        $data['add_time']=time();
        $data['status']=1;
        $model->add($data);
        $this->ajaxreturn('参加活动成功');
    }
}