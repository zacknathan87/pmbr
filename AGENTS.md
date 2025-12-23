# AGENTS.md

This file provides guidance to agents when working with code in this repository.

## Commands

### Single Test Execution
- **Run specific test**: `./vendor/bin/phpunit --filter TestClassName::testMethodName`
- **Run tests in specific file**: `./vendor/bin/phpunit tests/Unit/TestFile.php`
- **Run tests for specific directory**: `./vendor/bin/phpunit tests/Feature/`

### Development Commands
- **Frontend build**: `npm run dev` or `npm run development` (Laravel Mix compilation)
- **Production build**: `npm run prod` or `npm run production`
- **Watch mode**: `npm run watch` or `npm run watch-poll`
- **Hot reload**: `npm run hot` (requires `--disable-host-check` for some environments)

### Artisan Commands
- **Serve application**: `php artisan serve`
- **Create migration**: `php artisan make:migration create_table_name`
- **Run migrations**: `php artisan migrate`
- **Create seeder**: `php artisan make:seeder TableSeeder`
- **Run seeders**: `php artisan db:seed`

### PHP Version Management
- **Direct PHP commands**: Use full path to specific PHP versions (e.g., `/usr/bin/php7.4 artisan serve`)
- **Check PHP version**: `/usr/bin/php7.4 --version`

### Dependency Update Recommendations
- **Safe updates (Laravel 7.x compatible)**:
  - ✅ **Composer**: Updated 106 packages (Laravel framework 7.14.1→7.30.7, security patches)
  - ✅ **NPM**: Updated to latest compatible versions within Vue 2.x ecosystem
  - Avoid major framework upgrades (Laravel 7→12.x) as too risky
  - Use PHP 7.4 (incompatible with fzaninotto/faker - replace if needed)
- **Security issues**:
  - ⚠️ **Composer**: 3 vulnerabilities (medium/high) in Laravel framework and league/commonmark
  - ⚠️ **NPM**: 87 vulnerabilities (26 high, 54 moderate, 7 low) - mostly webpack/build tools
- **Abandoned packages**: beyondcode/laravel-websockets, fruitcake/laravel-cors, fzaninotto/faker, martinlindhe/laravel-vue-i18n-generator, swiftmailer/swiftmailer, phpunit/php-token-stream
- **Frontend updates (Vue 2.x compatible)**: ✅ Updated patch versions, avoided Vue 3.x migration
- **Testing**: PHPUnit 8.x stable for Laravel 7.x - avoid major version jumps

## Code Style

### Imports and Structure
- Helper functions are auto-loaded from `app/Helpers/Helpers.php` via composer.json autoload
- Use `auth:api` middleware for JWT-protected routes
- Admin routes prefixed with `admin-management/` use `BeforeMiddlewareAdminWeb` middleware

### Naming Conventions
- Controller methods use camelCase (e.g., `getGame`, `placeBetDice`)
- Database columns use snake_case (e.g., `is_fake`, `bet_ref`)
- Model relationships use camelCase (e.g., `allBets`, `totalBetsCount`)

### Error Handling
- Use Laravel's built-in exception handling in `app/Exceptions/Handler.php`
- Admin redirects use `admin_url()` helper for consistent URL generation
- API responses use Laravel's JSON responses with appropriate HTTP status codes

### Database Patterns
- Use Eloquent relationships instead of raw queries when possible
- Filter out fake bets with `where('is_fake', 0)` for real statistics
- Bet reference format: `{type}_{position}` (e.g., `num_1`, `total`, `unique`)

## Project-Specific Utilities

### Custom Helper Functions
- `getSetting($key)`: Retrieves settings from database (REQUIRED - do not hardcode values)
- `getRandomWeightedElement(array $weightedValues)`: Weighted random selection for game results
- `shuffle_assoc($array)`: Shuffles associative arrays while preserving keys
- `currency_format($value, $currency)`: Formats currency with RM prefix and proper decimals
- `admin_url($path)`: Generates admin panel URLs with `/admin-management/` prefix
- `member_url($path)`: Generates member-facing URLs (currently just returns $path)
- `dateformat($date)`: Formats dates as `d-m-Y h:i A`
- `date_history($date)`: Formats dates as `Ymd/Hi`

### Game Services
- `Game3numService`: Handles 3-number lottery games with weighted result generation
- `Game5numService`: Handles 5-number lottery games
- `Game10numService`: Handles 10-number lottery games
- `GameDiceService`: Handles dice-based games with shuffle_assoc for randomization
- `GameJackpotService`: Handles jackpot games with complex betting logic

### Worker Controller
- All betting operations must use `WorkerController` methods:
  - `addTransaction()`: Creates wallet transactions
  - `placeBet()`: Places bets with proper validation
- Worker controller handles both real and fake bets (is_fake flag)

### Critical Gotchas
- **Settings Storage**: All configurable values must use `getSetting()` from database - never hardcode
- **Fake Bets**: Statistics queries must filter `is_fake = 0` for real user data
- **Bet References**: Complex parsing logic in `bet_ref` field (num_1, total, unique)
- **Currency Handling**: Always use `currency_format()` with 'RM' currency for consistency
- **Admin URLs**: All admin links must use `admin_url()` helper for proper routing
- **Game Results**: Weighted randomization using `getRandomWeightedElement()` affects house edge
- **Worker Dependencies**: Game services inject WorkerController for transaction handling