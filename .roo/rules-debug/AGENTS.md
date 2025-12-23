# Project Debug Rules (Non-Obvious Only)

## Testing Commands
- **Run specific test**: `./vendor/bin/phpunit --filter TestClassName::testMethodName`
- **Run tests in specific file**: `./vendor/bin/phpunit tests/Unit/TestFile.php`
- **Run tests for specific directory**: `./vendor/bin/phpunit tests/Feature/`

## Critical Debug Patterns
- Statistics queries must filter `is_fake = 0` for real user data (affects debug output)
- Game result checking requires splitting winning numbers by comma and parsing bet_ref (debug parsing logic)
- Bet references use complex parsing: `num_1`, `total`, `unique` (explode by underscore)