<?php

namespace App\Helpers;

use DateTime;

class MailAgentHelper {

    private static $login = 'aW5mb0BwaG90b2lnb3IubmFtZQ==';
    private static $pass = 'SW5mMDFuZk8=';

    public static function sendEmail($nameTo, $emailTo)
    {
        $message = "Шановний(а) $nameTo!"  . PHP_EOL;
        $message .= "Вдячні Вам за реєстрацію на нашому сайті Електронні Петиції" . PHP_EOL;
        $message .= "Для підтвердження Вашого облікового запису перейдіть за посиланням:" . PHP_EOL . PHP_EOL;
        //$message .= "http://" . $_SERVER['HTTP_HOST']. "/?page=confirmEmail&email=$emailTo". PHP_EOL . PHP_EOL;
        $message .= "http://" . $_SERVER['HTTP_HOST']. "/confirmEmail?email=$emailTo". PHP_EOL . PHP_EOL;

        $message .= "Не треба відповідати на цей лист." . PHP_EOL;
        $message .= "Якщо не Ви реєструвались на сайті просто ігноруйте лист" . PHP_EOL;
        $message .= "На все добре." . PHP_EOL;

        $header = self::prepareHeader($nameTo);

        $smtp_conn = fsockopen("mail.adm.tools", 25,$errno, $errstr, 10);
        $data = self::get_data($smtp_conn);

        fputs($smtp_conn,"EHLO mail.adm.tools" . PHP_EOL);
        $data = self::get_data($smtp_conn);

        fputs($smtp_conn,"AUTH LOGIN" . PHP_EOL);
        $data = self::get_data($smtp_conn);

        fputs($smtp_conn,self::$login . PHP_EOL);
        $data = self::get_data($smtp_conn);

        fputs($smtp_conn,self::$pass . PHP_EOL);
        $data = self::get_data($smtp_conn);

        fputs($smtp_conn,"MAIL FROM:info@photoigor.name" . PHP_EOL);
        $data = self::get_data($smtp_conn);

        fputs($smtp_conn,"RCPT TO:" . $emailTo . PHP_EOL);
        $data = self::get_data($smtp_conn);

        fputs($smtp_conn,"DATA" . PHP_EOL);
        $data = self::get_data($smtp_conn);

        fputs($smtp_conn,$header. PHP_EOL . $message . PHP_EOL . '.' . PHP_EOL);
        $data = self::get_data($smtp_conn);

        fputs($smtp_conn,"QUIT" . PHP_EOL);
        $data = self::get_data($smtp_conn);
    }

    /**
     * Получение данных из ответа сервера
     * @param $smtp_conn
     * @return string
     */
    private static function get_data($smtp_conn)
    {
        $data="";
        while($str = fgets($smtp_conn,515))
        {
            $data .= $str;
            if(substr($str,3,1) == " ") { break; }
        }
        return $data;
    }

    /**
     * Prepare header for email
     * @param $nameTo
     * @param $emailTo
     * @return string
     */
    private static function prepareHeader($nameTo) : string
    {
        $date = new DateTime('NOW');
//        $header="Date: ". date("D, j M Y G:i:s")." +0700" . PHP_EOL;
        $header="Date: ". $date->format('D-m-y H:i:s') . PHP_EOL;
        $header.="From: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('Електронні петиції')))."?= <info@photoigor.name>" . PHP_EOL;
        $header.="X-Mailer: The Bat! (v3.99.3) Professional" . PHP_EOL;
//        $header.="Reply-To: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('Електронні петиції')))."?= <info@photoigor.name>" . PHP_EOL;
        $header.="X-Priority: 3 (Normal)" . PHP_EOL;
        $header.="Message-ID: <172562218.".date("YmjHis")."@photoigor.name>" . PHP_EOL;
        $header.="To: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($nameTo)))."?= <info@photoigor.name>" . PHP_EOL;
        $header.="Subject: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('Підтвердження облікового запису')))."?=" . PHP_EOL;
        $header.="MIME-Version: 1.0" . PHP_EOL;
        $header.="Content-Type: text/plain; charset=utf-8" . PHP_EOL;
        $header.="Content-Transfer-Encoding: 8bit" . PHP_EOL;

        return $header;
    }
}