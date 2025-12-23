# Project Coding Rules (Non-Obvious Only)

## Critical Dependencies
- Always inject `WorkerController` in game services for transaction handling (not optional)
- Game services require `WorkerController` for both real and fake bet processing

## Custom Utilities Required
- Use `getRandomWeightedElement()` from `app/Helpers/Helpers.php` for game result generation (affects house edge)
- Use `shuffle_assoc()` from `app/Helpers/Helpers.php` for dice randomization
- Never hardcode settings - always use `getSetting()` from database

## Database Patterns
- Bet references use complex parsing: `num_1`, `total`, `unique` (explode by underscore)
- Filter fake bets with `where('is_fake', 0)` for real user statistics
- Game result checking requires splitting winning numbers by comma and parsing bet_ref

## Transaction Handling
- All betting operations must route through `WorkerController::addTransaction()`
- Both real and fake bets use same transaction methods with is_fake flag
- Worker controller handles wallet transactions and bet validation