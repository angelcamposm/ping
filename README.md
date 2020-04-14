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
	- [Sample output](#sample-output)
- [Testing](#testing)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Security](#security)
- [Credits](#credits)
- [License](#license)
- [Laravel Package Boilerplate](#laravel-package-boilerplate)

## Installation

You can install the package via [composer](https://getcomposer.org/):

```bash
composer require acamposm/ping
```

***Note:*** I follow [semver](https://semver.org/) for the releases.

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

## Sample output

Here you can see a sample of an exit of the command.

### Sample output on Linux based servers

``` php
// Sample output from Linux based server
$ping = Ping::Create('192.168.1.1')->Run();

dd($ping);
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

### Sample output on Windows based servers.

``` php
// Sample output from Windows Based Server
$ping = Ping::Create('192.168.1.1')->Run();

dd($ping);
{#251 ▼
  +"latency": 0.001
  +"round_trip_time": array:3 [▼
    "avg" => 0.001
    "min" => 0.001
    "max" => 0.001
  ]
  +"sequence": array:4 [▼
    0 => "Respuesta desde 192.168.1.1: bytes=64 tiempo=1ms TTL=63"
    1 => "Respuesta desde 192.168.1.1: bytes=64 tiempo=1ms TTL=63"
    2 => "Respuesta desde 192.168.1.1: bytes=64 tiempo=1ms TTL=63"
    3 => "Respuesta desde 192.168.1.1: bytes=64 tiempo=1ms TTL=63"
  ]
  +"statistics": array:3 [▼
    "packets_transmitted" => 4
    "packets_received" => 4
    "packet_loss" => 0
  ]
  +"raw": array:12 [▼
    0 => ""
    1 => "Haciendo ping a 192.168.1.1 con 64 bytes de datos:"
    2 => "Respuesta desde 192.168.1.1: bytes=64 tiempo=1ms TTL=63"
    3 => "Respuesta desde 192.168.1.1: bytes=64 tiempo=1ms TTL=63"
    4 => "Respuesta desde 192.168.1.1: bytes=64 tiempo=1ms TTL=63"
    5 => "Respuesta desde 192.168.1.1: bytes=64 tiempo=1ms TTL=63"
    6 => ""
    7 => b"Estad¡sticas de ping para 192.168.1.1:"
    8 => "    Paquetes: enviados = 4, recibidos = 4, perdidos = 0"
    9 => "    (0% perdidos),"
    10 => "Tiempos aproximados de ida y vuelta en milisegundos:"
    11 => b"    M¡nimo = 1ms, M ximo = 1ms, Media = 1ms"
  ]
  +"options": array:6 [▼
    "count" => 4
    "interval" => 1
    "packet_size" => 64
    "target_ip" => "192.168.1.1"
    "timeout" => 5
    "time_to_live" => 128
  ]
  +"time_taken": array:3 [▼
    "start" => "13-04-2020 11:49:38.765600"
    "stop" => "13-04-2020 11:49:41.822600"
    "time" => 3.0569541454315
  ]
}
```

### Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

# Contributing

Thank you for considering to contribute to the improvement of the package. Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

If you discover any security related issues, please send an e-mail to Angel Campos via angel.campos.m@outlook.com instead of using the issue tracker. All security vulnerabilities will be promptly addressed.

## Credits

- [Angel Campos](https://github.com/acamposm)
- [All Contributors](../../contributors)

## License

The package Ping is open-source package and is licensed under The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).