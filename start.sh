#!/bin/bash

echo "Starting Laravel Development Server and Queue Worker"

# Function to clean up background processes
cleanup() {
    echo -e "\e[31mStopping Laravel Development Server and Queue Worker\e[0m"
    pkill -f 'php artisan serve'
    pkill -f 'php artisan queue:work'
    exit 0
}

# Set trap to catch SIGINT and SIGTERM
trap cleanup SIGINT SIGTERM

# Create log directory if it doesn't exist
mkdir -p log_script

# run php artisan clear-transaction
if php artisan clear-transaction; then
    echo -e "-----------------\n\e[32mClear Transaction - Success\e[0m"
else
    echo -e "\e[31mClear Transaction - Failed\e[0m"
    cleanup
fi

# Start Laravel Development Server
if nohup bash -c 'php artisan serve' >> log_script/laravel_serve.log 2>&1 & then
    echo -e "\e[32mLaravel Development Server - Started\e[0m"
else
    echo -e "\e[31mLaravel Development Server - Failed to start\e[0m"
    cleanup
fi

# Start Laravel Queue Worker
if nohup bash -c 'php artisan queue:work' >> log_script/laravel_queue_work.log 2>&1 & then
    echo -e "\e[32mLaravel Queue Worker - Started\e[0m"
else
    echo -e "\e[31mLaravel Queue Worker - Failed to start\e[0m"
    cleanup
fi

# Wait for background processes to finish
wait
