# Fix: Bio File Extension Detection

## Problem
The bio export was showing `[Unsupported file format]` for all bio files because the file extension detection was not working correctly.

## Root Cause
The original code was trying to extract the file extension from the `file_path` column:
```php
$extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
```

However, in many cases the `file_path` is stored without an extension (e.g., `uploads/12345`), while the actual file name with extension is stored in the `file_name` column (e.g., `therapist-bio.pdf`).

## Solution
Updated the `extractTextFromFile()` method to:
1. Accept an optional `$fileName` parameter
2. Use `file_name` to determine the file extension if provided
3. Fall back to `file_path` if `file_name` is not available

### Code Changes

**Updated method signature:**
```php
private function extractTextFromFile(string $filePath, ?string $fileName = null): string
```

**Updated extension detection:**
```php
// Use file_name to determine extension if provided, otherwise use file_path
$fileToCheck = $fileName ?: $filePath;
$extension = strtolower(pathinfo($fileToCheck, PATHINFO_EXTENSION));
```

**Updated method call:**
```php
if ($bioFile) {
    $bioFilePath = $bioFile->file_path;
    $bioText = $this->extractTextFromFile($bioFile->file_path, $bioFile->file_name);
}
```

## Testing
Added comprehensive tests to verify:
1. ✅ Basic command functionality
2. ✅ Admin users are excluded
3. ✅ Bio text is extracted from files
4. ✅ File extension is correctly detected from `file_name` when `file_path` has no extension
5. ✅ Licensed states are collected correctly

All tests pass! Run with:
```bash
php artisan test --filter=ExportTherapistBiosCommandTest
```

## Result
The export command now correctly:
- Detects file extensions from the `file_name` field
- Extracts text from PDF, DOCX, and TXT files
- Handles cases where `file_path` doesn't include an extension
- Provides clear error messages when files can't be processed

## Usage
```bash
php artisan therapists:export-bios
```

The CSV will now correctly extract bio text instead of showing unsupported format errors!
