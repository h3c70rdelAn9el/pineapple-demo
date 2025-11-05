# Therapist Bio Export Script

This document explains how to use the therapist bio export script to generate a CSV file containing therapist information.

## Overview

The script exports the following information for all therapists (non-admin users):
- Name
- Preferred Name
- Email
- Bio Text (extracted from uploaded PDF/Word files)
- Licensed States (from clinical license file uploads)
- Bio File Path (for reference)

## Requirements

The following packages are required and have been installed:
- `smalot/pdfparser` - For extracting text from PDF files
- `phpoffice/phpword` - For extracting text from Word (.docx) files

## Usage

### Basic Usage

To export therapist bios to the default file name:

```bash
php artisan therapists:export-bios
```

This will create a file named `therapist-bios.csv` in your project root directory.

### Custom Output File

To specify a custom output file name:

```bash
php artisan therapists:export-bios --output=custom-name.csv
```

### Examples

Export to a specific directory:
```bash
php artisan therapists:export-bios --output=/path/to/exports/therapists-2024.csv
```

Export to the storage directory:
```bash
php artisan therapists:export-bios --output=storage/app/therapist-bios.csv
```

## CSV Output Format

The generated CSV file contains the following columns:

1. **Name** - Therapist's full name
2. **Preferred Name** - Therapist's preferred name (if set)
3. **Email** - Therapist's email address
4. **Bio Text** - Text extracted from bio file (PDF, DOCX, or TXT)
5. **Licensed States** - Comma-separated list of states where the therapist is licensed
6. **Bio File Path** - Path to the original bio file in storage

## Supported File Formats

### Bio Files
- **PDF** (.pdf) - Fully supported
- **Word** (.docx) - Fully supported
- **Text** (.txt) - Fully supported
- **Word 97-2003** (.doc) - Not supported (convert to .docx or PDF first)

### Error Messages in CSV

If a bio file cannot be processed, you may see one of these messages in the CSV:

- `[File not found]` - The file path exists in database but file is missing from storage
- `[Unsupported file format: xxx]` - The file format is not supported
- `[Error reading file: ...]` - An error occurred while reading the file
- `[Error parsing PDF: ...]` - An error occurred while parsing a PDF file
- `[Error parsing DOCX: ...]` - An error occurred while parsing a Word file
- `[.doc format not supported...]` - Old Word format detected (convert to .docx)

## How Licensed States are Determined

Licensed states are collected from file uploads with:
- `document_type` = "clinical_license"
- `region` field is set (contains the state name)

The script automatically:
- Collects all unique states from clinical license uploads
- Sorts them alphabetically
- Combines them into a comma-separated list

## Troubleshooting

### Empty Bio Text Column

If the bio text column is empty, check:
1. Is there a file upload with `document_type` = "Bio" for this therapist?
2. Does the file actually exist in storage at the specified path?
3. Is the file format supported (PDF, DOCX, or TXT)?

### No Licensed States

If the licensed states column is empty, check:
1. Are there file uploads with `document_type` = "clinical_license"?
2. Do those file uploads have the `region` field populated?

### Performance

For large databases with many therapists and large bio files, the export may take some time. The script displays a progress bar to track the export progress.

## Database Schema

The script relies on these database tables and columns:

### users table
- `id`
- `name`
- `preferred_name`
- `email`
- `admin` (filters where admin != 1)

### file_uploads table
- `user_id`
- `file_path`
- `document_type`
- `region`

## Notes

- The script automatically cleans up extracted text by removing extra whitespace
- Text extraction from PDF files may not be perfect for complex layouts or scanned documents
- The CSV is encoded in UTF-8 to support international characters
