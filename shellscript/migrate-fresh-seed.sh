# chmod +x migrate-fresh-seed.sh

# Run Laravel migrations and seed the database
php artisan migrate:fresh --seed

# Define the target directory
TARGET_DIR="storage/app/public"

# Check if the target directory exists
if [ -d "$TARGET_DIR" ]; then
  echo "Deleting all files and folders in $TARGET_DIR..."

  # Use the find command to delete all files
  find "$TARGET_DIR" -type f -exec rm -f {} \;

  # Use the find command to delete all directories (non-recursively)
  find "$TARGET_DIR" -mindepth 1 -type d -exec rm -rf {} \;

  echo "All files and folders in $TARGET_DIR have been deleted."
else
  echo "Directory $TARGET_DIR does not exist."
fi
