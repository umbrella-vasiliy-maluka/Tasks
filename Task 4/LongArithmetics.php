<?php

public function longNumSum($str1,$str2) {
    $strLen1 = strlen($str1);
    $strLen2 = strlen($str2);
    
    $strLenDiff = $strLen1 - $strLen2;
    // generate to single num length
    if ($strLenDiff > 0) {
        $str2 = str_pad($str2,$strLenDiff+$strLen2,"0",STR_PAD_LEFT);
    } else {
        $str1 = str_pad($str1,abs($strLenDiff)+$strLen1,"0",STR_PAD_LEFT);
    }
    
    $pol = [];
    $base = 10;
    $overf = 0;
    // Sum from right to left
    for($i = strlen($str1)-1; $i >= 0;$i--) {
        $sum = $str1[$i] + $str2[$i] + $overf;
        if ($sum < $base) {
            $pol[] = $sum;
            $overf = 0;
        } else {
            $pol[] = $sum - $base;
            $overf = 1;
        }
    }
    // Additionaly set overflow from last iteration
    $pol[] = $overf;
    $mR = array_reverse($pol);
    $strR = ltrim(implode($mR), '0');
    return $strR;
}


$str1 = '1000092233720368547758070034';
$str2 = '92233720368547758070034';

echo longNumSum($str1,$str2);