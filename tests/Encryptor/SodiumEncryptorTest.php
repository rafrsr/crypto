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

use Rafrsr\Crypto\Encryptor\SodiumEncryptor;

class SodiumEncryptorTest extends \PHPUnit_Framework_TestCase
{
    public function testEncryption()
    {
        $encryptor = new SodiumEncryptor('12345678901234567890123456');

        $message = 'This is a secret message';
        $encrypted = $encryptor->encrypt($message);
        $this->assertNotEquals($message, $encrypted);

        $decrypted = $encryptor->decrypt($encrypted);
        $this->assertEquals($message, $decrypted);
    }
}
