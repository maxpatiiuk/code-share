#!/bin/bash

#Folders backup
S_PATH=~/base_path/
FILE_1=first_target_to_backup
FILE_2=second_target_to_backup
D_PATH=~/location_for_daily_file_backup_$(date +"%a")/
M_PATH=~/location_for_monthly_file_backup_$(date +"%b")/

#SQL Database backup
URL=https://url.that.returns/sql.database.backup
SQL_DESTINATION=~/destitaion_for_saving_sql_files
SQL_DATE=$(date '+_%F_%H-%M-%S.sql')
SQL_DAILY=${SQL_DESTINATION}daily$SQL_DATE
SQL_MONTHLY=${SQL_DESTINATION}MONTLHY$SQL_DATE

if [[ ! -d "$D_PATH" || $(date -r "$D_PATH" '+%j') != $(date '+%j') ]]; then # did not run yet

	if [[ -d "$D_PATH" ]]; then
		rm -r "$D_PATH"
	fi
	mkdir -p "$D_PATH"
	cp -R "$S_PATH$FILE_1" "$D_PATH"
	cp -R "$S_PATH$FILE_2" "$D_PATH"

	curl ${URL} > $SQL_DAILY

	if [[ ! -d "$M_PATH" || $(date -r "$M_PATH" '+%m%y') != $(date '+%m$y') ]]; then

		if [[ -d "$M_PATH" ]]; then
			rm -r "$M_PATH"
		fi
		mkdir -p "$M_PATH"
		cp -R "$S_PATH$FILE_1" "$M_PATH"
		cp -R "$S_PATH$FILE_2" "$M_PATH"

		curl ${URL} > $SQL_MONTHLY

	fi

fi