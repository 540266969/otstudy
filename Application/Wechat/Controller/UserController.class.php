<?php

namespace Wechat\Controller;

use User\Api\UserApi;

class UserController extends \Think\Controller
{
    public function index(){
        echo '111';
    }
    public function login($username = '', $password = '', $verify = ''){
        if(IS_POST){
            if(!check_verify($verify)){
                $this->error('验证码输入错误！');
            }

            /* 调用UC登录接口登录 */
            $user = new UserApi();
            $uid = $user->login($username, $password);
            //var_dump($uid);exit();
            if(0 < $uid){ //UC登录成功
                /* 登录用户 *///登录用户
                    //TODO:跳转到登录前页面
                $Member = D('Member');
                if($Member->login($uid)){ //登录用户
                    //TODO:跳转到登录前页面
                    $this->success('登录成功！', U('Index/index'));
                } else {
                    $this->error($Member->getError());
                }

            } else { //登录失败
                switch($uid) {
                    case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
                    case -2: $error = '密码错误！'; break;
                    default: $error = '未知错误！'; break; // 0-接口参数错误（调试阶段使用）
                }
                $this->error($error);
            }
        }else{
            $this->display();
        }
    }
    public function logout(){
        if(is_login()){
            D('Member')->logout();
            session('[destroy]');
            $this->success('退出成功！', U('user/login'));
        } else {
            $this->redirect('login');
        }
    }
    public function verify(){
        $verify = new \Think\Verify();
        $verify->entry(1);
    }
    public function test(){
       $session=session('user_auth');
       var_dump($session);exit();
    }
}