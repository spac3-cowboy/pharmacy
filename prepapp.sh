#!/bin/bash

source_dir="."
destination_dir="../readytoupload"

# Directories to exclude
exclude_dirs=(".git", "node_modules")

# Create destination directory if it doesn't exist
mkdir -p "$destination_dir"

# Copy files and folders from source to destination
rsync -av --exclude="${exclude_dirs[@]}" "$source_dir/" "$destination_dir/"


zip_filename="../upload.zip"

# Create the ZIP archive
zip -r "$zip_filename" "$destination_dir"
