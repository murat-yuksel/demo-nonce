<?php
/**
 * Created by PhpStorm.
 * User: murat
 * Date: 07.07.17
 * Time: 21:27
 */

namespace Tests;

use DemoNonce\Nonce;
use PHPUnit\Framework\TestCase;

class NonceTest extends TestCase
{

    public function testNonceCreation() {
        $this->assertNotEmpty(new Nonce());
    }

}