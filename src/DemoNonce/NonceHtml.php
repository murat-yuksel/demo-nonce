<?php
/**
 * Created by PhpStorm.
 * User: murat
 * Date: 07.07.17
 * Time: 23:25
 */

namespace DemoNonce;

use DemoNonce\Exceptions\InvalidNonceException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class NonceHtml
 * Html builder functions for given nonce
 * @package DemoNonce
 */
class NonceHtml
{
    protected $demoNonce;

    /**
     * @return string
     */
    public static function getMetaTagNonce(): string
    {
        $request = Request::createFromGlobals();
        $session = $request->getSession();
        $session->clear();
        return '<meta name="_nonce" id="_nonce" content"'
            . (new DemoNonce(new Session()))->getNonce(['ip' => $request->getClientIp()])->getToken() . '">';
    }

    /**
     * @return string
     */
    public static function getHiddenInput(): string
    {
        $request = Request::createFromGlobals();
        return '<input type="hidden" id="_nonce" name="_nonce" value="'
            . (new DemoNonce(new Session()))->getNonce(['ip' => $request->getClientIp()])->getToken() . '">';
    }

    /**
     * @param $url
     * @return string
     */
    public static function getNonceUrl($url): string
    {
        $request = Request::createFromGlobals();
        $demoNonce = new DemoNonce(new Session());
        return strpos($url, '?') ?
            $url . '&_nonce=' . $demoNonce->getNonce(['ip' => $request->getClientIp()])->getToken() :
            $url . '?_nonce=' . $demoNonce->getNonce(['ip' => $request->getClientIp()])->getToken();
    }

    /**
     * @return bool
     * @throws InvalidNonceException
     */
    public static function validate(): bool
    {
        $request = Request::createFromGlobals();
        echo $request->get('_nonce');
        $demoNonce = new DemoNonce(new Session());
        if(false === $demoNonce->validateNonce($demoNonce->getNonce(['ip' => $request->getClientIp()]), $request->get('_nonce'))) {
            throw new InvalidNonceException();
        }
        return true;
    }

}