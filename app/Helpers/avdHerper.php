<?php

/**
 * Return Json
 */
if ( !function_exists('typeJson'))
{
    function typeJson($array)
    {
        return json_decode(json_encode($array, FALSE));
    }
}


/**
 * Return config language
 */
if ( !function_exists('constLang'))
{
    function constLang($key)
    {

        return config('lang_pt-BR.'. $key);
    }
}


/**
 * Valor em real
 *
 * @param  string $numero
 */
if (! function_exists('setReal')) {
	function setReal($value){
		return 'R$ '.number_format((float)$value,2,',','.');
	}
}

/**
 * Limitar o texto de uma string
 *
 * @param  string $numero
 */
if (! function_exists('limitText')) {
    function limitText($str, $limit=100, $clear=true, $point=false){
        if($clear = true){
            $str = strip_tags($str);
        }
        if(strlen($str) <= $limit){
            return $str;
        }
        $limit_str = substr($str, 0, $limit);
        $last = strrpos($limit_str, ' ');
        return substr($limit_str, 0, $last).'...';
    }
}


/**
 * Trocar números por letras e vice versa.
 *
 * @param  string $str
 */

if (! function_exists('numLetter')) {
	function numLetter($str, $opc='')
	{
		if ($opc == 'letter') {
			$array = array(
				'0' => 'a',
				'1' => 'n', 
				'2' => 's', 
				'3' => 'e', 
				'4' => 'l', 
				'5' => 'm', 
				'6' => 'o', 
				'7' => 'v', 
				'8' => 'i', 
				'9' => 'u' 
			);
		} else {
			$array = array(
				'a' => 0,
				'n' => 1, 
				's' => 2, 
				'e' => 3, 
				'l' => 4, 
				'm' => 5, 
				'o' => 6, 
				'v' => 7, 
				'i' => 8, 
				'u' => 9 
			);
		}
		
		return strtr($str, $array);
	}
}

/**
 * Verifica se existe uma string no array.
 *
 * @var string str
 * @var array
 * @return  true ou false
 */
if (! function_exists('strInArray')) {
	function strInArray($str, $array){
		if (in_array($str, $array)) {
			return true;
		} else {
			return false;
		}
	}
}

if (! function_exists('ary_diff')) {
    function ary_diff( $ary_1, $ary_2 ) {
        // compare the value of 2 array
        // get differences that in ary_1 but not in ary_2
        // get difference that in ary_2 but not in ary_1
        // return the unique difference between value of 2 array
        $diff = array();

        // get differences that in ary_1 but not in ary_2
        foreach ( $ary_1 as $v1 ) {
            $flag = 0;
            foreach ( $ary_2 as $v2 ) {
                $flag |= ( $v1 == $v2 );
                if ( $flag ) break;
            }
            if ( !$flag ) array_push( $diff, $v1 );
        }

        // get difference that in ary_2 but not in ary_1
        foreach ( $ary_2 as $v2 ) {
            $flag = 0;
            foreach ( $ary_1 as $v1 ) {
                $flag |= ( $v1 == $v2 );
                if ( $flag ) break;
            }
            if ( !$flag && !in_array( $v2, $diff ) ) array_push( $diff, $v2 );
        }

        return $diff;
    }

}







