#!/bin/bash

set -ex

pushd github/google-cloud-php
composer update
dev/sh/tests
popd
