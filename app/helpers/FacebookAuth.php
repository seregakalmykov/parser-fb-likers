<?php

namespace liw\app\helpers;

use liw\app\Params;

class FacebookAuth {

    public static function auth($email, $pass)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.facebook.com/login.php');
        curl_setopt($ch, CURLOPT_POSTFIELDS,'email='.urlencode($email).'&pass='.urlencode($pass).'&login=Login');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/../../cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/../../cookie.txt');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $page = curl_exec($ch) or die(curl_error($ch));
        curl_close($ch);
    }

    public static function quit()
    {
        unlink(dirname(__FILE__).'/../../cookie.txt');
    }

}

?>