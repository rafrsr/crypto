<?php

/**
 * This file is part of the Crypto package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\Crypto\Tests;

use Rafrsr\Crypto\Crypto;
use Rafrsr\Crypto\Encryptor\Base64Encryptor;
use Rafrsr\Crypto\Encryptor\MCryptEncryptor;

class CryptoTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $this->assertInstanceOf(MCryptEncryptor::class, Crypto::build('1234', MCRYPT_RIJNDAEL_256));
        $this->assertInstanceOf(Base64Encryptor::class, Crypto::build('1234', Base64Encryptor::class));
    }
}
