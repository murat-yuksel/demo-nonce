<?php
/**
 * Created by PhpStorm.
 * User: murat
 * Date: 07.07.17
 * Time: 21:32
 */

namespace Tests;

use DemoNonce\DemoNonce;
use PHPUnit\Framework\TestCase;

class DemoNonceTest extends TestCase
{
    protected $manager;

    /**
     * DemoNonceTest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $sessionHandler = new MockSessionHandler();
        $this->manager = new DemoNonce($sessionHandler, 300000);
    }

    public function testDemoNonceCreation()
    {
        $this->assertNotEmpty($this->manager);
    }

    public function testGetNonce()
    {
        $this->assertEquals(strlen($this->manager->getNonce(['userId' => 1, 'ip' => '213.31.52.12'])->getToken()), 32);
    }

    public function testNonceAlreadyCreatedEquals()
    {
        $nonce = $this->manager->getNonce(['userId' => 1, 'ip' => '213.31.52.12']);
        $nonce2 = $this->manager->getNonce(['userId' => 1, 'ip' => '213.31.52.12']);
        $this->assertEquals($nonce->getToken(), $nonce2->getToken());
    }

    public function testVerifyNonceWithWrongToken()
    {
        $this->manager->sessionHandler->remove('nonce_demononce');
        $this->manager->sessionHandler->remove('nonce_params');
        $nonce = $this->manager->getNonce(['userId' => 1, 'ip' => '213.31.52.12']);
        $this->assertFalse($this->manager->validateNonce($nonce, md5('try')));
    }

    public function testVerifyNonce()
    {
        $this->manager->sessionHandler->remove('nonce_demononce');
        $this->manager->sessionHandler->remove('nonce_params');
        $nonce = $this->manager->getNonce(['userId' => 1, 'ip' => '213.31.52.12']);
        $token = md5(print_r(
            array_merge(['userId' => 1, 'ip' => '213.31.52.12'],
                ['sessionId' => $this->manager->sessionHandler->getId(),
                    'tick' => $this->manager->getValidTime()]
            ), true));
        $this->assertTrue($this->manager->validateNonce($nonce, $token));
    }

    public function testVerifyNonceWithExceedingTime()
    {
        $this->manager->sessionHandler->remove('nonce_demononce');
        $this->manager->sessionHandler->remove('nonce_params');
        $this->manager = new DemoNonce($this->manager->sessionHandler, -10);
        $nonce = $this->manager->getNonce(['userId' => 1, 'ip' => '213.31.52.12']);
        $token = md5(print_r(
            array_merge(['userId' => 1, 'ip' => '213.31.52.12'],
                ['sessionId' => $this->manager->sessionHandler->getId(),
                    'tick' => $this->manager->getValidTime()]
            ), true));
        $this->assertFalse($this->manager->validateNonce($nonce, $token));
    }

}
