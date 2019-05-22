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
}