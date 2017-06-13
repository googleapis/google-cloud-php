# Stackdriver Debugger PHP Extension

This extension enables the following services:

* [Stackdriver Debugger](https://cloud.google.com/debugger/)

Stackdriver Debugger is a free, open-source way to debug your running application.

This library allows you to set breakpoints in your running application that conditionally capture
local variable state, stack traces, and more. This library can work in conjunction with the PHP library
[google/cloud-debugger](https://packagist.org/packages/google/cloud-debugger) in order
to send collected data to a backend storage server.

## Compatibilty

This extension has been built and tested on the following PHP versions:

* 7.1.x (ZTS and non-ZTS)
* 7.0.x (ZTS and non-ZTS)

## Installation

### Build from source

1. [Download a release](https://github.com/GoogleCloudPlatform/google-cloud-php-debugger/releases)

   ```bash
   curl https://github.com/GoogleCloudPlatform/google-cloud-php-debugger/archive/v0.1.0.tar.gz -o debugger.tar.gz
   ```

1. Untar the package

   ```bash
   tar -zxvf debugger.tar.gz
   ```

1. Go to the extension directory

   ```bash
   cd google-cloud-php-debugger-0.1.0/ext
   ```

1. Compile the extension

   ```bash
   phpize
   configure --enable-stackdriver-debugger
   make
   make test
   make install
   ```

1. Enable the stackdriver debugger extension. Add the following to your `php.ini` configuration file.

   ```
   extension=stackdriver_debugger.so
   ```

### Download from PECL (not yet available)

When this extension is available on PECL, you will be able to download and install it easily using the
`pecl` CLI tool:

```bash
pecl install stackdriver_debugger
```

## Usage

TBD
