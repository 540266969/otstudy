<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/6 0006
 * Time: 14:30
 */

namespace Admin\Model;


use Think\Model;

class SalerModel extends Model
{
    protected $_validate=array(
        array('tel','/^1[34578]\d{9}$/','电话号码不能为空',self::MUST_VALIDATE , 'regex',self::MODEL_BOTH),
        array('title','require','标题不能为空',self::MUST_VALIDATE,'regex', self::MODEL_BOTH),
        array('price','require','价格不能为空',self::MUST_VALIDATE,'regex', self::MODEL_BOTH),
        array('simple_des','require','简要描述不能为空',self::MUST_VALIDATE,'regex',self::MODEL_BOTH),
        array('price','currency','价格不能为空',self::MUST_VALIDATE,'regex',self::MODEL_BOTH),
    );
       // ['tel','require','电话号码不能为空'],
//        ['title','require','标题不能为空'],
//        ['price','require','价格不能为空'],
//        ['simple_des','require','简要描述不能为空'],
//        ['price','require','价格不能为空'],

    //];

    protected $_auto=[
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('name', 'admin', self::MODEL_INSERT),
    ];
}