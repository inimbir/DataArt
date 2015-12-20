<?php
$initstr = "Sam mas sammas"; //Исходная строка
$initstr = strtolower(str_replace(" ", "", $initstr));
$init_size = strlen($initstr);
$max=0;
$answer=$initstr[0];

for ($i=0; $i<$init_size-1; $i++) {
    for ($j=$init_size-$i; $j>1; $j--) {
        $atempt_str = substr($initstr, $i, $j);
        if (isPalindrome($atempt_str)) {
            if ($j>$max) {
                $max = $j;
                $answer = $atempt_str;
            }
            break;
        }
    }
}

echo $answer;

function isPalindrome($str) {
    $str_size = strlen($str);
    $whole = true;
    for ($i = 0; $i < round($str_size / 2); $i++) {
        if ($str[$i] != $str[$str_size - $i - 1]) {
            $whole = false;
            break;
        }
    }
    if ($whole) return true;
    return false;
}
?>