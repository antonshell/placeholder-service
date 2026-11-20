#!/usr/bin/env bash
# Smoke test of the production image: starts it and checks what PHPUnit can't see
# (the container boots in the prod environment, GD + FreeType render images, static files and their headers).
#
# Usage: .github/scripts/smoke-test.sh <image>
set -euo pipefail

IMAGE="${1:?usage: $0 <image>}"
NAME="placeholder-service-smoke-$$"
PORT="${SMOKE_PORT:-18099}"
BASE="http://127.0.0.1:$PORT"
failures=0

cleanup() {
    if (( failures > 0 )); then
        echo "--- container logs ---"
        docker logs "$NAME" 2>&1 | tail -50 || true
    fi
    docker rm -f "$NAME" >/dev/null 2>&1 || true
}
trap cleanup EXIT

check() { # check <description> <command...>
    local description="$1"; shift
    if "$@"; then
        echo "✅ $description"
    else
        echo "❌ $description"
        failures=$((failures + 1))
    fi
}

status_is() { # status_is <expected> <path>
    local actual
    actual="$(curl -s -o /dev/null -w '%{http_code}' "$BASE$2")"
    [[ "$actual" == "$1" ]] || { echo "   status: got $actual, expected $1"; return 1; }
}

header_is() { # header_is <path> <header> <expected value>
    local actual
    actual="$(curl -s -D - -o /dev/null "$BASE$1" | tr -d '\r' | grep -i "^$2:" | cut -d' ' -f2-)"
    [[ "$actual" == "$3" ]] || { echo "   $2: got '$actual', expected '$3'"; return 1; }
}

image_is() { # image_is <path> <width> <height> <mime type>: decoded inside the container by GD
    local actual
    actual="$(docker exec "$NAME" php -r '$i = getimagesize($argv[1]); echo $i ? "$i[0]x$i[1] $i[mime]" : "not an image";' "http://127.0.0.1:8080$1")"
    [[ "$actual" == "$2x$3 $4" ]] || { echo "   got '$actual', expected '$2x$3 $4'"; return 1; }
}

docker run -d --name "$NAME" -e APP_SECRET=smoke-test -p "127.0.0.1:$PORT:8080" "$IMAGE" >/dev/null

# wait for the image's own HEALTHCHECK
health=starting
for _ in $(seq 1 30); do
    health="$(docker inspect -f '{{.State.Health.Status}}' "$NAME")"
    [[ "$health" == healthy ]] && break
    sleep 2
done
check "container is healthy" [ "$health" == healthy ]

check "GET / → 200" status_is 200 /
check "GET / → JSON status ok" bash -c "curl -s '$BASE/' | grep -q '\"status\":\"ok\"'"
check "GET / is not in debug mode" bash -c "! curl -s -D - -o /dev/null '$BASE/' | grep -qi '^x-debug-token'"
check "unknown route → 404" status_is 404 /this/route/does/not/exist

# image generation: GD with FreeType (text) and libjpeg, the font from resources/fonts
check "/img → 300x300 PNG" image_is /img 300 300 image/png
check "/img size and text" image_is "/img?width=320&height=240&text=Hello&text_size=40&color_text=000&color_bg=fff" 320 240 image/png
check "/img?format=jpeg → JPEG" image_is "/img?format=jpeg" 300 300 image/jpeg
check "/img?format=gif → GIF" image_is "/img?format=gif" 300 300 image/gif
check "/img Content-Type" header_is "/img" Content-Type image/png
check "unsupported format → 400" status_is 400 "/img?format=svg"

# static files from public/, never routed to Symfony
check "/favicon.ico → 200" status_is 200 /favicon.ico
check "/favicon.ico is cached" header_is /favicon.ico Cache-Control "public, max-age=604800"

if (( failures > 0 )); then
    echo "Smoke test failed: $failures check(s)"
    exit 1
fi
echo "Smoke test passed"
