#!/bin/bash

set -ev

function pushDocs () {
  echo "doc dir before generation:"
  find docs
  composer docs
  echo "doc dir after generation:"
  find docs
  git submodule add -f -b gh-pages https://${GH_OAUTH_TOKEN}@github.com/${GH_OWNER}/${GH_PROJECT_NAME} ghpages
  mkdir -p ghpages/json/${1}
  cp -R docs/json/master/* ghpages/json/${1}
  cp docs/overview.html ghpages/json/${1}
  cp docs/toc.json ghpages/json/${1}
  cp docs/home.html ghpages/json
  cp docs/manifest.json ghpages
  cd ghpages
  git add .
  if [[ -n "$(git status --porcelain)" ]]; then
    git config user.name "travis-ci"
    git config user.email "travis@travis-ci.org"
    git commit -m "Updating docs for ${1}"
    git status
    git push https://${GH_OAUTH_TOKEN}@github.com/${GH_OWNER}/${GH_PROJECT_NAME} HEAD:gh-pages
  else
    echo "Nothing to commit."
  fi
}

if [ "${TRAVIS_BRANCH}" == "master" ] && [ "${TRAVIS_PULL_REQUEST}" == "false" ]; then
  pushDocs $TRAVIS_BRANCH
fi

if [[ ! -z $TRAVIS_TAG ]]; then
  pushDocs $TRAVIS_TAG
fi
