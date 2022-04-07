<?php

namespace App\Helpers;

class Terbilang{
    public static function indonesia($x)
    {
      $abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
      if ($x < 12)
        return " " . $abil[$x];
      elseif ($x < 20)
        return self::indonesia($x - 10) . " Belas";
      elseif ($x < 100)
        return self::indonesia($x / 10) . " Puluh" . self::indonesia($x % 10);
      elseif ($x < 200)
        return " Seratus" . self::indonesia($x - 100);
      elseif ($x < 1000)
        return self::indonesia($x / 100) . " Ratus" . self::indonesia($x % 100);
      elseif ($x < 2000)
        return " Seribu" . self::indonesia($x - 1000);
      elseif ($x < 1000000)
        return self::indonesia($x / 1000) . " Ribu" . self::indonesia($x % 1000);
      elseif ($x < 1000000000)
        return self::indonesia($x / 1000000) . " Juta" . self::indonesia($x % 1000000);
      elseif ($x < 1000000000000)
        return self::indonesia($x / 1000000000) . " Milyar" . self::indonesia($x % 1000000000);
    }
}