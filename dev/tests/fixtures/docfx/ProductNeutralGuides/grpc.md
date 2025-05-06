# Install gRPC for PHP

gRPC is a modern, open-source, high-performance remote procedure call framework.
If you want to use PHP client libraries for gRPC-enabled APIs, you must install
gRPC for PHP. This tutorial explains how to install and enable gRPC.

## Objectives

* Install the gRPC extension for PHP.
* Enable the gRPC extension for PHP.

## Requirements

* PHP 7.0 or later
* [PECL](https://pecl.php.net/) (unless you build from source)
* [Composer](https://getcomposer.org/)

Note: Windows users can
[download and enable DLLs][pecl_grpc]
from PECL.

[pecl_grpc]: https://pecl.php.net/package/gRPC

## Installing PECL

<details>
    <summary>Ubuntu / Debian</summary>
    ```
    sudo apt-get install autoconf zlib1g-dev php-dev php-pear
    ```
    If using PHP 7.4+, PHP must have been installed with the `--with-pear` flag.
</details>

<details>
    <summary>CentOS / RHEL 7</summary>
    ```
    sudo rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
    sudo rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm
    sudo yum install php-devel php-pear gcc zlib-devel
    ```
</details>
<details>
    <summary>macOS</summary>
    ```
    curl -O https://pear.php.net/go-pear.phar
    sudo php -d detect_unicode=0 go-pear.phar
    ```
</details>
<details>
    <summary>Windows</summary>

    Windows does not require PECL.
</details>

[pecl-grpc]: https://pecl.php.net/package/grpc

## Installing Composer

<details>
    <sumamry>Linux</summary>
    ```
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
    ```
</details>
<details>
    <sumamry>macOS</summary>
    ```
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
    ```
</details>
<details>
    <sumamry>Windows</summary>

    Follow the [official Composer installation instructions][composer-windows]
    for Windows.
</details>

[composer-windows]: https://getcomposer.org/doc/00-intro.md#installation-windows

## Installing the gRPC extension

<details>
    <sumamry>Using PECL</summary>
    ```
    sudo pecl install grpc
    ```

    This compiles and installs the gRPC PHP extension into the standard PHP
    extension directory.

    Note: For users on CentOS/RHEL 6, unfortunately this step won't work. Follow
    the instructions under the **Build from source** tab to compile the
    extension from source.
</details>
<details>
    <sumamry>Build from source</summary>

    Follow these instructions to compile the gRPC core library and PHP extension
    from source.

    1. Clone the gRPC repository from GitHub.

            git clone https://github.com/grpc/grpc

    2. Build and install the gRPC C core library.

        ```
        cd grpc
        git submodule update --init
        make
        sudo make install
        ```

        It can take a few minutes to download and execute the library.
        If you have git version 1.8.4 or greater, you can speed up
        the `git submodule update --init` command by adding the `--depth=1`
        flag.

    3. Compile the gRPC PHP extension.
        ```
        cd src/php/ext/grpc
        phpize
        ./configure
        make
        sudo make install
        ```

</details>
<details>
    <sumamry>Windows</summary>

    Windows users can download the pre-compiled gRPC directly from the
    [PECL website][pecl-grpc].

    Read the [PHP documentation for installing extensions](https://www.php.net/manual/en/install.pecl.windows.php) on Windows.
</details>

[pecl-grpc]: https://pecl.php.net/package/grpc

### Enable the gRPC extension in php.ini

<details>
    <sumamry>Linux / macOS</summary>
    Add this line anywhere in your `php.ini` file, for example, `/etc/php7/cli/php.ini`.
    You can find this file by running `php --ini`.

    ```sh
    extension=grpc.so
    ```
</details>
<details>
    <sumamry>Windows</summary>

    Add this line anywhere in your `php.ini` file, for example, `C:\Program Files\PHP\7.3\php.ini`.

    ```sh
    extension=php_grpc.dll
    ```
</details>

### Add gRPC as a Composer dependency

Use Composer to add the `grpc/grpc` package to your PHP project:

```sh
composer require "grpc/grpc:^1.38"
```

## Installing the protobuf runtime library

You can choose from two protobuf runtime libraries. The APIs they offer are
identical. The C implementation performs better than the PHP (native)
implementation, while the native implementation installs easier than the
C implementation.

<details>
    <sumamry>C implementation</summary>

    For better performance with gRPC, enable the protobuf C-extension.

    **Linux / macOS**

    Install the `protobuf.so` extension by using PECL.

    ```
    sudo pecl install protobuf
    ```

    Now add this line to your `php.ini` file, for example,
    `/etc/php5/cli/php.ini`.

    ```
    extension=protobuf.so
    ```

    **Windows**

    Download the pre-compiled protobuf extension directly from the
    [PECL website][pecl-protobuf].

    Now add this line to your `php.ini` file, for example,
    `C:\Program Files\PHP\7.3\php.ini`.

    ```
    extension=php_protobuf.dll
    ```
</details>

[pecl-protobuf]: https://pecl.php.net/package/protobuf

<details>
    <sumamry>PHP implementation</summary>

    For easier installation, require the `google/protobuf` package by using
    Composer.

    ```
    composer require "google/protobuf:^3.17"
    ```
</details>

## What's next

Now that you've installed gRPC and the gRPC PHP extension, try out gRPC-enabled
APIs such as
[{{spanner_name}}](/spanner/docs/reference/libraries#client-libraries-install-php){: track-type="php" track-name="internalLink" track-metadata-position="body" }.
