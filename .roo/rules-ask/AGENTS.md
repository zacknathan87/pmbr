# Project Documentation Rules (Non-Obvious Only)

## Critical Documentation Context
- Statistics queries must filter `is_fake = 0` for real user data (affects documentation examples)
- Bet references use complex parsing: `num_1`, `total`, `unique` (explode by underscore in code)
- Game result checking requires splitting winning numbers by comma and parsing bet_ref
- All betting operations must use `WorkerController` methods (not direct database calls)
- Settings must be retrieved using `getSetting()` from database (never hardcoded)
- Admin URLs must use `admin_url()` helper for proper routing
- Currency formatting requires `currency_format()` with 'RM' currency