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

    public function testDemoNonceCreation() {
        $this->assertNotEmpty(new DemoNonce());
    }

}
