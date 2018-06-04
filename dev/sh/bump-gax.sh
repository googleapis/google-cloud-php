#!/bin/bash

find . -maxdepth 2 -name composer.json -not -path "./vendor/*" -exec sed -i "s/google\/gax[\"']: [\"']\^0\.[0-9][0-9]\.[0-9][\"']/google\/gax\": \"\^$1\"/" "{}" \;
