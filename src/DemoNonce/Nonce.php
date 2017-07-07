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
     */
    public function __construct($tick = 3600)
    {
        $this->token = bin2hex(random_bytes(16));
        $this->tick = (int)$tick;
        $this->createdAt = time();
    }

}