<?php

/**
 * This file is part of the Crypto package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\Crypto\Encryptor;

use Rafrsr\Crypto\EncryptorInterface;

class SodiumEncryptor implements EncryptorInterface
{
    private $secretKey;

    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * {@inheritdoc}
     */
    public function encrypt($value)
    {
        $nonce = random_bytes(SODIUM_CRYPTO_STREAM_NONCEBYTES);
        list($encKey, $authKey) = $this->splitKeys();

        $cipherText = sodium_crypto_stream_xor($value, $nonce, $encKey);
        sodium_memzero($value);
        $mac = sodium_crypto_auth($nonce.$cipherText, $authKey);
        sodium_memzero($encKey);
        sodium_memzero($authKey);

        return sodium_bin2hex($mac.$nonce.$cipherText);
    }

    /**
     * {@inheritdoc}
     */
    public function decrypt($value)
    {
        $raw = sodium_hex2bin($value);
        list($encKey, $authKey) = $this->splitKeys();

        $mac = mb_substr($raw, 0, SODIUM_CRYPTO_AUTH_BYTES, '8bit');
        $nonce = mb_substr($raw, SODIUM_CRYPTO_AUTH_BYTES, SODIUM_CRYPTO_STREAM_NONCEBYTES, '8bit');
        $cipherText = mb_substr($raw, SODIUM_CRYPTO_AUTH_BYTES + SODIUM_CRYPTO_STREAM_NONCEBYTES, null, '8bit');

        if (sodium_crypto_auth_verify($mac, $nonce.$cipherText, $authKey)) {
            sodium_memzero($authKey);
            $plaintext = sodium_crypto_stream_xor($cipherText, $nonce, $encKey);
            sodium_memzero($encKey);
            if ($plaintext !== false) {
                return $plaintext;
            }
        } else {
            sodium_memzero($authKey);
            sodium_memzero($encKey);
        }

        throw new \RuntimeException('Decryption failed.');
    }

    /**
     * Just an example. In a real system, you want to use HKDF for
     * key-splitting instead of just a keyed BLAKE2b hash.

     * @return array(2) [encryption key, authentication key]
     */
    private function splitKeys()
    {
        $key = md5($this->secretKey);
        $encKey = sodium_crypto_generichash(sodium_crypto_generichash('encryption', $key), $this->secretKey, SODIUM_CRYPTO_STREAM_KEYBYTES);
        $authKey = sodium_crypto_generichash(sodium_crypto_generichash('authentication', $key), $this->secretKey, SODIUM_CRYPTO_AUTH_KEYBYTES);

        return array($encKey, $authKey);
    }
}
