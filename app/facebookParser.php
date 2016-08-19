<?php

namespace liw\app;

class FacebookParser
{
    public $url, $ajaxParams, $fbAccount, $count;

    public function __construct($id, $count_pages)
    {
        $this->url = 'https://www.facebook.com/search/'.$id.'/likers/';
        $this->count = $count_pages;
        $this->ajaxParams = Params::$ajaxParams;
    }

    public function curlParse($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/../cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/../cookie.txt');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36");
        curl_setopt($ch, CURLOPT_REFERER, "http://www.facebook.com");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function parse()
    {
        $fullContent = self::parseStatic();
        if (stripos($fullContent, '"USER_ID":"0"') !== false){
            return '';
        } else {
            $fullContent .= self::parseAjax($this->count);
            return $fullContent;
        }
    }

    public function parseStatic()
    {
        $content = self::curlParse($this->url);

        //search first cursor from static part
        $pos = stripos($content, '{cursor:"');
        $pos2 = stripos($content, '"', $pos+9);
        $this->ajaxParams['query']['cursor'] = substr($content, $pos+9, $pos2-$pos-9);

        //search uid
        $pos = stripos($content, 'CurrentUserInitialData",[],{"USER_ID":"');
        $pos2 = stripos($content, '"', $pos+39);
        $this->ajaxParams['link_add'] .= substr($content, $pos+39, $pos2-$pos-39).'&__a=1';

        return $content;
    }

    public function parseAjax($count = 1)
    {
        $content = '';
        for ($i=0;$i<$count;$i++){
            $ajaxUrl = $this->ajaxParams['link'].urlencode(json_encode($this->ajaxParams['query'])).$this->ajaxParams['link_add'];
            $ajax_content = self::curlParse($ajaxUrl);
            while ($ajax_content[0]!='{')
                $ajax_content = substr($ajax_content,1);
            $ajax_contentJson = json_decode($ajax_content);
            $this->ajaxParams['query']['cursor'] = $ajax_contentJson->jsmods->require[1][3][0]->cursor;
            $this->ajaxParams['query']['page_number'] = $ajax_contentJson->jsmods->require[1][3][0]->page_number;
            $content .= (is_string($ajax_contentJson->payload)? $ajax_contentJson->payload : '');
        }
        return $content;
    }

}

?>