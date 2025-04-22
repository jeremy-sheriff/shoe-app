<?php

namespace App\ExternalLibraries;

class FormatPhoneNumberUtil
{

    public static function formatPhoneNumber($phone_number)
    {

        if (substr($phone_number, 0, 2) == "07") {

            $phone_number = substr_replace($phone_number, "", 0, 2);
            $phone_number = "2547$phone_number";

        } else if (substr($phone_number, 0, 1) == "7") {

            $phone_number = substr_replace($phone_number, "", 0, 1);
            $phone_number = "2547$phone_number";

        } else if (substr($phone_number, 0, 4) == "null0") {

            $phone_number = substr_replace($phone_number, "", 0, 4);
            $phone_number = "254$phone_number";

        } else if (substr($phone_number, 0, 4) == "null7") {

            $phone_number = substr_replace($phone_number, "", 0, 3);
            $phone_number = "254$phone_number";

        } else if (substr($phone_number, 0, 4) == "+254") {

            $phone_number = substr_replace($phone_number, "", 0, 1);
        }

        return $phone_number;
    }
}

