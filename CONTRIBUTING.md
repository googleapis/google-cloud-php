# Contributing to Google Cloud PHP

1. **Sign one of the contributor license agreements below.**
2. Fork the repo, develop and test your code changes.
3. Send a pull request.

## Contributor License Agreements

Before we can accept your pull requests you'll need to sign a Contributor License Agreement (CLA):

- **If you are an individual writing original source code** and **you own the intellectual property**, then you'll need to sign an [individual CLA](https://developers.google.com/open-source/cla/individual).
- **If you work for a company that wants to allow you to contribute your work**, then you'll need to sign a [corporate CLA](https://developers.google.com/open-source/cla/corporate).

You can sign these electronically (just scroll to the bottom). After that, we'll be able to accept your pull requests.

## Setup

In order to use Google Cloud PHP, some setup is required!

1. Install PHP.
    Google Cloud PHP requires PHP 5.6 or higher. Installation of PHP varies depending on your system. Refer to the [PHP installation and configuration documentation](http://php.net/manual/en/install.php) for detailed instructions.

2. Install [Composer](https://getcomposer.org/download/).

    Composer is a dependency manager for PHP, and is required to install and use Google Cloud PHP.

3. Install the project dependencies.

    ```sh
    $ composer install
    ```

## Google Cloud PHP and subpackages

Google Cloud PHP is organized at the top level into folders for each supported API. Each API includes the client code, as well as all tests and metadata for the subpackage. For instance, `Datastore/src` contains the Datastore client code, and `Datastore/tests/Unit` contains all Datastore unit tests.

All client library development, as well as issue tracking takes place in Google Cloud PHP (sometimes referred to as the umbrella package, and available on [packagist](https://packagist.org/packages/google/cloud) as `google/cloud`). However, for users who make use of only one or two Google Cloud services, Google Cloud PHP is split into many subpackages, such as `google/cloud-datastore` or `google/cloud-storage`.

This split occurs when a new version of Google Cloud PHP is released. Upon release, an automated script is executed which splits each component into its own github repository and tags a new release if required.

## Tests

Tests are a very important part of Google Cloud PHP. All contributions should include tests that ensure the contributed code behaves as expected.

Google Cloud PHP includes several distinct but equally important test suites: Unit tests, snippet (documentation) tests, system tests, and code style tests.

To run all tests except system tests, the following command may be invoked:

```sh
$ composer tests
```

### Unit Tests

Google Cloud PHP is tested using [PHPUnit](https://phpunit.de).

Unit tests are organized into groups in order to make it simpler to test a single piece of the client library.

``` sh
$ vendor/bin/phpunit --group=datastore
```

If tests are getting skipped, use the flag `--verbose` or `-v` to see a more detailed error. You may be missing the required environment variables.

### Snippet Tests

Documentation is an extremely important part of Google Cloud PHP, and it is crucial that all examples be correct. To support this goal, we implement a strict requirement that every public method must be accompanied by a code sample, and every code sample must be tested.

Running snippet tests can be accomplished as follows:

```sh
$ vendor/bin/phpunit -c phpunit-snippets.xml.dist
```

As with the unit test suite, tests are organized into groups.

If any snippets are not covered by the snippet test suite, PHPUnit will report an error and exit with a failure code.

### System Tests

The Google Cloud PHP system tests interact with live Google Cloud Platform APIs to ensure correctness.

Follow the instructions in the [Authentication guide](AUTHENTICATION.md) for enabling APIs. Some of the APIs may not yet be generally available, making it difficult for some contributors to successfully run the entire system test suite. However, please ensure that you do successfully run system tests for any code areas covered by your pull request.

To run the system tests, first create and configure a project in the Google Developers Console, as described in the [Authentication guide](AUTHENTICATION.md). Be sure to download the JSON KEY file. Make note of the PROJECT_ID and the KEYFILE location on your system.


#### Running the system tests

To run the system tests for a package:

``` sh
$ vendor/bin/phpunit -c phpunit-system.xml.dist --group=datastore
```

System test credentials should be provided via environment variable:

```sh
$ export GOOGLE_CLOUD_PHP_TESTS_KEY_PATH='/path/to/keyfile.json'
$ export GOOGLE_CLOUD_PHP_WHITELIST_TESTS_KEY_PATH='/path/to/keyfile.json'
```

Please note that because Datastore and Firestore cannot be active in the same project, a separate environment variable is required to execute Firestore system tests:

```sh
$ export GOOGLE_CLOUD_PHP_FIRESTORE_TESTS_KEY_PATH='/path/to/keyfile.json'
```

## Coding Style

Please follow the established coding style in the library. Google Cloud PHP follows the [PSR-2](https://www.php-fig.org/psr/psr-2/) Coding Style.

You can check your code against these rules by running PHPCS with the proper ruleset, like this:

```sh
$ composer style
```

## Owlbot

This repository is using OwlBot for copying code from the generated library in
https://github.com/googleapis/googleapis-gen repository.

### Clone googleapis-gen repository

```sh
$ cd /SOME/WHERE
$ git clone git@github.com:googleapis/googleapis-gen.git
```

### Pull docker images

```sh
$ docker pull gcr.io/cloud-devrel-public-resources/owlbot-cli
$ docker pull gcr.io/cloud-devrel-public-resources/owlbot-php
```

### Run copy code

Here is the command for running copy-code for AccessApproval API:

```sh
$ GOOGLEAPIS_GEN=/SOME/WHERE/googleapis-gen

$ docker run --rm --user $(id -u):$(id -g) \
	-v $(pwd):/repo -w /repo \
	-v ${GOOGLEAPIS_GEN}:/googleapis-gen \
	gcr.io/cloud-devrel-public-resources/owlbot-cli:latest \
	copy-code \
	--config-file=AccessApproval/.OwlBot.yaml \
	--source-repo=/googleapis-gen
```

This step just copies the code into owl-bot-staging directory.

### Run OwlBot postprocessor

Here is the command for running the postprocessor:

```sh
$ docker run \
	--user $(id -u):$(id -g) --rm \
	-v $(pwd):/repo -w /repo \
	gcr.io/cloud-devrel-public-resources/owlbot-php
```

This step copies the code from owl-bot-staging directory to the final
destination.

## Code of Conduct

Please note that this project is released with a Contributor Code of Conduct. By participating in this project you agree to abide by its terms. See [Code of Conduct](CODE_OF_CONDUCT.md) for more information.
