<?php namespace App\Http\Controllers\Api;

use Log;
use Lang;
use App\Models\StoreUser;
use Illuminate\Http\Request;
use App\Http\Controllers\GenController;
use zgldh\QiniuStorage\QiniuStorage;


/**
 * @SWG\Swagger(
 *     basePath="",
 *     @SWG\Info(
 *         version="1.0",
 *         title=""
 *     )
 * )
 */
class UserNoSignController extends GenController
{

    /**
     * @SWG\Post(path="/v1/user/login",
     *   tags={"user"},
     *   summary="用户登陆",
     *   description="",
     *   operationId="login",
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="账号信息",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(ref="#/definitions/login")
     *   ),
     *   @SWG\Parameter(
     *     name="password",
     *     in="query",
     *     description="密码",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(ref="#/definitions/string")
     *   ),
     *   @SWG\Response(response=200,description="successful operation"),
     * )
     * @SWG\Definition(
     *   definition="login",
     *   type="object",
     *   required={"account"},
     *   @SWG\Property(
     *      property="account",
     *      type="string"
     *   )
     * )
     */
    public function login(Request $request)
    {
        $account = $request->input('account');
        $password = $request->input('password');

        $StoreUser = StoreUser::whereAccount($account)->whereIdentity(StoreUser::IDENTITY_CLERK)->first();

        //用户名不正确
        if(is_null($StoreUser)){
            $result = array('ret' => self::RET_USER_FAIL, 'msg' => Lang::get('comm.account_error'), 'data' => (object)array());
            return response()->json($result);
        }

        //密码不正确
        if($StoreUser['password'] != self::passwdEncode($password,$StoreUser['salt'])){
            $result = array('ret' => self::RET_USER_FAIL, 'msg' => Lang::get('comm.password_error'), 'data' => (object)array());
            return response()->json($result);
        }

        StoreUser::whereId($StoreUser['id'])->update(array('token'=>self::createToken($StoreUser['account'],$StoreUser['id'])));

        $result = array('ret' => self::RET_SUCCESS, 'msg' => '', 'data' => self::getStoreUserInfo($StoreUser['id']));
        return response()->json($result);
    }

}

