#!/usr/bin/env bash

readarray -t LINES < "$1"
for LINE in "${LINES[@]}"; do
	sku=`echo $LINE | sed "s/^.\?{\"sku\":\([0-9]\+\),\"name\":\"\([^\"]\+\)\".*$/\1/g"`
	name=`echo $LINE | sed "s/^.\?{\"sku\":\([0-9]\+\),\"name\":\"\([^\"]\+\)\".*$/\2/g"`
	php loaddatastore.php "$sku" "$name"
done
