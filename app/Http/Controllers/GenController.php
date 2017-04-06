<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Http\Controllers\Controller;
use zgldh\QiniuStorage\QiniuStorage;

class GenController extends Controller
{

    const RET_SUCCESS = '0';
    const RET_FAIL = '-1';
    const RET_USER_FAIL = '-2';
    const RET_SING_ERROR = '-3';

    const OVER_REQUEST_NUM = '超出调用上限';
    const PASSWORD_OR_USER_ERROR = '账号或密码错误';
    const RECODE_ERROR = '验证码错误';
    const REGISTER_ERROR = '注册失败';
    const SIGN_ERROR = 'Sign Error';
    const MOBILE_EXIST = '手机号码已经注册';
    const MOBILE_NOT_EXIST = '该用户不存在';
    const CODE_ERROR = '验证码不正确';
    const PARAMETER_ERROR = '参数错误';



    protected function passwdEncode($passwd, $salt)
    {
        $keya = md5(substr($passwd, 0, 16));
        $keyb = md5(substr($passwd, 16, 16));
        return md5($keya . $salt . $keyb);
    }

    protected function createToken($account, $user_id)
    {
        return md5($account . $user_id . time());
    }

    protected function setSalt()
    {
        return chr(mt_rand(65,122)).chr(mt_rand(65,122)).chr(mt_rand(65,122)).chr(mt_rand(65,122));
    }
    /**
     * 七牛图片上传
     */
    function uploadToQiniu(){

        Log::alert('$_FILE数据:' . print_r($_FILES, true));
        if (isset($_FILES['Filedata']['tmp_name'])) {

            //ext name
            $image_info = getimagesize($_FILES['Filedata']['tmp_name']);
            $file_name_arr = explode("/", $image_info['mime']);
            $file_name_ext = $file_name_arr[1];

            $disk = QiniuStorage::disk('qiniu');
            $contents = file_get_contents($_FILES['Filedata']['tmp_name']);

            //name
            $file_name = substr(md5_file($_FILES['Filedata']['tmp_name']), 12) . '.' . $file_name_ext;
            $disk->put($file_name, $contents);

        }
        return $file_name;
    }

}
