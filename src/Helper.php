<?php

namespace Howtomakeaturn\Pay2goInvoice;

class Helper
{

    static function addpadding($string, $blocksize = 32) {
        $len = strlen($string);
        $pad = $blocksize - ($len % $blocksize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }

    static function curl_work($url = "", $parameter = "") {
        $curl_options = array(
        CURLOPT_URL => $url,
        CURLOPT_HEADER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERAGENT => "Google Bot",
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => FALSE,
        CURLOPT_SSL_VERIFYHOST => FALSE,
        CURLOPT_POST => "1",
        CURLOPT_POSTFIELDS => $parameter
        );
        $ch = curl_init();
        curl_setopt_array($ch, $curl_options);
        $result = curl_exec($ch);
        $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_errno($ch);
        curl_close($ch);
        $return_info = array(
            "url" => $url,
            "sent_parameter" => $parameter,
            "http_status" => $retcode,
            "curl_error_no" => $curl_error,
            "web_info" => $result
        );
        return $return_info;
    }

}