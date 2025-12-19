#!/bin/sh
set -e

# Run migrations if enabled
if [ "$RUN_MIGRATIONS" = "true" ]; then
    php artisan migrate --force
fi

exec "$@"
