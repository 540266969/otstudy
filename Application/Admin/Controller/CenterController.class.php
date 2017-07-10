<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/6 0006
 * Time: 13:14
 */

namespace Admin\Controller;


class CenterController extends AdminController
{
    public function index(){
        $list=M('Saler')->order('id','desc')->select();
        $map = ['type'=>[1=>'出租',2=>'出售'],'unit'=>[1=>'元/月',2=>'万元'],'status'=>[1=>'正常',2=>'停用']];
        $list=int_to_string($list,$map);
        //dump($list);exit();
        $this->meta_title = '物业管理';
        $this->assign('list',$list);
        $this->display();
    }
    public function add(){
        if(IS_POST){
            $Saler= D('Saler');
            $data=$Saler->create();
            //var_dump($data);exit();
            if($data){
                $data['last_time']=strtotime($data['last_time']);
              //var_dump($data);exit;
//                var_dump('1899-12-19 00:00');
//                var_dump(strtotime('1899-12-19 00:00:00'));exit();
                $id=$Saler->add($data);
                if ($id){
                    $this->success('添加成功',U('index'));
                }
            }else{
                $this->error($Saler->getError());
            }
        }else{
            $this->display();
        }
    }
    public function edit($id=0){
        if(IS_POST){
            $Saler= D('Saler');
            $data = $Saler->create();
            //dump($data);exit();
            if($data){
                if($Saler->where('id='.$data['id'])->save($data)){
                    //记录行为
                    action_log('update_channel', 'channel', $data['id'], UID);
                    $this->success('编辑成功', U('index'));
                }else{
                    $this->error('编辑失败');
                }

            } else {
                $this->error($Saler->getError());
            }
        }else{
            //$id=I('get.id',0);
            $info=M('Saler')->find($id);
            if ($info===false){
                $this->error('获取配置信息错误');
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑租售信息';
            $this->display('add');
        }
    }
    public function del($id=0){
        $info=M('Saler');
        if($info->delete($id)){
            $this->success('删除成功', U('index'));
        }else{
            $this->error('删除失败');
        }
    }
    public function activity(){
        $lists=M('Activity')->join('onethink_document on onethink_activity.document_id=onethink_document.id')->join('onethink_ucenter_member on onethink_activity.member_id=onethink_ucenter_member.id')->field('onethink_activity.id,username,title,description,deadline,add_time,onethink_activity.status')->select();
        $map=['审核未通过','未审核','审核通过'];
        foreach ($lists as &$list){
            $list['status']=$map[$list['status']];
            $list['description']=mb_substr($list['description'],0,20);
        }
        //var_dump($lists);exit();
        $this->assign('lists',$lists);
        $this->display();
    }
}