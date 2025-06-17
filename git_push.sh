#!/bin/bash

# Exit on any error
set -e

# Check for commit message
if [ -z "$1" ]; then
  echo "❌ Commit message required!"
  echo "Usage: ./git_push.sh \"your commit message here\""
  exit 1
fi

# Git commit message
COMMIT_MSG="$1"

# Commit changes
git add .
git commit -m "$COMMIT_MSG"

# Push to main
git push origin main

# Get the latest tag (defaults to 0.0.0 if none found)
LATEST_TAG=$(git describe --tags --abbrev=0 2>/dev/null || echo "0.0.0")

# Split into major, minor, patch
IFS='.' read -r MAJOR MINOR PATCH <<< "$LATEST_TAG"

# Increment patch version
PATCH=$((PATCH + 1))

# Construct new tag
NEW_TAG="${MAJOR}.${MINOR}.${PATCH}"

# Create and push new tag
git tag "$NEW_TAG"
git push origin "$NEW_TAG"

# Done
echo "✅ Pushed to main and created new tag: $NEW_TAG"
