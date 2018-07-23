#!/bin/bash

set -ev

# This script expects to be run from the google-cloud-php root.
# It finds all composer.json files and updates the google/gax
# version to the specified command line argument.
#
# Usage (to update gax version to e.g. 0.1.2):
# $ ./dev/sh/bump-gax.sh 0.1.2

find . -maxdepth 2 -name composer.json \
     -not -path "./vendor/*" \
     -exec sed -i "s/google\/gax[\"']: [\"']\^[0-9]\+\.[0-9]\+\(\.[0-9]\+\)\?[\"']/google\/gax\": \"\^$1\"/" "{}" \;
