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
use Rafrsr\Crypto\Exception\AlgorithmNotSupportedException;

/**
 * Class Crypto
 */
class Crypto
{
    /**
     * @var EncryptorInterface
     */
    protected $encryptor;

    /**
     * BaseEncryptor constructor.
     */
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
     * @param string $secretKey Secret key used for encryption/decryption
     * @param string $encryptor one of MCRYPT_* constants or class or instance implementing EncryptorInterface
     *
     * @return Crypto
     * @throws AlgorithmNotSupportedException
     */
    public static function build($secretKey, $encryptor = MCRYPT_RIJNDAEL_256)
    {
        if (is_string($encryptor)) {
            $algorithms = mcrypt_list_algorithms();
            if (in_array($encryptor, $algorithms)) {
                $encryptor = new MCryptEncryptor($secretKey, $encryptor);
            } elseif (class_exists($encryptor)) {
                $encryptor = new $encryptor;
            }
        }

        return new Crypto($encryptor);
    }

    /**
     * @inheritDoc
     */
    public function encrypt($data)
    {
        if (!$this->isEncrypted($data) && $data !== null && $data !== '') {
            return base64_encode("<Crypto>" . $this->encryptor->encrypt($data));
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
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

    /**
     * @inheritDoc
     */
    public function isEncrypted($data)
    {
        if (!empty($data) && substr(base64_decode($data), 0, 8) == '<Crypto>') {
            return true;
        }

        return false;
    }
}