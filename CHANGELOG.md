# Changelog

All notable changes to `ping` will be documented in this file

## 2.0.0 - 2020-08-09

In this version there are important changes, because I have rewritten the class, adding a class to generate the ping commands. With this class you can also create commands for IPv4 and IPv6 addresses, and it allows you to ping domain names.

- The System.php class has been added to detect the type of Operating System.
- The IPAddress.php class has been added to perform the verification and validation of IPv4 and IPv6 addresses.
- Exceptions have been added for error handling.

In this version, an instance of PingCommandBuilder has to be created and passed to the Ping class, then execute the run method of the Ping class to obtain an object with the results.

## 1.0.0 - 2020-04-13

- Added support for Windows based servers, now it's possible to do PING on Linux/Windows based servers...

## 0.0.1 - 2020-04-12

- initial release
