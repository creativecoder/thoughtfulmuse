#!/usr/bin/env bash

# Make a database, if we don't already have one
echo -e "\nCreating database '${VVV_SITE_NAME}' (if it's not already there)"
mysql -u root --password=root -e "CREATE DATABASE IF NOT EXISTS ${VVV_SITE_NAME}"
mysql -u root --password=root -e "GRANT ALL PRIVILEGES ON ${VVV_SITE_NAME}.* TO wp@localhost IDENTIFIED BY 'wp';"
echo -e "\n DB operations done.\n\n"

# Nginx Logs
mkdir -p ${VVV_PATH_TO_SITE}/log
touch ${VVV_PATH_TO_SITE}/log/error.log
touch ${VVV_PATH_TO_SITE}/log/access.log

if [ -f composer.lock ]; then
	echo 'Running composer update for thoughtfulmuse'
	composer update
elif [ -f composer.json ]; then
	echo 'Running composer install for thoughtfulmuse'
	composer install
fi
if [ -d node_modules ]; then
	echo 'Running npm update for thoughtfulmuse'
	npm update
elif [ -f package.json ]; then
	echo 'Running npm install for thoughtfulmuse'
	npm install
fi
