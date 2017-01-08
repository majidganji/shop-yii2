<?php

namespace common\components;

use Yii;

class Image {


    public static function safeUpload($src, $fileName) {
        $path = Yii::$app->basePath . '/../frontend/web/photos/';
//        print_r($src);die;
        $src = ImageCreateFromJPEG($src);
        $sw = ImageSX($src);
        $sh = ImageSY($src);
        $dst = ImageCreateTrueColor($sw, $sh);
        ImageCopy($dst, $src, 0, 0, 0, 0, $sw, $sh);
        ImageJPEG($dst, $path . $fileName . '.jpg', 100);
        $dw = 150;
        $dh = $dw / ($sw / $sh);
        $dst = ImageCreateTrueColor($dw, $dh);
        ImageCopyResampled($dst, $src, 0, 0, 0, 0, $dw, $dh, $sw, $sh);
        ImageJPEG($dst, $path . $fileName . '_t.jpg', 100);
    }

}
