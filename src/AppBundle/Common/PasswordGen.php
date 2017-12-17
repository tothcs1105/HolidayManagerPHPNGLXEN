<?php

namespace AppBundle\Common;
/**
 * Created by PhpStorm.
 * User: tothc
 * Date: 12/18/2017
 * Time: 12:51 AM
 */
class PasswordGen
{
    /**
     * @param $plainText string
     * @return string
     */
    public static function GeneratePassword($plainText){
        return sha1($plainText);
    }
}