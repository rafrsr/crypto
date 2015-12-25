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
use Rafrsr\Crypto\EncryptorInterface;

class CryptoTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $message = 'This is a secret message';
        $encryptor = Crypto::build('1234', MCRYPT_RIJNDAEL_256);

        $encrypted = $encryptor->encrypt($message);
        $this->assertNotEquals($message, $encrypted);

        //avoid double encryption
        $this->assertEquals($encrypted, $encryptor->encrypt($encrypted));

        $this->assertTrue($encryptor->isEncrypted($encrypted));

        $decrypted = $encryptor->decrypt($encrypted);
        $this->assertEquals($message, $decrypted);

        //avoid double decryption
        $this->assertEquals($decrypted, $encryptor->decrypt($decrypted));

        $this->assertFalse($encryptor->isEncrypted($decrypted));

        //avoid encrypt/decrypt empty string
        $this->assertEquals(null, $encryptor->encrypt(null));
        $this->assertEquals('', $encryptor->encrypt(''));
        $this->assertEquals(null, $encryptor->decrypt(null));
        $this->assertEquals('', $encryptor->decrypt(''));
    }

    public function testBuildCustomEncryptor()
    {
        $message = 'This is a secret message';
        $encryptor = Crypto::build('1234', 'Rafrsr\Crypto\Tests\CustomEncryptor');

        $encrypted = $encryptor->encrypt($message);
        $this->assertNotEquals($message, $encrypted);

        //avoid double encryption
        $this->assertEquals($encrypted, $encryptor->encrypt($encrypted));

        $this->assertTrue($encryptor->isEncrypted($encrypted));

        $decrypted = $encryptor->decrypt($encrypted);
        $this->assertEquals($message, $decrypted);

        //avoid double decryption
        $this->assertEquals($decrypted, $encryptor->decrypt($decrypted));

        $this->assertFalse($encryptor->isEncrypted($decrypted));
    }
}

class CustomEncryptor implements EncryptorInterface
{
    /**
     * @inheritDoc
     */
    public function encrypt($data)
    {
       return base64_encode($data);
    }

    /**
     * @inheritDoc
     */
    public function decrypt($data)
    {
        return base64_decode($data);
    }
}
