#!/bin/bash

# e causes to exit when one commands returns non-zero
# v prints every line before executing
set -ev

cd ${TRAVIS_BUILD_DIR}/laravel

BRANCH_REGEX="^(([[:digit:]]+\.)+[[:digit:]]+)$"

if [[ ${TRAVIS_BRANCH} =~ $BRANCH_REGEX ]]; then
    echo "composer require ${TRAVIS_REPO_SLUG}:${TRAVIS_BRANCH}"
    composer require ${TRAVIS_REPO_SLUG}:${TRAVIS_BRANCH}
else
    echo "composer require ${TRAVIS_REPO_SLUG}:dev-${TRAVIS_BRANCH}"
    # development package of framework could be required for the package
    composer require orchestra/testbench "3.6.*"
    composer require "${TRAVIS_REPO_SLUG}:dev-${TRAVIS_BRANCH}#${TRAVIS_COMMIT}"
fi

# moves the unit test to the root laravel directory
# cp ./vendor/${TRAVIS_REPO_SLUG}/phpunit.travis.xml ./phpunit.xml

phpunit
# phpunit --coverage-text --coverage-clover=${TRAVIS_BUILD_DIR}/coverage.clover
