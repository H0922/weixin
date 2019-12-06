<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\UserModel as Mu;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;
class UserLogin extends Controller
{
    public function addUser(){
        $pwd='123456';
        $pwds= password_hash($pwd,PASSWORD_BCRYPT);
        $data=[
            'user_name' => '李四',
            'password' =>$pwds,
            'email' => '737051678@qq.com'
        ];
        Mu::insert($data);
        dd(12345);
    }
    public function redisq(){
        $k='huangxiaobo';
        $v='nihaoma';
        Redis::set($k,$v);
        dump(Redis::get($k));
        dump(date('Y-m-d H:i:s'));
    }
    public function addurl(){
        $cli = new Client();
        $response=$cli->request('get','https://www.jd.com/?cu=true&utm_source=buy.jiegeng.com&utm_medium=tuiguang&utm_campaign=t_1000159524_&utm_term=f6e348e503d6420e85200fb383cfb4ec');

    }
    public function wx(){
        $token = '737051678ysd72bs7d2';
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $ec=$_GET['echostr'];
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        
        if( $tmpStr == $signature ){
            echo $ec;
        }else{
           die('not ok');
        }
    }
}
