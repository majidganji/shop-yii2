<?php

namespace common\components;

class JahanPay {

    private static $api = 'gt36456g838';
    private static $wsdl = 'http://www.jahanpay.com/webservice?wsdl';

    public static function request($amount, $orderId, $description = '') {
        $client = new \SoapClient(self::$wsdl);
        $callBackUrl = \Yii::$app->urlManager->createAbsoluteUrl('products/facture');
        $res = $client->requestpayment(self::$api, $amount, $callBackUrl, $orderId, urlencode($description));
        if ($res > 0) {
            header('Location: http://www.jahanpay.com/pay_invoice/' . $res);
            echo '<meta http-equiv="Refresh" content="0; url=http://www.jahanpay.com/pay_invoice/' . $res . '" />';
            \Yii::$app->end();
        }
    }

    public static function verify($amount, $au) {
        $errorCodes = array(
            1 => 'تراکنش با موفقیت انجام شد',
            -6 => 'ارتباط با بانک برقرار نشد',
            -9 => 'خطای سیستمی',
            -20 => 'API نامعتبر است',
            -21 => 'IP نامعتبر است',
            -22 => 'مبلغ از کف تعریف شده کمتر است',
            -23 => 'مبلغ از سقف تعریف شده کمتر است',
            -24 => 'مبلغ نامعتبر است',
            -26 => 'درگاه غیرفعال است',
            -27 => 'IP شما مسدود است',
            -29 => 'آدرس بازگشت خالی است',
            -30 => 'چنین تراکنشی یافت نشد',
            -31 => 'تراکنش انجام نشده',
            -32 => 'تراکنش انجام شده اما مبلغ نادرست است',
        );
        $client = new \SoapClient(self::$wsdl);
        $result = $client->verification(self::$api, $amount, $au);
        if (isset($errorCodes[$result])) {
            return array($result, $errorCodes[$result]);
        }
        return array(0, 'خطای ناشناخته');
    }

}
