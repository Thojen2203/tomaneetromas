<?php function numberToString($number){
	if (!is_numeric($number)) {
        return $number; // Retourne tel quel si ce n'est pas un nombre
    }
    return number_format($number, 0, ',', ' ');
}
?>