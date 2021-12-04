<?php

/*
 | Ping for Laravel.
 |
 | This class makes Ping request to a host.
 |
 | Ping uses the ICMP protocol's mandatory ECHO_REQUEST datagram to elicit an ICMP ECHO_RESPONSE from a host or gateway.
 |
 | @author  Angel Campos <angel.campos.m@outlook.com>
 | @requires PHP 8.0
 | @version  2.1.2
 */

return [

    /*
     |-------------------------------------------------------------------------
     | Number of Ping Packets
     |-------------------------------------------------------------------------
     |
     | Stop after sending count ECHO_REQUEST packets.
     |
     */
    'count' => 5,

    /*
     |-------------------------------------------------------------------------
     | Interval between packets
     |-------------------------------------------------------------------------
     |
     | Wait interval seconds between sending each packet. (min: 0.2)
     | The default is to wait for one second between each packet normally.
     | Only super-user may set interval to values less than 0.2 seconds.
     |
     */
    'interval' => 1,

    /*
     |-------------------------------------------------------------------------
     | Packet size
     |-------------------------------------------------------------------------
     |
     | Specifies the number of data bytes to be sent.
     | The default is 56, which translates into 64 ICMP data bytes when The
     | default is 56, which translates into 64 ICMP data bytes when combined
     | with the 8 bytes of ICMP header data.
     |
     */
    'packet_size' => 64,

    /*
     |-------------------------------------------------------------------------
     | Timeout
     |-------------------------------------------------------------------------
     |
     | Time to wait for a response, in seconds.
     | The option affects only timeout in absence of any responses, otherwise
     | ping waits for two RTTs.
     |
     */
    'timeout' => 8,

    /*
     |-------------------------------------------------------------------------
     | Time to Live
     |-------------------------------------------------------------------------
     |
     | Set the IP Time to Live.
     | The TTL value of an IP packet represents the maximum number of IP
     | routers that the packet can go through before being thrown away.
     | In current practice you can expect each router in the Internet to
     | decrement the TTL field by exactly one.
     |
     */
    'ttl' => 60,

];
