#!/bin/bash

docker run --name docker_postgres_1 \
  -e POSTGRES_PASSWORD=password \
  -e POSTGRES_DB=exchange_report \
  -p 5432:5432 \
  -d postgres