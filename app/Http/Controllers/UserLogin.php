<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\UserModel as Mu;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;

use function GuzzleHttp\json_decode;

class UserLogin extends Controller
{

        protected $access_token;

        public function __construct()
        {
            //获取 access_token
            $this->access_token=$this->getAccessToken();
        }
        //
        public function getAccessToken(){
          $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WX_APPID').'&secret='.env('WX_APPSECRET').'';
            $data_json=file_get_contents($url);
            $arr=json_decode($data_json,true);
            return $arr['access_token'];

        }


      //接收微信推送事件
      public function wxer(){

        //将接收的数据记录到日志文件
        $log_file ="wx.log";
        $xml_str=file_get_contents("php://input");
        $da=date('Y-m-d H:i:s',time()).$xml_str;
        file_put_contents($log_file,$da,FILE_APPEND);

        //处理xml数据
        $xml_obj =simplexml_load_string($xml_str);
        $event =$xml_obj->Event;

         //获取用户的openid
         $open_id=$xml_obj->FromUserName;
        if($event=='subscribe'){
           
           
            //获取用户信息
            $url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->access_token.'&openid='.$open_id.'&lang=zh_CN';
            $user_info=file_get_contents($url);
            file_put_contents('wx_user.log',$user_info,FILE_APPEND);

        }


    }

      //获取用户的基本信息
      public function getUserInfo($access_token,$open_id){

        $url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->access_token.'&openid='.$open_id.'&lang=zh_CN';
        //发送网络请求   发送的get的请求
        $json_str=file_get_contents($url);
        $log_file='wx_user.log';
        file_put_contents($log_file,$json_str,FILE_APPEND);

    }
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
    // public function addurl(){
    //     $cli = new Client();
    //     $response=$cli->request('get','https://www.jd.com/?cu=true&utm_source=buy.jiegeng.com&utm_medium=tuiguang&utm_campaign=t_1000159524_&utm_term=f6e348e503d6420e85200fb383cfb4ec');

    // }
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
