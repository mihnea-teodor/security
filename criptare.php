<html>
<head><title>CRIPTARE.PHP - TEST</title></head>
<body>

<?php
class Encryption {
    var $skey = ""; //cheia

    /*public  function safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }
	
    public function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }*/
	
	//criptarea textului
    public  function encode($value){ 
        if(!$value){return false;}
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
        return trim($this->safe_b64encode($crypttext)); 
    }
	
	//decriptarea textului
    public function decode($value){
        if(!$value){return false;}
        $crypttext = $this->safe_b64decode($value); 
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }
}

// de aici in jos
$myFile = file_get_contents('map.jpg');
echo mime_content_type('map.jpg');
if(mime_content_type('map.jpg') == "image/jpeg"){
	echo '<img src="map.jpg">';
}
else{
	echo $myFile;
}
echo '<form method="post" action="criptare.php">
<input type="text" name="text" value="'.$myFile.'" hidden>
<input type="submit" value="cripteaza">
</form>';
//formularul de criptare
//input text ascuns
//input text este autocompleatat cu continutul fisierului
//input submit    trebuie sa se trimita singur

$str = $_POST["text"];
//echo $str."<br>";

$converter = new Encryption;
$encoded = $converter->encode($str );
$decoded = $converter->decode($encoded);   

//echo $myFile;

echo "$encoded<p>$decoded";

?>