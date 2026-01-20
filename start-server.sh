#!/bin/bash

# Start PHP development server
echo "Starting PHP development server on localhost:8000..."
php -S localhost:8000 &

# Store the PHP server PID
PHP_PID=$!

# Wait a moment for PHP server to start
sleep 2

# Start Cloudflare tunnel
echo "Starting Cloudflare tunnel..."
cloudflared tunnel run php-website &

# Store the tunnel PID
TUNNEL_PID=$!

echo "Server running! Access at: https://php-website.jaredcervantes.com"
echo "PHP Server PID: $PHP_PID"
echo "Tunnel PID: $TUNNEL_PID"
echo ""
echo "Press Ctrl+C to stop both services"

# Function to cleanup on exit
cleanup() {
    echo ""
    echo "Stopping services..."
    kill $PHP_PID 2>/dev/null
    kill $TUNNEL_PID 2>/dev/null
    echo "Services stopped."
    exit 0
}

# Set trap to cleanup on interrupt
trap cleanup SIGINT SIGTERM

# Wait for processes
wait