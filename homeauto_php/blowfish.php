<?php
class Encryption
{
    private $skaleton;
    public $key;

    function __construct(){
	$this->skaleton = "d3s8_fg,+2df*SA|Gs~2#";
	$this->key = $this->skaleton;
	}

    public function encrypt($data) {
	$key = md5($this->encryption_key);
	$encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_256,
	$key, $data, MCRYPT_MODE_CBC, md5($key));
	$encrypted = base64_encode($encrypted);
	return $encrypted;
	}

    public function decrypt($data) {
    	$key = md5($this->encryption_key);
	$data = base64_decode($data);
	$decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256,
        $key, $data, MCRYPT_MODE_CBC, md5($key));
	$decrypted = rtrim($decrypted, "\0");
        return $decrypted;
	}
}

/*
$kripto = new Encryption();
$sonuc = $kripto->encrypt('serkan');
var_dump($sonuc);
*/


/*
function decryptIt($data, $key) {
    $key = md5($key);
    $data = base64_decode($data);
    $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256,
        $key, $data, MCRYPT_MODE_CBC, md5($key));
    $decrypted = rtrim($decrypted, "\0");
    return $decrypted;
}
function encryptIt($data, $key) {
    $key = md5($key);
    $encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_256,
        $key, $data, MCRYPT_MODE_CBC, md5($key));
    $encrypted = base64_encode($encrypted);
    return $encrypted;
}
*/
?>
