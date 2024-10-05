#!/bin/bash

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ROOT_DIR="$(cd "$SCRIPT_DIR/../.." && pwd)"

PLATFORMS="linux/amd64,linux/arm64"
COMPOSE_FILE="$ROOT_DIR/docker-compose.yml"

# Check if docker-compose.yml exists
if [ ! -f "$COMPOSE_FILE" ]; then
    echo "Error: $COMPOSE_FILE not found."
    exit 1
fi

# Extract services with ghcr.io images from docker-compose.yml
services=$(grep -E '^\s+image:\s+ghcr.io/' "$COMPOSE_FILE" | awk '{print $2}')

if [ -z "$services" ]; then
    echo "No services with ghcr.io images found in $COMPOSE_FILE"
    exit 1
fi

# Process each service
for service in $services; do
    # Parse the full image name and tag
    image_with_tag=$service
    image_name=${image_with_tag%:*}
    tag=${image_with_tag#*:}

    # Extract the service name from the image name
    service_name=$(basename $image_name)

    echo "Building and pushing $PLATFORMS $image_with_tag..."

    build_args=(
        -f "$COMPOSE_FILE"
        --set "*.platform=$PLATFORMS"
        --set "${service_name}.cache-from=type=registry,ref=${image_name}:build-cache"
        --set "${service_name}.cache-to=type=registry,ref=${image_name}:build-cache,mode=max"
        --set "${service_name}.tags=${image_with_tag}"
        --set "${service_name}.tags=${image_name}:latest"
        --push
    )

    build_args+=("${service_name}")

    docker buildx bake "${build_args[@]}"
done

echo "Build process completed successfully!"