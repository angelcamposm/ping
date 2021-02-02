# PING for Laravel

[![License](https://poser.pugx.org/acamposm/ping/license)](https://packagist.org/packages/acamposm/ping)
[![Latest Stable Version](https://poser.pugx.org/acamposm/ping/v/stable)](https://packagist.org/packages/acamposm/ping)
[![Latest Unstable Version](https://poser.pugx.org/acamposm/ping/v/unstable)](https://packagist.org/packages/acamposm/ping)
[![Build Status](https://travis-ci.com/angelcamposm/ping.svg?branch=master)](https://travis-ci.com/angelcamposm/ping)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/angelcamposm/ping/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/angelcamposm/ping/?branch=master)
[![StyleCI](https://github.styleci.io/repos/255138468/shield?branch=master)](https://github.styleci.io/repos/255138468)
[![Total Downloads](https://poser.pugx.org/acamposm/ping/downloads)](https://packagist.org/packages/acamposm/ping)

This ping class allow making ping request from Laravel applications, it is based on PING command from the linux iputils package.

ping uses the ICMP protocol's mandatory ECHO_REQUEST datagram to elicit an ICMP ECHO_RESPONSE from a host or gateway. ECHO_REQUEST datagrams (pings) have an IP and ICMP header, followed by a struct timeval and then an arbitrary number ofpadbytes used to fill out the packet.

- [Installation](#installation)
- [Usage](#usage)
	- [Change Count](#change-count)
	- [Change Interval](#change-interval)
	- [Change Packet Size](#change-packet-size)
	- [Change Timeout](#change-timeout)
	- [Change Time To Live](#change-time-to-live)
- [Sample output](#sample-outputs)
- [Testing](#testing)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Security](#security-vulnerabilities)
- [Credits](#credits)
- [License](#license)
- [Laravel Package Boilerplate](#laravel-package-boilerplate)

## Installation

You can install the package via [composer](https://getcomposer.org/) and then publish the assets:

Prior to Ping 2.1.0 version you can install with:

```bash

composer require acamposm/ping

php artisan vendor:publish --provider="Acamposm\Ping\PingServiceProvider"

```

From Ping 2.1.0 version you can install with:

```bash

composer require acamposm/ping

php artisan ping:install

```

***Note:*** We try to follow [SemVer v2.0.0](https://semver.org/).

## Usage

For basic usage you only need to create with an ip address as a first argument and run...

```php

use Acamposm\Ping\Ping;
use Acamposm\Ping\PingCommandBuilder;

// Create an instance of PingCommand
$command = (new PingCommandBuilder('192.168.1.1'));

// Pass the PingCommand instance to Ping and run...
$ping = (new Ping($command))->run();

```

### Change Count

Stop after sending count ECHO_REQUEST packets. With deadline option, ping waits for count ECHO_REPLY packets, until the timeout expires.

```php

use Acamposm\Ping\Ping;
use Acamposm\Ping\PingCommandBuilder;

// Change the number of packets to send to 10
$command = (new PingCommandBuilder('192.168.1.1'))->count(10);

$ping = (new Ping($command))->run();

```

### Change Interval

Wait interval seconds between sending each packet. The default is to wait for one second between each packet normally, or not to wait in flood mode. Only super-user may set interval to values less than 0.2 seconds.

```php

use Acamposm\Ping\Ping;
use Acamposm\Ping\PingCommandBuilder;

// Change interval to 0.5 seconds between each packet
$command = (new PingCommandBuilder('192.168.1.1'))->interval(0.5);

$ping = (new Ping($command))->run();

```

### Change Packet Size

Specifies the number of data bytes to be sent. The default is 56, which translates into 64 ICMP data bytes when combined with the 8 bytes of ICMP header data.

```php

use Acamposm\Ping\Ping;
use Acamposm\Ping\PingCommandBuilder;

// Change packet size to 128
$command = (new PingCommandBuilder('192.168.1.1'))->packetSize(128);

$ping = (new Ping($command))->run();

```

### Change Timeout

Time to wait for a response, in seconds. The option affects only timeout in absence of any responses, otherwise ping waits for two RTTs.

```php

use Acamposm\Ping\Ping;
use Acamposm\Ping\PingCommandBuilder;

// Change timeout to 10 seconds
$command = (new PingCommandBuilder('192.168.1.1'))->timeout(10);

$ping = (new Ping($command))->run();

```

### Change Time To Live

ping only. Set the IP Time to Live.

```php

use Acamposm\Ping\Ping;
use Acamposm\Ping\PingCommandBuilder;

// Change Time To Live to 128
$command = (new PingCommandBuilder('192.168.1.1'))->ttl(128);

$ping = (new Ping($command))->run();

```

## Sample outputs

Here you can see three output samples of the ping command...
- The first with domain.
- The second with an IPv4 Address
- The third with an IPv6 Address

### Sample output on Windows based server to https://google.com

```php

use Acamposm\Ping\Ping;
use Acamposm\Ping\PingCommandBuilder;

$command = (new PingCommandBuilder('https://google.com'))->count(10)->packetSize(200)->ttl(128);

// Sample output from Windows based server
$ping = (new Ping($command))->run();

dd($ping);
```
```
=> {#613
    +"host_status": "Ok",
    +"raw": [
        "",
        "Haciendo ping a google.com [216.58.213.142] con 200 bytes de datos:",
        "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=36ms TTL=115",
        "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=36ms TTL=115",
        "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=36ms TTL=115",
        "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=37ms TTL=115",
        "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=37ms TTL=115",
        "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=36ms TTL=115",
        "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=36ms TTL=115",
        "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=36ms TTL=115",
        "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=36ms TTL=115",
        "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=36ms TTL=115",
        "",
        "Estadísticas de ping para 216.58.213.142:",
        "    Paquetes: enviados = 10, recibidos = 10, perdidos = 0",
        "    (0% perdidos),",
        "Tiempos aproximados de ida y vuelta en milisegundos:",
        "    Mínimo = 36ms, Máximo = 37ms, Media = 36ms",
    ],
    +"latency": 0.036,
    +"rtt": {#616
        +"avg": 0.036,
        +"min": 0.036,
        +"max": 0.037,
    },
    +"sequence": {#615
        +"0": "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=36ms TTL=115",
        +"1": "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=36ms TTL=115",
        +"2": "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=36ms TTL=115",
        +"3": "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=37ms TTL=115",
        +"4": "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=37ms TTL=115",
        +"5": "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=36ms TTL=115",
        +"6": "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=36ms TTL=115",
        +"7": "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=36ms TTL=115",
        +"8": "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=36ms TTL=115",
        +"9": "Respuesta desde 216.58.213.142: bytes=68 (enviados 200) tiempo=36ms TTL=115",
    },
    +"statistics": {#614
        +"packets_transmitted": 10,
        +"packets_received": 10,
        +"packets_lost": 0,
        +"packet_loss": 0,
    },
    +"options": {#598
        +"host": "google.com",
        +"count": 10,
        +"packet_size": 200,
        +"ttl": 120,
    },
    +"time": {#610
        +"start": {#612
            +"as_float": 1596984650.5006,
            +"human_readable": "09-08-2020 14:50:50.500600",
        },
        +"stop": {#611
            +"as_float": 1596984659.5802,
            +"human_readable": "09-08-2020 14:50:59.580200",
        },
        +"time": 9.08,
    },
}

```

### Sample output from Windows based server to local gateway IPv4

```php

use Acamposm\Ping\Ping;
use Acamposm\Ping\PingCommandBuilder;

$command = (new PingCommandBuilder('192.168.10.254'))->count(10)->packetSize(200)->ttl(120);

$ping = (new Ping($command))->run();

dd($ping);
```
```
=> {#615
    +"host_status": "Ok",
    +"raw": [
        "",
        "Haciendo ping a 192.168.10.254 con 200 bytes de datos:",
        "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
        "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
        "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
        "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
        "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
        "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
        "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
        "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
        "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
        "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
        "",
        "Estadísticas de ping para 192.168.10.254:",
        "    Paquetes: enviados = 10, recibidos = 10, perdidos = 0",
        "    (0% perdidos),",
        "Tiempos aproximados de ida y vuelta en milisegundos:",
        "    Mínimo = 0ms, Máximo = 0ms, Media = 0ms",
    ],
    +"latency": 0.0,
    +"rtt": {#618
        +"avg": 0.0,
        +"min": 0.0,
        +"max": 0.0,
    },
    +"sequence": {#598
        +"0": "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
        +"1": "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
        +"2": "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
        +"3": "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
        +"4": "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
        +"5": "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
        +"6": "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
        +"7": "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
        +"8": "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
        +"9": "Respuesta desde 192.168.10.254: bytes=200 tiempo<1m TTL=255",
    },
    +"statistics": {#616
        +"packets_transmitted": 10,
        +"packets_received": 10,
        +"packets_lost": 0,
        +"packet_loss": 0,
    },
    +"options": {#619
        +"host": "192.168.10.254",
        +"count": 10,
        +"packet_size": 200,
        +"ttl": 120,
        +"version": 4,
    },
    +"time": {#612
    +"start": {#614
        +"as_float": 1596985359.7592,
        +"human_readable": "09-08-2020 15:02:39.759200",
    },
    +"stop": {#613
        +"as_float": 1596985368.7952,
        +"human_readable": "09-08-2020 15:02:48.795200",
    },
    +"time": 9.036,
    },
}
```

#### Sample output from Windows based server to link local IPv6 address

```php

use Acamposm\Ping\Ping;
use Acamposm\Ping\PingCommandBuilder;

$command = (new PingCommandBuilder('fe80::6c42:407d:af01:9567'))->count(10)->packetSize(200)->ttl(120);

$ping = (new Ping($command))->run();

dd($ping);
```
```
=> {#615
    +"host_status": "Ok",
    +"raw": [
        "",
        "Haciendo ping a fe80::6c42:407d:af01:9567 con 200 bytes de datos:",
        "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
        "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
        "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
        "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
        "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
        "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
        "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
        "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
        "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
        "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
        "",
        b"Estadísticas de ping para fe80::6c42:407d:af01:9567:",
        "    Paquetes: enviados = 10, recibidos = 10, perdidos = 0",
        "    (0% perdidos),",
        "Tiempos aproximados de ida y vuelta en milisegundos:",
        b"    Mínimo = 0ms, Máximo = 0ms, Media = 0ms",
    ],
    +"latency": 0.0,
    +"rtt": {#618
        +"avg": 0.0,
        +"min": 0.0,
        +"max": 0.0,
    },
    +"sequence": {#598
        +"0": "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
        +"1": "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
        +"2": "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
        +"3": "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
        +"4": "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
        +"5": "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
        +"6": "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
        +"7": "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
        +"8": "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
        +"9": "Respuesta desde fe80::6c42:407d:af01:9567: tiempo<1m",
    },
    +"statistics": {#616
        +"packets_transmitted": 10,
        +"packets_received": 10,
        +"packets_lost": 0,
        +"packet_loss": 0,
    },
    +"options": {#619
        +"host": "fe80::6c42:407d:af01:9567",
        +"count": 10,
        +"packet_size": 200,
        +"ttl": 120,
        +"version": 6,
    },
    +"time": {#612
        +"start": {#614
            +"as_float": 1596985675.4344,
            +"human_readable": "09-08-2020 15:07:55.434400",
        },
        +"stop": {#613
            +"as_float": 1596985684.4659,
            +"human_readable": "09-08-2020 15:08:04.465900",
        },
        +"time": 9.032,
    },
}
``` 

### Testing

```bash

composer test

```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

# Contributing

Thank you for considering contributing to the improvement of the package. Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

If you discover any security related issues, please send an e-mail to Angel Campos via angel.campos.m@outlook.com instead of using the issue tracker. All security vulnerabilities will be promptly addressed.

## Credits

- [Angel Campos](https://github.com/angelcamposm)

## License

The package Ping is open-source package and is licensed under The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
