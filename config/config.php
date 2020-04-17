<?php

return [

    /**
     * Stop after sending count ECHO_REQUEST packets.
     */
    'count' => 4,

    /**
     * Wait interval seconds between sending each packet. The default is to
     * wait for one second between each packet normally, or not to wait in
     * flood mode.
     * Only super-user may set interval to values less than 0.2 seconds.
     */
    'interval' => 1,

    /**
     * Specifies the number of data bytes to be sent.
     * The default is 56, which translates into 64 ICMP data bytes when
     * combined with the 8 bytes of ICMP header data.
     */
    'packet_size' => 64,

    /**
     * Time to wait for a response, in seconds. The option affects only
     * timeout in absence of any responses, otherwise ping waits for two RTTs.
     */
    'timeout' => 5,

    /**
     * The TTL value of an IP packet represents the maximum number of IP
     * routers that the packet can go through before being thrown away.
     * In current practice you can expect each router in the Internet to
     * decrement the TTL field by exactly one.
     */
    'time_to_live' => 128,

];
