# Crypto
Easy encrypt and decrypt strings in PHP.

## Usage

````php

use Rafrsr\Crypto\Crypto;

$encryptor = Crypto::build('JH83UN177772JJASHGAGG38UABASDSD', MCRYPT_RIJNDAEL_256);

$secret = $encryptor->encrypt('This is a secret message');

if ($encryptor->isEncrypted($secret)) {
    echo 'The messages is encrypted';
}

$notSecret = $encryptor->decrypt($secret);

if (!$encryptor->isEncrypted($notSecret)) {
    echo 'The message is not encrypted';
}