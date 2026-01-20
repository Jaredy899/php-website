#!/bin/bash

echo "Stopping PHP development server and Cloudflare tunnel..."

# Kill PHP server
pkill -f "php -S localhost:8000" 2>/dev/null && echo "PHP server stopped."

# Kill Cloudflare tunnel
pkill -f "cloudflared tunnel run php-website" 2>/dev/null && echo "Cloudflare tunnel stopped."

echo "All services stopped."