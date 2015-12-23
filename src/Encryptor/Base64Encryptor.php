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

/**
 * Class Base64Encryptor
 */
final class Base64Encryptor implements EncryptorInterface
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'base64';
    }

    /**
     * @inheritDoc
     */
    public function setSecretKey($secretKey)
    {
        // not required
    }

    /**
     * @inheritDoc
     */
    public function encrypt($data)
    {
        if (!$this->isEncrypted($data)) {
            return base64_encode("<Crypto>" . $data);
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function decrypt($data)
    {
        if ($this->isEncrypted($data)) {
            return substr(base64_decode($data), 8);
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function isEncrypted($data)
    {
        if (substr(base64_decode($data), 0, 8) == '<Crypto>') {
            return true;
        }

        return false;
    }
}