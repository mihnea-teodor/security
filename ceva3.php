<?php
    if (isset($_REQUEST['select'])) {
    $choice = $_POST['select'];
      $mykey = $_POST['mykey'];
    $msg = $_POST['plain'];
    } else {
    die("algorithm not selected");
      }

    if ($msg == ''){
        die("Please enter a text to encrypt! ");
        }
    if ($mykey == ''){
        die("Please enter a key! ");
        }         
    
    function algorithmdetails($cipher)
    {
        $chiphername = mcrypt_enc_get_algorithms_name($cipher);
        $blocksize = mcrypt_enc_get_block_size($cipher);
        $mykeysize = mcrypt_enc_get_supported_key_sizes($cipher);
        echo "<p><b>Cipher Name :</b> $chiphername";    
        echo "<p><b>Block size :</b> $blocksize bytes";
        echo "<p><b>Key size :</b> ";    
        foreach ($mykeysize as $value)
        {
        echo "$value bytes ";
        }unset($value);
    }
    
    function encryptnow($thecipher, $thekey, $themsg)
    {
        $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($thecipher), MCRYPT_DEV_RANDOM);
        mcrypt_generic_init($thecipher, $thekey, $iv);
        $encrypted_text = mcrypt_generic($thecipher, $themsg);
        echo "<html><hr size='2' ></html>";
        echo "<P><P><b>Plain Text : </b>"; 
        echo($themsg); 
        echo "<p><b>Cipher Text : </b> "; 
        echo "$encrypted_text";
        mcrypt_generic_deinit($thecipher);
        mcrypt_module_close($thecipher);
        die();
    }
    
    if ($choice == '1'){
        $cipher = mcrypt_module_open (MCRYPT_DES, '', 'ecb', ''); //Data Encryption Standard
        algorithmdetails($cipher);
        encryptnow($cipher, $mykey, $msg);
    
    }elseif ($choice == '2'){
        $cipher = mcrypt_module_open (MCRYPT_3DES, '', 'ecb', ''); //Triple Data Encryption Algorithm
        algorithmdetails($cipher);
        encryptnow($cipher, $mykey, $msg);
    
    }elseif ($choice == '3'){
        $cipher = mcrypt_module_open (MCRYPT_RIJNDAEL_128, '', 'ecb', ''); //
        algorithmdetails($cipher);
        encryptnow($cipher, $mykey, $msg);
    
    }elseif ($choice == '4'){
        $cipher = mcrypt_module_open (MCRYPT_GOST, '', 'ecb', '');
        algorithmdetails($cipher);
        encryptnow($cipher, $mykey, $msg);
        
    }else {
        die("Please choose an algorithm!");
    }    
    
?>