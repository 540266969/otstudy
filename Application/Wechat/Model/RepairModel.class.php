<?php

namespace Wechat\model;
use Think\Model;

class RepairModel extends Model
{
    protected $_validate=[
        ['tel','/^1[34578]\d{9}$/','电话号码不能为空',self::MUST_VALIDATE , 'regex',self::MODEL_BOTH],
        ['username','require','用户名不能为空',self::MUST_VALIDATE,'regex', self::MODEL_BOTH],
        ['room','require','住处不能为空',self::MUST_VALIDATE,'regex', self::MODEL_BOTH],
        ['relation','number','与业主关系不能为空',self::MUST_VALIDATE,'regex',self::MODEL_BOTH],
        ['idcard','/^\d{17}[\dXx]$/','身份证号码不正确',self::MUST_VALIDATE,'regex',self::MODEL_BOTH],
    ];
    protected $_auto=[
        ['create_time', NOW_TIME, self::MODEL_INSERT]
    ];
}