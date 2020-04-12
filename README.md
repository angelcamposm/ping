# PING for Laravel

[![License](https://poser.pugx.org/acamposm/ping/license?format=flat-square)](https://packagist.org/packages/acamposm/ping)
[![Latest Stable Version](https://poser.pugx.org/acamposm/ping/v/stable?format=flat-square)](https://packagist.org/packages/acamposm/ping)
[![Latest Unstable Version](https://poser.pugx.org/acamposm/ping/v/unstable?format=flat-square)](https://packagist.org/packages/acamposm/ping)
[![StyleCI](https://github.styleci.io/repos/255138468/shield?branch=master)](https://github.styleci.io/repos/255138468)
[![Total Downloads](https://poser.pugx.org/acamposm/ping/downloads?format=flat-square)](https://packagist.org/packages/acamposm/ping)

This ping class allow to make ping request from Laravel aplications, it is based on PING command from the linux iputils package.

ping uses the ICMP protocol's mandatory ECHO_REQUEST datagram to elicit an ICMP ECHO_RESPONSE from a host or gateway. ECHO_REQUEST datagrams (pings) have an IP and ICMP header, followed by a struct timeval and then an arbitrary number ofpadbytes used to fill out the packet.

At this moment, only IPv4 is supported but i plan to add IPv6 support to this package.

- [Installation](#installation)
- [Usage](#usage)
	- [Change Count](#change-count)
	- [Change Interval](#change-interval)
	- [Change Packet Size](#change-packet-size)
	- [Change Timeout](#change-timeout)
	- [Change Time To Live](#change-time-to-live)
- [Testing](#testing)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Security](#security)
- [Credits](#credits)
- [License](#license)
- [Laravel Package Boilerplate](#laravel-package-boilerplate)

## Installation

You can install the package via composer:

```bash
composer require acamposm/ping
```

## Usage

For basic usage you only need to create with an ip address as a first argument and run...

``` php
// Basic usage with options by default 
$ping = Ping::Create('192.168.1.1')->Run();
```

### Change Count

Stop after sending count ECHO_REQUEST packets. With deadline option, ping waits for count ECHO_REPLY packets, until the timeout expires.

``` php
// Change the number of packets to send to 10
$ping = Ping::Create('192.168.1.1')->Count(10)->Run();
```

### Change Interval

Wait interval seconds between sending each packet. The default is to wait for one second between each packet normally, or not to wait in flood mode. Only super-user may set interval to values less than 0.2 seconds.

``` php
// Change interval to 0.5 seconds between each packet
$ping = Ping::Create('192.168.1.1')->Interval(0.5)->Run();
```

### Change Packet Size

Specifies the number of data bytes to be sent. The default is 56, which translates into 64 ICMP data bytes when combined with the 8 bytes of ICMP header data.

``` php
// Change packet size to 128
$ping = Ping::Create('192.168.1.1')->PacketSize(128)->Run();
```

### Change Timeout

Time to wait for a response, in seconds. The option affects only timeout in absence of any responses, otherwise ping waits for two RTTs.

``` php
// Change timeout to 10 seconds
$ping = Ping::Create('192.168.1.1')->Timeout(10)->Run();
```

### Change Time To Live

ping only. Set the IP Time to Live.

``` php
// Change Time To Live to 128
$ping = Ping::Create('192.168.1.1')->TimeToLive(128)->Run();
```

## Sample response

Here you can see a sample of an exit of the command.

``` php
// Ping to our gateway
$ping = Ping::Create('192.168.1.1')->Run();
var_dump($ping);
=> {#1586
    +"latency": 37.464,
    +"round_trip_time": [
		"min" => 36.988,
		"avg" => 37.464,
		"max" => 38.19,
		"mdev" => 0.304,
	],
	+"sequence": [
		2 => 37.4,
		3 => 37.4,
		4 => 37.4,
		5 => 37.4,
		6 => 37.6,
		7 => 38.2,
		8 => 37.4,
		9 => 37.6,
		10 => 37.6,
		12 => 37.3,
		13 => 36.1,
    ],
    +"statistics": [
		"packets_transmitted" => 13,
		"packets_received" => 11,
		"packet_loss" => 15.3846,
		"time" => 93,
    ],
    +"raw": [
		"PING www.witigos.es (217.160.0.129) 128(156) bytes of data.",
		"36 bytes from 217.160.0.129: icmp_seq=2 ttl=53 time=37.4 ms",
		"36 bytes from 217.160.0.129: icmp_seq=3 ttl=53 time=37.4 ms",
		"36 bytes from 217.160.0.129: icmp_seq=4 ttl=53 time=37.4 ms",
		"36 bytes from 217.160.0.129: icmp_seq=5 ttl=53 time=37.4 ms",
		"36 bytes from 217.160.0.129: icmp_seq=6 ttl=53 time=37.6 ms",
		"36 bytes from 217.160.0.129: icmp_seq=7 ttl=53 time=38.2 ms",
		"36 bytes from 217.160.0.129: icmp_seq=8 ttl=53 time=37.4 ms",
		"36 bytes from 217.160.0.129: icmp_seq=9 ttl=53 time=37.6 ms",
		"36 bytes from 217.160.0.129: icmp_seq=10 ttl=53 time=37.6 ms",
		"36 bytes from 217.160.0.129: icmp_seq=12 ttl=53 time=37.3 ms",
		"36 bytes from 217.160.0.129: icmp_seq=13 ttl=53 time=36.10 ms",
		"",
		"-- www.witigos.es ping statistics ---",
		"13 packets transmitted, 11 received, 15.3846% packet loss, time 93ms",
		"rtt min/avg/max/mdev = 36.988/37.464/38.190/0.304 ms",
    ],
    +"options": {#1587
		+"count": 13,
		+"interval": 1,
		+"packet_size": 128,
		+"timeout": 5,
		+"time_to_live": 128,
    },
    +"time_taken": [
		"start" => "12-04-2020 16:52:54.387000",
		"stop" => "12-04-2020 16:52:54.387000",
		"time" => 1.1920928955078E-5,
	],
}
```

### Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

# Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email angel.campos.m@outlook.com instead of using the issue tracker.

## Credits

- [Angel Campos](https://github.com/acamposm)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).