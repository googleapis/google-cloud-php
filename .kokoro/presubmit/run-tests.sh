#!/bin/bash

set -ex

pushd github/google-cloud-php
composer update
popd

github/google-cloud-php/dev/sh/tests
