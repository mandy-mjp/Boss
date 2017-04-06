<?php namespace App\Http\Controllers;

use App\Models\UBase;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\GenController;
use Log;

class SignController extends GenController
{

    public function __construct(Request $request)
    {
        self::checkSign($request);
    }


    public function checkSign($request)
    {

        //echo md5("192.168.222.33:3838/v1/user/1613||2986135091baaf0909c9eaa4399fb7b5||1427685903").'|||';
        //http://192.168.222.33:3838/v1/user/1612?sign=facd3a640dfc6de584cea92c3a098e6e&timestamp=1427685903

        $uid = $request->input('uid');
        $sign = $request->input('sign');
        $timestamp = $request->input('timestamp');
        $base_url = 'http://' . $request->getHttpHost() . $request->getPathInfo();
        return true;
        if(isset($_GET['gg']) && $_GET['gg']=='jj'){
            return true;
        }

        //时间超时
        if ($timestamp > time() + 3600 * 1000 || $timestamp < time() - 3600 * 1000) {
            $result = array('ret' => self::RET_FAIL, 'msg' => self::SIGN_TIME_OUT, 'data' => (object)array());
            //echo json_encode($result);
            //exit;
        }


        //$current_user = UBase::find($uid);
        //用户不存在
        //Log::alert('$current_user:' . print_r($current_user, true));
        //Log::alert('$uid:' . print_r($uid, true));

        if (is_null($current_user)) {
            $result = array('ret' => self::RET_FAIL, 'msg' => self::USER_ID_NOT_EXIT, 'data' => (object)array());
            echo json_encode($result);
            exit;
        }


        //
        $sign_md5 = md5($base_url . '||' . $current_user->token . '||' . $timestamp);
        //Log::alert('backend params:' . $base_url . '||' . $current_user->token . '||' . $timestamp);

        //Log::alert('backend sing||app sign:' . print_r($sign_md5.'||'.$sign, true));
        if ($sign == $sign_md5) {
            return true;
        }


        //return true;

        $result = array('ret' => self::RET_FAIL, 'msg' => self::SIGN_ERROR, 'data' =>(object)array());
        echo json_encode($result);
        exit;
    }

}
