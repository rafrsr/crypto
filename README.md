# Crypto
[![Build Status](https://travis-ci.org/rafrsr/crypto.svg?branch=master)](https://travis-ci.org/rafrsr/crypto)
[![Coverage Status](https://coveralls.io/repos/rafrsr/Crypto/badge.svg?branch=master&service=github)](https://coveralls.io/github/rafrsr/Crypto?branch=master)
[![Latest Stable Version](https://poser.pugx.org/rafrsr/crypto/version)](https://packagist.org/packages/rafrsr/crypto)
[![Latest Unstable Version](https://poser.pugx.org/rafrsr/crypto/v/unstable)](//packagist.org/packages/rafrsr/crypto)
[![Total Downloads](https://poser.pugx.org/rafrsr/crypto/downloads)](https://packagist.org/packages/rafrsr/crypto)
[![License](https://poser.pugx.org/rafrsr/crypto/license)](https://packagist.org/packages/rafrsr/crypto)

Easy encrypt and decrypt strings in PHP.

## Features

- Easy usage `Crypto::build('secretKey')->encrypt('secret message')`
- Support most populars MCRYPT algorithms
- Encryption verification through the method `isEncrypted($data)`
- Prevent double encryption/decryption

## Usage

````php

use Rafrsr\Crypto\Crypto;

$encryptor = Crypto::build('JH83UN177772JJASHGAGG38UABASDSD', MCRYPT_RIJNDAEL_128);

$secret = $encryptor->encrypt('This is a secret message');

if ($encryptor->isEncrypted($secret)) {
    echo 'The messages is encrypted';
}

$notSecret = $encryptor->decrypt($secret);

if (!$encryptor->isEncrypted($notSecret)) {
    echo 'The message is not encrypted';
}