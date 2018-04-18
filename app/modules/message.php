<?php
class messageModules extends Modules
{

	/* 发送短信 */
	Public function sms_sendsms($str="")
	{
			//分裂数组(简化变量的访问)
			if($str){
					$str = plugin::extstr($str);//处理字符串
					extract($str);
			}else{
					extract($_POST);
			}

			//变量声明
			$mobile	  = $mobile;			//手机号码
			$ordersid = (int)$ordersid;		//订单号码
			$content  = $content;			//短信内容

			$strnum		=	mb_strlen($content,'UTF8');
			if($strnum>63){ return "短信内容字数太长，请重新修正！<br>建议最长字数为63个字（字母和中文都算1位）"; }
			$userid	  = $this->cookie->get("userid");

			$curl	= getFunc("curl");
			$dateline = time();


			// $ip		= plugin::getIP();
			// $sign	= array("userip"=>$ip,"dateline"=>$dateline);
			// $sign	= $this->buildsafe($sign);
			// $url	= "http://api.shui.cn/message/sendsms?dateline=$dateline&userip=$ip&sign=$sign";
			// //echo $url;exit;
			// $message = $content;
			// $message = urlencode($message);
			// $post	= "type=1&ordersid=$ordersid&mobile=$mobile&message=$message&userid=$userid&userip=$ip";
			// return $curl->contents($url,$post);
	}

	//安全码拼装
	Public function buildsafe($paramArr){
		$appkey	= date("h");
		$sign = "";
		ksort($paramArr);
		foreach($paramArr AS $key=>$val){
			if($key!=""&&$val!=""){
				$sign.=$key.$val;
			}
		}
		$sign = strtoupper(md5($appkey.$sign.$appkey));
		return $sign;
	}

}
?>
