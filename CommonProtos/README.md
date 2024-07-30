## Common Protos PHP

[![release level](https://img.shields.io/badge/release%20level-general%20availability%20%28GA%29-brightgreen.svg?style&#x3D;flat)](https://cloud.google.com/terms/launch-stages)

![Build Status](https://github.com/googleapis/common-protos-php/actions/workflows/tests.yml/badge.svg)

- [Documentation](https://googleapis.github.io/common-protos-php)

This repository is a home for the [protocol buffer][protobuf] types which are
common dependencies throughout the Google API ecosystem, generated for PHP.
The protobuf definitions for these generated PHP classes are provided by the
[Common Components AIP][common-components-aip] repository.

## Using these generated classes

These classes are made available under an Apache license (see `LICENSE`) and
you are free to depend on them within your applications. They are
considered stable and will not change in backwards-incompaible ways.

They are distributed as the [google/common-protos][packagist-common-protos]
composer package, available on [Packagist][packagist].

In order to depend on these classes, add the following line to your
composer.json file in the `requires` section:

```
  "google/common-protos": "^2.0"
```

Or else use composer from the command line:

```bash
composer require google/common-protos
```

## License

These classes are licensed using the Apache 2.0 software license, a
permissive, copyfree license. You are free to use them in your applications
provided the license terms are honored.

  [api-style]: https://cloud.google.com/apis/design/
  [protobuf]: https://developers.google.com/protocol-buffers/
  [common-components-aip]: https://google.aip.dev/213
  [packagist-common-protos]: https://packagist.org/packages/google/common-protos/
  [packagist]: https://packagist.org/
