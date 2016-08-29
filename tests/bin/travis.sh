#!/usr/bin/env bash
# usage: travis.sh

WP_TESTS_DIR=${WP_TESTS_DIR-/tmp/wordpress-tests-lib}
plugin_dir=$(pwd)

mkdir $WP_TESTS_DIR/php-codesniffer && curl -L https://github.com/squizlabs/PHP_CodeSniffer/archive/master.tar.gz | tar xz --strip-components=1 -C $WP_TESTS_DIR/php-codesniffer
mkdir $WP_TESTS_DIR/wordpress-coding-standards && curl -L https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/archive/master.tar.gz | tar xz --strip-components=1 -C $WP_TESTS_DIR/wordpress-coding-standards

$WP_TESTS_DIR/php-codesniffer/scripts/phpcs --config-set installed_paths $WP_TESTS_DIR/wordpress-coding-standards

phpenv rehash