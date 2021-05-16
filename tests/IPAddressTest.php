<?php

namespace Acamposm\Ping\Tests;

use Acamposm\Ping\IPAddress;
use Exception;

class IPAddressTest extends TestCase
{
    public const HOST_IP_ADDRESS = '127.0.0.1';
    public const HOST_LINK_LOCAL = 'fe80::6c42:407d:af01:9567';

    /**
     * @test
     */
    public function require_IP_address()
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
    public function can_validate_IPv4_addresses()
    {
        $this->assertTrue(IPAddress::Validate(IPAddressTest::HOST_IP_ADDRESS));
    }

    /**
     * @test
     */
    public function can_detect_invalid_IPv4_addresses()
    {
        $invalid_ip_address = IPAddressTest::HOST_IP_ADDRESS.'.4';

        $this->assertNotTrue(IPAddress::Validate($invalid_ip_address));
    }

    /**
     * @test
     */
    public function can_validate_IPv6_addresses()
    {
        $this->assertTrue(IPAddress::Validate(IPAddressTest::HOST_LINK_LOCAL));
    }

    /**
     * @test
     */
    public function can_detect_invalid_IPv6_addresses()
    {
        $invalid_ip_address = IPAddressTest::HOST_LINK_LOCAL.'::0';

        $this->assertNotTrue(IPAddress::Validate($invalid_ip_address));
    }
}
