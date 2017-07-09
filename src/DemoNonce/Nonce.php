<?php
/**
 * Created by PhpStorm.
 * User: murat
 * Date: 07.07.17
 * Time: 21:09
 */

namespace DemoNonce;


class Nonce
{
    protected $token;

    protected $tick;

    protected $createdAt;

    /**
     * Nonce constructor.
     * @param int $tick
     * @param array $params
     */
    public function __construct($tick = 300, array $params = [])
    {
        $this->token = md5(print_r($params, true));
        $this->tick = (int)$tick;
        $this->createdAt = time();
    }

    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @param array $params
     * @return bool
     */
    public function verify($token, array $params = []): bool
    {
        if (time() > $this->tick + $this->createdAt) {
            return false;
        }
        if($token !== $this->getToken()) {
            return false;
        }
        if($this->token !== md5(print_r($params, true))) {
            return false;
        }

        return true;
    }

}