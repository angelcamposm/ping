# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/acamposm/ping.svg?style=flat-square)](https://packagist.org/packages/acamposm/ping)
[![Build Status](https://img.shields.io/travis/acamposm/ping/master.svg?style=flat-square)](https://travis-ci.org/acamposm/ping)
[![Quality Score](https://img.shields.io/scrutinizer/g/acamposm/ping.svg?style=flat-square)](https://scrutinizer-ci.com/g/acamposm/ping)
[![Total Downloads](https://img.shields.io/packagist/dt/acamposm/ping.svg?style=flat-square)](https://packagist.org/packages/acamposm/ping)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

## Installation

You can install the package via composer:

```bash
composer require acamposm/ping
```

## Usage

``` php
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

Change

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email angel.campos.m@outlook.com instead of using the issue tracker.

## Credits

- [Angel Campos](https://github.com/acamposm)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).