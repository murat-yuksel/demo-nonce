<?php
/**
 * Created by PhpStorm.
 * User: murat
 * Date: 07.07.17
 * Time: 23:25
 */

namespace DemoNonce;

/**
 * Class NonceHtml
 * Html builder functions for given nonce
 * @package DemoNonce
 */
class NonceHtml
{
    protected $demoNonce;

    /**
     * NonceHtml constructor.
     * @param $sessionHandler
     */
    public function __construct($sessionHandler)
    {
        $this->demoNonce = new DemoNonce($sessionHandler);
    }

    public function getMetaTagNonce(): string
    {
        return '<meta name="_nonce" id="_nonce" content"' . $this->demoNonce->getNonce()->getToken() . '">';
    }

    public function getHiddenInput(): string
    {
        return '<input type="hidden" id="_nonce" name="_nonce" value="' . $this->demoNonce->getNonce()->getToken() . '">';
    }

    public function getNonceUrl($url): string
    {
        return strpos($url, '?') ?
            $url . '&_nonce=' . $this->demoNonce->getNonce()->getToken() :
            $url . '?_nonce=' . $this->demoNonce->getNonce()->getToken();
    }


}