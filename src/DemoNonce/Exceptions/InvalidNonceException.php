<?php
/**
 * Created by PhpStorm.
 * User: murat
 * Date: 07.07.17
 * Time: 20:50
 */

namespace DemoNonce\Exceptions;


use Exception;

class InvalidNonceException extends Exception
{

    /**
     * Constructor.
     *
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($code = 0, Exception $previous = null)
    {
        parent::__construct('Provided nonce is not valid.', $code, $previous);
    }
}