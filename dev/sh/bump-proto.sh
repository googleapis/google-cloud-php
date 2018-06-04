#!/bin/bash

find . -maxdepth 2 -name composer.json -not -path "./vendor/*" -exec sed -i "s/google\/proto-client[\"']: [\"']\^0\.[0-9][0-9]\(\.[0-9]\)\?[\"']/google\/proto-client\": \"\^$1\"/" "{}" \;
