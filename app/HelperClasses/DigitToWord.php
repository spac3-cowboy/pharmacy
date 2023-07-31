<?php

namespace App\HelperClasses;




use NumberFormatter;

class DigitToWord {

    public static function convert($num)
    {
        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return $f->format($num);
    }
}
