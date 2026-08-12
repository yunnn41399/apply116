<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Captcha extends BaseController
{
    public function index()
    {
        // 從 Session 取得目前的驗證碼
        $captcha = session()->get('captcha');

        // 如果 Session 沒有驗證碼，就產生一組新的
        if (!$captcha) {
            $captcha = (string) random_int(1000, 9999);
            session()->set('captcha', $captcha);
        }

        // 建立圖片
        $width = 120;
        $height = 40;

        $image = imagecreatetruecolor($width, $height);

        // 設定背景顏色
        $backgroundColor = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $backgroundColor);

        // 設定文字顏色
        $textColor = imagecolorallocate($image, 0, 0, 0);

        // 使用 GD 內建字型繪製驗證碼
        imagestring(
            $image,
            5,
            35,
            12,
            $captcha,
            $textColor
        );

        // 告訴瀏覽器這是一張 PNG 圖片
        $this->response->setHeader('Content-Type', 'image/png');

        // 將圖片輸出到記憶體
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();

        // 釋放圖片資源
        imagedestroy($image);

        // 回傳圖片
        return $this->response
            ->setBody($imageData);
    }
}