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

/**
 * EncryptorRegistry interface for encryptor
 */
interface EncryptorInterface
{

    /**
     * Name of the encryptor
     *
     * @return string
     */
    public function getName();

    /**
     * @param string $data Plain text to encrypt
     *
     * @return string Encrypted text
     */
    public function encrypt($data);

    /**
     * @param string $data Encrypted text
     *
     * @return string Plain text
     */
    public function decrypt($data);

    /**
     * Verify if the data is already encrypted
     *
     * @param string $data
     *
     * @return mixed
     */
    public function isEncrypted($data);
}
