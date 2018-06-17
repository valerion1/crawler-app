#!/bin/bash

function current_path () {
    local script_path="`dirname \"$0\"`"
    script_path="`( cd \"$script_path\" && pwd )`"

    echo $script_path
}


path=$(current_path)
project_dir="$path/../"


printf "PROJECT_DIR=$project_dir" > "$project_dir/docker/.env"


cd "$project_dir/docker" && docker-compose build && docker-compose run app ./bin/crawler $1