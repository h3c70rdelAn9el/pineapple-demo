# Therapist Bio Export - Complete Solution

## Summary

I've created a complete solution for exporting therapist information including their bios and licensed states to a CSV file.

## What Was Created

### 1. **Artisan Command**: `therapists:export-bios`
Located at: `app/Console/Commands/ExportTherapistBios.php`

### 2. **Required Packages** (installed)
- `smalot/pdfparser` - Extracts text from PDF files
- `phpoffice/phpword` - Extracts text from Word (.docx) files

### 3. **Documentation**
- `THERAPIST_BIO_EXPORT.md` - Complete documentation
- `THERAPIST_EXPORT_QUICKSTART.md` - Quick start guide

### 4. **Tests**
- `tests/Unit/ExportTherapistBiosCommandTest.php` - Unit tests (passing ✓)

## How to Use

### Basic Command
```bash
php artisan therapists:export-bios
```

This creates `therapist-bios.csv` with:
- ✅ Therapist name & preferred name
- ✅ Email address
- ✅ Bio text extracted from PDF/Word files
- ✅ All licensed states (from clinical license file uploads)
- ✅ Original bio file path

### Custom Output File
```bash
php artisan therapists:export-bios --output=my-export.csv
```

### Example Output

```
Exporting therapist bios...
 50/50 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%

Successfully exported 50 therapists to therapist-bios.csv

Summary:
  - Therapists with bios: 42
  - Therapists with licensed states: 48
```

## CSV Format

| Name | Preferred Name | Email | Bio Text | Licensed States | Bio File Path |
|------|---------------|-------|----------|-----------------|---------------|
| John Smith | Dr. John | john@example.com | Licensed therapist with 10 years... | California, New York | uploads/bios/john.pdf |
| Jane Doe | Jane | jane@example.com | Specializing in trauma therapy... | Texas | uploads/bios/jane.docx |

## Supported File Formats

### ✅ Supported
- **PDF** (.pdf)
- **Word** (.docx)
- **Text** (.txt)

### ❌ Not Supported
- **Old Word** (.doc) - Convert to .docx first

## Data Sources

### Bio Files
Looks for file uploads where:
- `document_type` = `'Bio'`

### Licensed States
Collects from file uploads where:
- `document_type` = `'clinical_license'`
- `region` field is populated

The script automatically:
- Collects all unique states per therapist
- Sorts them alphabetically
- Combines them into a comma-separated list

## Error Handling

If a bio file can't be processed, you'll see one of these messages in the CSV:
- `[File not found]` - File missing from storage
- `[Unsupported file format: xxx]` - File format not supported
- `[Error reading file: ...]` - File read error
- `[Error parsing PDF: ...]` - PDF parsing error
- `[Error parsing DOCX: ...]` - Word parsing error

## Testing

Run the tests:
```bash
php artisan test --filter=ExportTherapistBiosCommandTest
```

## Performance

The script:
- Shows a progress bar during export
- Processes one therapist at a time
- Displays a summary at the end
- Handles large files efficiently

## Notes

1. **Therapist Definition**: All users where `admin != 1`
2. **Text Extraction**: Automatically cleans up whitespace
3. **CSV Encoding**: UTF-8 (supports international characters)
4. **Order**: Therapists sorted alphabetically by name
5. **States**: Sorted alphabetically and comma-separated

## Complete Documentation

For detailed documentation, see:
- [THERAPIST_BIO_EXPORT.md](THERAPIST_BIO_EXPORT.md) - Full documentation
- [THERAPIST_EXPORT_QUICKSTART.md](THERAPIST_EXPORT_QUICKSTART.md) - Quick reference

## Questions?

The script is fully tested and ready to use. Simply run:
```bash
php artisan therapists:export-bios
```

and you'll get a CSV file with all therapist information including their bio text and licensed states!
