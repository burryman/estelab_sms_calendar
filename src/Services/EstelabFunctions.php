<?php
/**
 * Created by PhpStorm.
 * User: krasnitskiy
 * Date: 22.05.2019
 * Time: 13:52
 */

namespace App\Services;


class EstelabFunctions
{
    public static function generateUrlCode($repository, $length = 8) {
        $unique = false;

        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        do {

            for ($i = 0, $result = ''; $i < $length; $i++) {
                $index = rand(0, $count - 1);
                $result .= mb_substr($chars, $index, 1);
            }

            $entry = $repository->findOneBy(['shortUrlCode' => $result]);

            if (!$entry) {
                $unique = true;
            }

        } while (!$unique);

        return $result;
    }

    public static function date3339($timestamp=0) {

        if (!$timestamp) {
            $timestamp = time();
        }
        $date = date('Y-m-d\TH:i:s', $timestamp);

        $matches = array();
        if (preg_match('/^([\-+])(\d{2})(\d{2})$/', date('O', $timestamp), $matches)) {
            $date .= $matches[1].$matches[2].':'.$matches[3];
        } else {
            $date .= 'Z';
        }
        return $date;
    }

    public static function ru_date($format, $date = false) {
        setlocale(LC_ALL, 'ru_RU.cp1251');
        if ($date === false) {
            $date = time();
        }
        if ($format === '') {
            $format = '%e&nbsp;%bg&nbsp;%Y&nbsp;г.';
        }
        $months = explode("|", '|января|февраля|марта|апреля|мая|июня|июля|августа|сентября|октября|ноября|декабря');
        $format = preg_replace("~\%bg~", $months[date('n', $date)], $format);
        $res = strftime($format, $date);

        return $res;
    }
}