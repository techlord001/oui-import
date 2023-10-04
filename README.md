# OUI Import Project

This project aims to import the latest version of the OUI (Organizationally Unique Identifier) data into a database and provides a JSON API for looking up vendor information based on MAC addresses.

I did run into some issues try to parse the CSV file, specifically any cells that had multiple escaped lines (seemed to only be the addresses). Didn't have time to resolve that.

## Files and Components

### Models

#### Oui.php
Defines the Eloquent model for the `ouis` table, representing OUI data. It includes fillable fields and a method to retrieve the organization name.

### Controllers

#### JsonApiController.php
Implements two methods for MAC address lookup – one for a single MAC (`lookupSingleMac`) and another for multiple MACs (`lookupMultipleMacs`). It includes methods for normalizing MAC addresses and looking up vendors based on OUI data.

### Commands

#### ImportOuiData.php
A custom Artisan command (`import:oui-data`) to import the latest OUI data from the provided URL into the database. It utilizes Laravel's HTTP client to fetch the CSV data and populates the `ouis` table.

### Routes

#### web.php
Defines lookup routes, specifically GET for single and POST for multiple MAC address lookups. Routes are mapped to methods in the `JsonApiController` controller.

### Middleware

#### VerifyCsrfToken.php
Excludes the `/lookup` route from CSRF protection, as the MAC lookup API is intended for external use, and CSRF tokens are not applicable in this context.

### Console Kernel

#### Kernel.php
Automatic import of OUI data twice daily using the `import:oui-data` Artisan command.

### Migrations

#### create_ouis_table.php
Defines the migration for creating the `ouis` table with fields such as `registry`, `assignment`, `organization_name`, `organization_address`, and timestamps.

## Usage

1. **Migrate Database:** Run `php artisan migrate` to create the required database table.

2. **Import OUI Data:** Execute `php artisan import:oui-data` to import the latest OUI data into the database.

3. **MAC Lookup API:**
   - Single MAC lookup (GET): `/lookup/{mac}`
   - Multiple MAC lookups (POST): `/lookup`

## Schedule Import

The `import:oui-data` command is scheduled to run twice daily to keep the OUI data up to date.

## Notes

- Handles MAC randomization and different MAC address separators.
- The `normaliseMac` method ensures consistent formatting of MAC addresses.
- CSRF protection is excluded for the `/lookup` route.
- Provides a JSON API for MAC address lookups, returning vendor information based on the imported OUI data.