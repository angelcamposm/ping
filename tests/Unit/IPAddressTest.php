<?php

namespace Acamposm\Ping\Tests\Unit;

use Acamposm\Ping\IPAddress;
use Acamposm\Ping\Tests\TestCase;
use Exception;

class IPAddressTest extends TestCase
{
    public const HOST_IP_ADDRESS = '127.0.0.1';
    public const HOST_LINK_LOCAL = 'fe80::6c42:407d:af01:9567';

    public string $invalidIPv4Address;
    public string $invalidIPv6Address;

    public function setUp(): void
    {
        $this->invalidIPv4Address = self::HOST_IP_ADDRESS.'.4';
        $this->invalidIPv6Address = self::HOST_LINK_LOCAL.'::0';
    }

    /**
     * @test
     */
    public function require_IP_address()
    {
        $this->expectException(Exception::class);

        IPAddress::Validate();
    }

    /**
     * @test
     *
     * @throws \acamposm\Ping\Exceptions\InvalidIPAddressException
     */
    public function can_validate_IPv4_addresses()
    {
        $this->assertTrue(IPAddress::Validate(self::HOST_IP_ADDRESS));
    }

    /**
     * @test
     *
     * @throws \acamposm\Ping\Exceptions\InvalidIPAddressException
     */
    public function can_detect_invalid_IPv4_addresses()
    {
        $this->assertNotTrue(IPAddress::Validate($this->invalidIPv4Address));
    }

    /**
     * @test
     *
     * @throws \acamposm\Ping\Exceptions\InvalidIPAddressException
     */
    public function can_validate_IPv6_addresses()
    {
        $this->assertTrue(IPAddress::Validate(self::HOST_LINK_LOCAL));
    }

    /**
     * @test
     *
     * @throws \acamposm\Ping\Exceptions\InvalidIPAddressException
     */
    public function can_detect_invalid_IPv6_addresses()
    {
        $this->assertNotTrue(IPAddress::Validate($this->invalidIPv6Address));
    }
}
