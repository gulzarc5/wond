<?php
use Illuminate\Http\Request;
class SmsHelpers{

    public static function smsSend($mobile,$sms)
    {
        $method = 'GET';
        $auth_key = '2dd8cdde38f3f56ea2b1c1590771a79';

  
        $sender="BKPLUS";
        $domain="http://sms.bulksmsmarg.com/rest/services/sendSMS/sendGroupSms";
        $sms = urlencode($sms);
        
        $parameters="AUTH_KEY=$auth_key&message=$sms&senderId=WNSLKD&routeId=1&mobileNos=$mobile&smsContentType=english";

        $url="$domain?".$parameters;

        $ch = curl_init($url);

        if($method=="POST")
        {
            curl_setopt($ch, CURLOPT_POST,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);
        }
        else
        {
            $get_url=$url."?".$parameters;

            curl_setopt($ch, CURLOPT_POST,0);
            curl_setopt($ch, CURLOPT_URL, $get_url);
        }

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); 
        curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  // RETURN THE CONTENTS OF THE CALL
        $return_val = curl_exec($ch);
        return $return_val;
    }
}