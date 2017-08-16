#!/usr/bin/env bash

# A backup script for WordPress sites on dokku
# Run once per day using launchd

# variables
app_name='thoughtfulmuse'
project_root="/Users/Grant/Sites/VVV/www/${app_name}/"
ssh_remote='grant.mk'
dokku_remote='dokku'
remote_uploads_dir="/home/dokku/${app_name}/uploads/"
local_uploads_dir="${project_root}web/wp-content/uploads/"
db_filename="${app_name}_`date +\"%Y_%m_%d\"`.sql"
db_backup_limit=30

# rsync uploads to local development environment
rsync -qlrz $ssh_remote:$remote_uploads_dir $local_uploads_dir

# database
if [ ! -d ${project_root}sql/backups/ ]; then
	mkdir ${project_root}sql/backups/
fi
cd ${project_root}sql/backups/
ssh $dokku_remote mariadb:export $app_name > $db_filename
gzip -qf $db_filename

# Remove old backups
# Add one to the file limit since `ls` displays the count total on the first line, which counts as the first file to save
# `ls -t1` list the files in descending order from newest to oldest, with 1 file on each line
# `tail -n+[number]` display all but the first number of (newest) files, specified
# `xargs rm` delete files
ls -t1 | tail -n+$(($db_backup_limit + 1)) | xargs rm
