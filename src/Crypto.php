<?php

/**
 * This file is part of the Crypto package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\Crypto;

use Rafrsr\Crypto\Encryptor\MCryptEncryptor;
use Rafrsr\Crypto\Encryptor\SodiumEncryptor;
use Rafrsr\Crypto\Exception\AlgorithmNotSupportedException;

class Crypto
{
    protected $encryptor;

    public function __construct(EncryptorInterface $encryptor)
    {
        $this->encryptor = $encryptor;
    }

    /**
     * Factory
     *
     * Create a Crypto instance using a build in encryptor with given encryptor name
     * for now support all most used MCRYPT_* algorithms
     *
     * @param string                    $secretKey Secret key used for encryption/decryption
     * @param string|EncryptorInterface $encryptor One of MCRYPT_* constants or class or instance implementing EncryptorInterface
     *
     * @return Crypto
     * @throws AlgorithmNotSupportedException
     */
    public static function build($secretKey, $encryptor)
    {
        if (null === $encryptor) {
            if (\defined('MCRYPT_RIJNDAEL_256')) {
                $encryptor = MCRYPT_RIJNDAEL_256;
            } else {
                $encryptor = new SodiumEncryptor($secretKey);
            }
        }

        if (is_string($encryptor)) {
            if (class_exists($encryptor)) {
                $encryptor = new $encryptor($secretKey);
            } elseif (\function_exists('mcrypt_list_algorithms') && \in_array($encryptor, mcrypt_list_algorithms(), true)) {
                $encryptor = new MCryptEncryptor($secretKey, $encryptor);
            }
        }

        return new Crypto($encryptor);
    }

    public function encrypt($data)
    {
        if (null !== $data && '' !== $data && !$this->isEncrypted($data)) {
            return base64_encode('<Crypto>'.$this->encryptor->encrypt($data));
        }

        return $data;
    }

    public function decrypt($data)
    {
        if ($this->isEncrypted($data)) {
            $data = substr(base64_decode($data), 8);
            if ($data !== null && $data !== '') {
                return $this->encryptor->decrypt($data);
            }
        }

        return $data;
    }

    public function isEncrypted($data)
    {
        return $data && 0 === strpos(base64_decode($data), '<Crypto>');
    }
}
