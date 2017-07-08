<?php
/**
 * Created by PhpStorm.
 * User: murat
 * Date: 07.07.17
 * Time: 20:48
 */

namespace DemoNonce;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DemoNonce
{
    protected $validTime;
    public $sessionHandler;

    /**
     * DemoNonce constructor.
     * @param int $validTime
     * @param SessionInterface $sessionHandler
     */
    public function __construct($sessionHandler, $validTime = 300000)
    {
        $this->sessionHandler = $sessionHandler;
        $this->validTime = $validTime;
    }

    /**
     * @param array $params
     * @return Nonce
     */
    public function getNonce(array $params = []): Nonce
    {
        if ($this->sessionHandler->has('nonce_demononce')) {
            return $this->sessionHandler->get('nonce_demononce');
        }
        return $this->createNonce($params);
    }

    public function getValidTime(): int
    {
        return $this->validTime;
    }

    /**
     * @param Nonce $nonce
     * @param string $token
     * @return bool
     */
    public function validateNonce(Nonce $nonce, $token): bool
    {
        return $nonce->verify($token, $this->sessionHandler->get('nonce_params'));
    }

    /**
     * @param array $params
     * @return Nonce
     */
    protected function createNonce(array $params = []): Nonce
    {
        $nonce = new Nonce($this->validTime, array_merge($params, ['sessionId' => $this->sessionHandler->getId(), 'tick' => $this->validTime]));
        $this->sessionHandler->set('nonce_params', array_merge($params, ['sessionId' => $this->sessionHandler->getId(), 'tick' => $this->validTime]));
        $this->sessionHandler->set('nonce_demononce', $nonce);
        return $nonce;
    }
}