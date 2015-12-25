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
     * Create a build in encryptor using given algorithm
     * for now support all most used MCRYPT_* algorithms
     *
     * @param string $secretKey Secret key used for encryption/decryption
     * @param string $algorithm one of MCRYPT_* constants
     *
     * @return MCryptEncryptor|string
     */
    public static function build($secretKey, $algorithm = MCRYPT_RIJNDAEL_256)
    {
        $algorithm = new MCryptEncryptor($secretKey, $algorithm);

        return $algorithm;
    }
}