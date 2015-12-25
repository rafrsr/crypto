<?php

/**
 * This file is part of the Crypto package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\Crypto\Tests\Encryptor;

use Rafrsr\Crypto\Encryptor\Base64Encryptor;

class Base64EncryptorTest extends \PHPUnit_Framework_TestCase
{
    public function testEncryption()
    {

        $encryptor = new Base64Encryptor();

        $message = 'This is a secret message';
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
