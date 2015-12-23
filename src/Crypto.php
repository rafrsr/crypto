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

/**
 * Class Crypto
 */
class Crypto
{
    /**
     * build
     *
     * @param        $secretKey
     * @param string $encryptor MCRYPT_* constant, class name or instance implementing EncryptorInterface
     *
     * @return MCryptEncryptor|string
     */
    public static function build($secretKey, $encryptor = MCRYPT_RIJNDAEL_256)
    {
        if (is_string($encryptor)) {
            if (class_exists($encryptor)) {
                $encryptor = new $encryptor;
            } else {
                $encryptor = new MCryptEncryptor($secretKey, $encryptor);
            }
        }

        if (!($encryptor instanceof EncryptorInterface)) {
            throw new \LogicException('Invalid encryptor, should implements EncryptorInterface.');
        }

        return $encryptor;
    }
}