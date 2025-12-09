#!/bin/bash

if [ -z "$1" ]; then
    echo "Usage: ./logs.sh <container>"
    echo "Examples:"
    echo "  ./logs.sh php"
    echo "  ./logs.sh queue"
    echo "  ./logs.sh scheduler"
    exit 1
fi

CONTAINER="swapi-$1"

echo "========================================"
echo " 📄 Logs for container: $CONTAINER"
echo "========================================"

docker logs -f $CONTAINER
