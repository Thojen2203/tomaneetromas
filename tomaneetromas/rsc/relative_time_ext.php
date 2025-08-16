<?php
function getRelativeTime($datetime, $depth=1) {

    $units = array(
        "an"=>31104000,
        "mois"=>2592000,
        "semaine"=>604800,
        "jour"=>86400,
        "heure"=>3600,
        "minute"=>60,
        "seconde"=>1
    );

    $plural = "s";
    $conjugator = " et ";
    $separator = ", ";
    $suffix1 = "il y a ";
    $suffix2 = "dans ";
    $now = "maintenant";
    $empty = "";

    # DO NOT EDIT BELOW

    $timediff = time()-strtotime($datetime);
    if ($timediff == 0) return $now;
    if ($depth < 1) return $empty;

    $max_depth = count($units);
    $remainder = abs($timediff);
    $output = "";
    $count_depth = 0;
    $fix_depth = true;
    $output .= ($timediff<0?$suffix2:$suffix1);
    foreach ($units as $unit=>$value) {
        if ($remainder>$value && $depth-->0) {
            if ($fix_depth) {
                $max_depth -= ++$count_depth;
                if ($depth>=$max_depth) $depth=$max_depth;
                $fix_depth = false;
            }
            $u = (int)($remainder/$value);
            $remainder %= $value;
            $pluralise = $u>1?$plural:$empty;
            $separate = $remainder==0||$depth==0?$empty:
                            ($depth==1?$conjugator:$separator);
            if (!($unit == "mois")){
                $output .= "{$u} {$unit}{$pluralise}{$separate}";
            }
            else{
                $output .= "{$u} {$unit}{$separate}";
            }
        }
        $count_depth++;
    }
    return $output;
}
?>