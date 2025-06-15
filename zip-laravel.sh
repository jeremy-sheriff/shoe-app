#!/bin/bash

# Name of the output zip file
ZIP_NAME="laravel-project.zip"

# Remove existing zip if it exists
if [ -f "$ZIP_NAME" ]; then
  echo "Removing existing $ZIP_NAME..."
  rm "$ZIP_NAME"
fi

# Create zip excluding public/, .git/, and node_modules/
echo "Zipping Laravel project..."
zip -r "$ZIP_NAME" . -x "public/*" ".git/*" "node_modules/*"

echo "✅ Zip created: $ZIP_NAME"
