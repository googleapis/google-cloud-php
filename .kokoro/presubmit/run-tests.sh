#!/bin/bash

set -ex

pushd github/google-cloud-php
composer --no-interaction --no-ansi --no-progress update
dev/sh/tests
popd
