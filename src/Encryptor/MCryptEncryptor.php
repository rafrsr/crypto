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
 * MCryptEncryptor
 */
class MCryptEncryptor implements EncryptorInterface
{

    /**
     * @var string
     */
    protected $secretKey;

    /**
     * @var string
     */
    protected $algorithm;

    /**
     * @var resource
     */
    protected $module;

    /**
     * {@inheritdoc}
     */
    public function __construct($secretKey, $algorithm = MCRYPT_RIJNDAEL_256)
    {
        $this->algorithm = $algorithm;
        $this->secretKey = $secretKey;
    }

    /**
     * {@inheritdoc}
     */
    public function encrypt($data)
    {
        $this->init();
        $data = trim(base64_encode(mcrypt_generic($this->module, $data)));
        $this->close();

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function decrypt($data)
    {
        $this->init();
        $data = trim(mdecrypt_generic($this->module, base64_decode($data)));
        $this->close();

        return $data;
    }

    public function isEncrypted($data)
    {
        return $data && 0 === strpos(base64_decode($data), '<Crypto>');
    }

    /**
     * init encryption module
     */
    private function init()
    {
        $this->module = mcrypt_module_open($this->algorithm, '', MCRYPT_MODE_ECB, '');

        // Create the IV and determine the keysize length
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($this->module), MCRYPT_RAND);
        $ks = mcrypt_enc_get_key_size($this->module);

        /* Create key */
        $key = substr(md5($this->secretKey), 0, $ks);

        /* Intialize */
        mcrypt_generic_init($this->module, $key, $iv);
    }

    /**
     * Close encryption module
     */
    private function close()
    {
        mcrypt_generic_deinit($this->module);
        mcrypt_module_close($this->module);
    }
}
