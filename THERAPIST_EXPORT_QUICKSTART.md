# Quick Start Guide: Export Therapist Bios

## Run the Export

```bash
php artisan therapists:export-bios
```

This will create `therapist-bios.csv` in your project root.

## Open the CSV

You can open the CSV file in:
- Microsoft Excel
- Google Sheets
- Apple Numbers
- Any spreadsheet application

## What You'll Get

The CSV includes:
- ✅ Therapist name & email
- ✅ Bio text extracted from PDF/Word files
- ✅ All licensed states (from clinical license uploads)
- ✅ File path reference

## Example Output

```csv
Name,Preferred Name,Email,Bio Text,Licensed States,Bio File Path
"John Smith","Dr. John","john@example.com","Licensed therapist with 10 years...","California, New York","uploads/bios/john-bio.pdf"
"Jane Doe","Jane","jane@example.com","Specializing in trauma therapy...","Texas","uploads/bios/jane-bio.docx"
```

## Custom Output Location

```bash
php artisan therapists:export-bios --output=exports/my-export.csv
```

For full documentation, see [THERAPIST_BIO_EXPORT.md](THERAPIST_BIO_EXPORT.md)
