<?php
namespace common\components;

class Sms
{
    private static $url = 'http://n.sms.ir/ws/SendReceive.asmx?wsdl';
    private static $lineNumber = '50002015583459';
    private static $username = '09147347973';
    private static $password = '268697';

    public static function send($to, $text)
    {
        ini_set('soap.wsdl_cache_enabled', '0');
        try{
            $soapClient = new \SoapClient(self::$url);
            $params = array(
                'userName'=>self::$username,
                'password'=>self::$password,
                'mobileNos'=>array(doubleval($to)),
                'messages'=>array($text),
                'lineNumber'=>self::$lineNumber,
                'sendDateTime'=>date("Y-m-d")."T".date("H:i:s"),
            );
            if($soapClient->SendMessageWithLineNumber($params)) {
                return TRUE;
            }
            return FALSE;
        } catch (Exception $e) {
            return FALSE;
        }
    }
}