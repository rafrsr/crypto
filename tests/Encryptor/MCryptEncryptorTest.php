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

use Rafrsr\Crypto\Encryptor\MCryptEncryptor;

class MCryptEncryptorTest extends \PHPUnit_Framework_TestCase
{

    public function testEncryption()
    {
        $algorithms = [
            MCRYPT_3DES,
            MCRYPT_BLOWFISH,
            MCRYPT_BLOWFISH_COMPAT,
            MCRYPT_RIJNDAEL_256,
            MCRYPT_RIJNDAEL_192,
            MCRYPT_RIJNDAEL_128
        ];
        foreach ($algorithms as $algorithm) {
            $encryptor = new MCryptEncryptor('12345678901234567890123456', $algorithm);

            $message = 'This is a secret message';
            $encrypted = $encryptor->encrypt($message);
            $this->assertNotEquals($message, $encrypted);

            $decrypted = $encryptor->decrypt($encrypted);
            $this->assertEquals($message, $decrypted);
        }
    }
}
