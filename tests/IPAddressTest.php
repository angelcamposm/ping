<?php

namespace Acamposm\Ping\Tests;

use Acamposm\Ping\IPAddress;
use \Exception;

class IPAddressTest extends TestCase
{
    const HOST_IP_ADDRESS = '127.0.0.1';
    const HOST_LINK_LOCAL = 'fe80::6c42:407d:af01:9567';

    /**
     * @test
     */
    public function requireIPAddress()
    {
        try {
            IPAddress::Validate();
        } catch (Exception $e) {
            $this->assertInstanceOf(Exception::class, $e);
        }
    }

    /**
     * @test
     */
    public function canValidateIPAddresses()
    {
        $this->assertTrue(IPAddress::Validate(IPAddressTest::HOST_IP_ADDRESS));
    }

    /**
     * @test
     */
    public function canDetectInvalidIPv4Addresses()
    {
        $invalid_ip_address = IPAddressTest::HOST_IP_ADDRESS . '.4';

        $this->assertNotTrue(IPAddress::Validate($invalid_ip_address));
    }

    /**
     * @test
     */
    public function canValidateIPv6Addresses()
    {
        $this->assertTrue(IPAddress::Validate(IPAddressTest::HOST_LINK_LOCAL));
    }

    /**
     * @test
     */
    public function canDetectInvalidIPv6Addresses()
    {
        $invalid_ip_address = IPAddressTest::HOST_LINK_LOCAL . '::0';

        $this->assertNotTrue(IPAddress::Validate($invalid_ip_address));
    }
}
