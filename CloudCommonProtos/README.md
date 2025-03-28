# Google Cloud PHP Common Protos

**NOTE:** This repository is part of [Google Cloud PHP](https://github.com/googleapis/google-cloud-php). Any
support requests, bug reports, or development contributions should be directed to
that project.

This repository is a home for the [protocol buffer][protobuf] types which are
shared by multiple Google Cloud APIs, generated for PHP.
The protobuf definitions for these generated PHP classes are provided in the
[Googleapis][googleapis] repository.

## Using these generated classes

These classes are made available under an Apache license (see `LICENSE`) and
you are free to depend on them within your applications. They are
considered stable and will not change in backwards-incompaible ways.

They are distributed as the [google/cloud-common-protos][packagist-cloud-common-protos]
composer package, available on [Packagist][packagist].

In order to depend on these classes, add the following line to your
composer.json file in the `requires` section:

```
  "google/cloud-common-protos": "^0.1"
```

Or else use composer from the command line:

```bash
composer require google/cloud-common-protos
```

## License

These classes are licensed using the Apache 2.0 software license, a
permissive, copyfree license. You are free to use them in your applications
provided the license terms are honored.

  [protobuf]: https://developers.google.com/protocol-buffers/
  [googleapis]: https://github.com/googleapis/googleapis/
  [packagist-cloud-common-protos]: https://packagist.org/packages/google/cloud-common-protos/
  [packagist]: https://packagist.org/
