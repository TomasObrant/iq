#!/usr/bin/env bash

KEY=$1
ACTION="action_$KEY"

# MAIN ACTIONS
action_up() {
  action_down
  docker-compose up -d --build --force-recreate
}

action_down() {
  docker-compose down --remove-orphans
}

function_exists() {
  declare -f -F "$1" >/dev/null
  return $?
}

function_exists "$ACTION" && "$ACTION" "$@"