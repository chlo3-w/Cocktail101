<?php
     function clean_string($db_server = null, $string){ 
        $string = trim($string);
        $string = utf8_decode($string);
        $string = str_replace("#", "&#35", $string); 
        $string = str_replace("%", "&#37", $string);
    if($db_server){
        if (mysqli_real_escape_string($db_server, $string)) {
            $string = mysqli_real_escape_string($db_server, $string);
        }
    } 
            
        if (get_magic_quotes_gpc()) {
            $string = stripslashes($string);
         } 
        return htmlentities($string); 
    }

    function salt($string){
        $salt1 = 'a9*';
        $salt2 = 'b^5';
        $salted = md5("$salt1$string$salt2"); // salted md5
        return $salted;
    }

?>