# Project Architecture Rules (Non-Obvious Only)

## Core Architecture Patterns
- Game services must inject WorkerController for transaction handling (not optional)
- All betting operations route through WorkerController::addTransaction()
- Worker controller handles both real and fake bets with is_fake flag
- Bet references use complex parsing: `num_1`, `total`, `unique` (explode by underscore)
- Game result checking requires splitting winning numbers by comma and parsing bet_ref
- Statistics queries must filter `is_fake = 0` for real user data
- Settings are stored in database, retrieved via `getSetting()` (never hardcoded)
- Helper functions are auto-loaded from `app/Helpers/Helpers.php` via composer.json autoload

## Critical Dependencies
- `getRandomWeightedElement()` affects house edge for game results
- `shuffle_assoc()` required for dice randomization
- Admin URLs must use `admin_url()` helper for proper routing
- Currency formatting requires `currency_format()` with 'RM' currency