<?php

/**
 * This file is part of the Crypto package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\Crypto\Exception;

/**
 * Class AlgorithmNotSupportedException
 */
class AlgorithmNotSupportedException extends \Exception
{
    protected $message = 'Given algorithm is not supported';
}