<!doctype html>
<html lang="en">
<head>
<!--<link rel="stylesheet" href="css/test.css">-->
</head>
<body>

<?php
//de aici in jos
	//upload and save file
	echo "Upload: " . $_FILES["files"]["name"] . "<br>";
    echo "Type: " . $_FILES["files"]["type"] . "<br>";
    echo "Size: " . ($_FILES["files"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["files"]["tmp_name"] . "<br>";
    move_uploaded_file($_FILES["files"]["tmp_name"], "upload/" . $_FILES["files"]["name"]);
    echo "Stored in: " . "upload/" . $_FILES["files"]["name"] . "<br>";
	$algoritm = $_POST["algoritm"];
	echo "Algoritm: ".$_POST["algoritm"]."<br>";
	
	//continutul fisierului
	$string = file_get_contents( "upload/".$_FILES["files"]["name"] );
	//cheia de criptare/decriptare
	$skey = "2015";//$_POST["key"]; /* cryptographic key */
	echo "Key: ".$key."<br>";
	
	//daca este imagine  afiseaz-o (jpg)
	if($_FILES["files"]["type"] == "image/jpeg")
	echo '<img src="upload/'.$_FILES["files"]["name"].'" height="160px" width="300px">';
	//daca este imagine  afiseaz-o (png)
	if($_FILES["files"]["type"] == "image/png")
	echo '<img src="upload/'.$_FILES["files"]["name"].'" height="160px" width="300px">';
	//daca este text  afiseaza-l
	if($_FILES["files"]["type"] == "text/plain")
	echo $string;
	//daca este audio  redal (mp3)
	if($_FILES["files"]["type"] == "audio/mp3")
	echo '<object data="upload/'.$_FILES["files"]["name"].'"></object><br>';
	//daca este audio  redal (ogg)
	if($_FILES["files"]["type"] == "audio/ogg")
	echo '<object data="upload/'.$_FILES["files"]["name"].'"></object><br>';

if($_POST["crypt"] == "crypt"){
class Encryption {
    //var $skey = "SecretKey"; // make it
	
    public  function safe_b64encode($string) {
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
    }
	//cripteaza cu 3DES
    public  function encode_1($value){ 
        if(!$value){return false;}
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_3DES, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
        return trim($this->safe_b64encode($crypttext)); 
    }
	//cripteaza cu RIJNDAEL_256
	public  function encode_2($value){ 
        if(!$value){return false;}
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
        return trim($this->safe_b64encode($crypttext)); 
    }
	//decripteaza cu 3DES
	public function decode_1($value){
        if(!$value){return false;}
        $crypttext = $this->safe_b64decode($value); 
        $iv_size = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_3DES, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }
	//decripteaza cu RIJNDAEL_256
    public function decode_2($value){
        if(!$value){return false;}
        $crypttext = $this->safe_b64decode($value); 
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }
}
//---------------------------------------------------------------
class RSA{
    //functia pentru generare a cheilor (returneaza array)
    //array[0] -> modulo N
    //array[1] -> cheia publica (formata din N si E)
    //array[2] -> cheia privata (formata din N si D)
    public function generate_keys ($p, $q, $show_debug=0){
      	$n = bcmul($p, $q);
        //bcmul -> funtie de inmultire
      
      	
        //m ne ajuta la calcularea lui E si D 
      	$m = bcmul(bcsub($p, 1), bcsub($q, 1));
        //bcsub -> scade un numar din alt numar
      
      	// cheia publica E 
      	$e = $this->findE($m);
      
      	// cheia privata D
      	$d = $this->extend($e,$m);
      
      	$keys = array ($n, $e, $d);

      	//optional   afisarea cheilor
        /*if ($show_debug) {
        		echo "P = $p<br>Q = $q<br><b>N = $n</b> - modulo<br>M = $m<br><b>E = $e</b> - public key<br><b>D = $d</b> - private key<p>";
      	}*/
      
      	return $keys;
    }

    //D (privata) = E (publica) - 1 * modN

    private function extend ($Ee,$Em) {
      	$u1 = '1';
      	$u2 = '0';
      	$u3 = $Em;
      	$v1 = '0';
      	$v2 = '1';
      	$v3 = $Ee;

      	while (bccomp($v3, 0) != 0) {
        //bccomp -> compara doua numere
        		$qq = bcdiv($u3, $v3, 0);
        		$t1 = bcsub($u1, bcmul($qq, $v1));
        		$t2 = bcsub($u2, bcmul($qq, $v2));
        		$t3 = bcsub($u3, bcmul($qq, $v3));
        		$u1 = $v1;
        		$u2 = $v2;
        		$u3 = $v3;
        		$v1 = $t1;
        		$v2 = $t2;
        		$v3 = $t3;
        		$z  = '1';
      	}

      	$uu = $u1;
      	$vv = $u2;

      	if (bccomp($vv, 0) == -1) {
        		$inverse = bcadd($vv, $Em);
      	} else {
        		$inverse = $vv;
      	}

      	return $inverse;
    }

    /* 
    * This function return Greatest Common Divisor for $e and $m numbers 
    */
    //cel mai mare divizor comun pentru e(publica) si m
    private function GCD($e,$m) {
      	$y = $e;
      	$x = $m;

      	while (bccomp($y, 0) != 0) {
        		// functia mod
            $w = bcsub($x, bcmul($y, bcdiv($x, $y, 0)));;
        		$x = $y;
        		$y = $w;
      	}

      	return $x;
    }

    /*
    * Calculating E under conditions:
    * GCD(N,E) = 1 and 1<E<N
    */
    //aflarea lui E astfel
    //cel mai mare divizor comun dintre N si E sa fie 1
    //1<E<N  E sa fie intre 1 si N
    private function findE($m){
        $e = '3';
        if(bccomp($this->GCD($e, $m), '1') != 0){
            $e = '5';
            $step = '2';

            while(bccomp($this->GCD($e, $m), '1') != 0){
                $e = bcadd($e, $step);

                if($step == '2'){
                    $step = '4';
                }else{
                    $step = '2';
                }
            }
        }

        return $e;
    }

    //criptarea cu ajutorul cheilor
    public function encrypt ($m, $e, $n, $s=3) {
        $coded   = '';
        //memoreaza textul criptat
        $max     = strlen($m);
        $packets = ceil($max/$s);
        
        for($i=0; $i<$packets; $i++){
            $packet = substr($m, $i*$s, $s);
            $code   = '0';

            for($j=0; $j<$s; $j++){
                $code = bcadd($code, bcmul(ord($packet[$j]), bcpow('256',$j)));
                //bcadd -> adunarea a doua numere
            }

            $code   = bcpowmod($code, $e, $n);
            //bcpowmod -> ridicarea unui numar la altul, redus cu un modul
            $coded .= $code.' ';
        }

      	return trim($coded);
    }
    //criptarea -> $M=$X^$D (mod N)
    public function decrypt ($c, $d, $n) {
        $coded   = split(' ', $c);
        $message = '';
        $max     = count($coded);

        for($i=0; $i<$max; $i++){
            $code = bcpowmod($coded[$i], $d, $n);

            while(bccomp($code, '0') != 0){
                $ascii    = bcmod($code, '256');
                $code     = bcdiv($code, '256', 0);
                $message .= chr($ascii);
            }
        }

        return $message;
    }
}
//---------------------------------------------------------------


//---------------------------------------------------------------
// -->> algoritmul 4 <<-- \\
//---------------------------------------------------------------


//daca este 3DES   cripteaza 
if($_POST["algoritm"] == '3DES'){
	$converter = new Encryption;
	$encoded = $converter->encode_1($string);
	$decoded = $converter->decode_1($encoded);
	
	$file = fopen("encode.data", "w");
	fwrite($file, $encoded);
	fclose($file);
	rename("encode.data", "download/encode.data");
	
	echo "<br><br>$encoded<br><br>$decoded<br>";
	echo '<a href="download/encode.data" target="_blank">DOWNLOAD</a>';
}
//daca este RIJNDAEL_256   cripteaza 
if($_POST["algoritm"] == 'RIJNDAEL_256'){
	$converter = new Encryption;
	$encoded = $converter->encode_2($string);
	$decoded = $converter->decode_2($encoded);
	
	$file = fopen("encode.data", "w");
	fwrite($file, $encoded);
	fclose($file);
	rename("encode.data", "download/encode.data");
	
	echo "<br><br>$encoded<br><br>$decoded<br>";
	echo '<a href="download/encode.data" target="_blank">DOWNLOAD</a>';
}
//daca este ALGORITMUL_MEU (RSA)
if($_POST["algoritm"] == 'RSA'){
	/*//echo 'aloritmul 3 este in lucru';
        //$message="Ana are mere";
        $encoded = $RSA->encrypt ($string, $keys[1], $keys[0], 5); //$encoded = $RSA->encrypt ($message, $keys[1], $keys[0], 5);
        $decoded = $RSA->decrypt ($encoded, $keys[2], $keys[0]);

        //echo "<b>Message:</b> $message<br />\n";
        echo "<b>Encoded:</b> $encoded<br />\n";
        echo "<b>Decoded:</b> $decoded<br />\n";*/


        //aici execut
        $RSA = new RSA();
        //generarea cheilor intre A si B
        $keys = $RSA->generate_keys ('9990454949', '9990450271', 1);

        //$message="Ana are mere";
        $encoded = $RSA->encrypt ($string, $keys[1], $keys[0], 5);  //$encoded = $RSA->encrypt ($message, $keys[1], $keys[0], 5);
        $decoded = $RSA->decrypt ($encoded, $keys[2], $keys[0]);

        //echo "<b>Message:</b> $message<br />\n";
         //echo "<b>Encoded:</b> $encoded<br />\n";
        //echo "<b>Decoded:</b> $decoded<br />\n";
        //optional    testez daca originalul este la fel cu cel decriptat
        //echo "Success: ".(($decoded == $message) ? "True" : "False")."<hr />\n";
	
	$file = fopen("encode.data", "w");
	fwrite($file, $encoded);
	fclose($file);
	rename("encode.data", "download/encode.data");
	
	echo "<br><br>$encoded<br><br>$decoded<br>";
	echo '<a href="download/encode.data" target="_blank">DOWNLOAD</a>';

// -->> algoritmul <<-- \\

}
//de aici in sus
//if-ul de criptare
	}
?>

</body>
</html>