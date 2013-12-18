<?php

/**
 *  字符截取
 * @param type $str
 * @param type $maxWidth
 * @param type $encoding
 * @return string 
 */
function strMax($str, $maxWidth = 1400, $encoding='utf-8') {
    $strlen = mb_strlen($str);

    $newStr = '';
    for ($pos = 0, $currwidth = 0; $pos < $strlen; ++$pos) {
        $ch = mb_substr($str, $pos, 1, $encoding);
        if ($currwidth + mb_strwidth($ch, $encoding) > $maxWidth)
            break;

        $newStr .= $ch;
        $currwidth += mb_strwidth($ch, $encoding) > 1 ? 2 : 1;
    }
    if (strlen($newStr) < $strlen)
        $newStr.= "";
    return $newStr;
}
function strDoctorDefined($str, $maxWidth, $encoding='utf-8') {
    $strlen = mb_strlen($str);

    $newStr = '';
    for ($pos = 0, $currwidth = 0; $pos < $strlen; ++$pos) {
        $ch = mb_substr($str, $pos, 1, $encoding);
        if ($currwidth + mb_strwidth($ch, $encoding) > $maxWidth)
            break;

        $newStr .= $ch;
        $currwidth += mb_strwidth($ch, $encoding) > 1 ? 2 : 1;
    }
    if (strlen($newStr) < $strlen)
        $newStr.= "......";
    return $newStr;
}


function strDoctorMax($str, $maxWidth = 40, $encoding='utf-8') {
    $strlen = mb_strlen($str);

    $newStr = '';
    for ($pos = 0, $currwidth = 0; $pos < $strlen; ++$pos) {
        $ch = mb_substr($str, $pos, 1, $encoding);
        if ($currwidth + mb_strwidth($ch, $encoding) > $maxWidth)
            break;

        $newStr .= $ch;
        $currwidth += mb_strwidth($ch, $encoding) > 1 ? 2 : 1;
    }
    if (strlen($newStr) < $strlen)
        $newStr.= "......";
    return $newStr;
}

function strreviewMax($str, $maxWidth = 400, $encoding='utf-8') {
    $strlen = mb_strlen($str);

    $newStr = '';
    for ($pos = 0, $currwidth = 0; $pos < $strlen; ++$pos) {
        $ch = mb_substr($str, $pos, 1, $encoding);
        if ($currwidth + mb_strwidth($ch, $encoding) > $maxWidth)
            break;

        $newStr .= $ch;
        $currwidth += mb_strwidth($ch, $encoding) > 1 ? 2 : 1;
    }
    if (strlen($newStr) < $strlen)
        $newStr.= "..........";
    return $newStr;
}
/**
 *   重组一维数组
 */
function search_filter($array) {
   $i = 0;
   foreach($array as $v){
       $newarray[$i] = $v;
       $i++;
   }
   return $newarray;
}
?>
