# Workout Logger

A comprehensive web application for tracking your fitness journey, built with Laravel. Track your workouts, monitor your nutrition, and achieve your fitness goals.
Deployed : lifts.kesug.com

## Features

- **Exercise Tracking**: Log and monitor your exercise progress
- **Lift Records**: Keep track of your lifting stats and personal records
- **Meal Logging**: Track your daily nutrition and meal intake
- **Weight Tracking**: Monitor your weight progress over time
- **Calorie Calculator**: Calculate your daily caloric needs

## Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/MariaDB

## Installation

1. Clone the repository
```bash
git clone [repository-url]
cd workoutLogger
```

2. Install PHP dependencies
```bash
composer install
```

3. Install NPM dependencies
```bash
npm install
```

4. Create environment file
```bash
cp .env.example .env
```

5. Generate application key
```bash
php artisan key:generate
```

6. Configure your database in `.env` file
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=workout_logger
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run migrations
```bash
php artisan migrate
```

8. Build assets
```bash
npm run build
```

9. Start the development server
```bash
php artisan serve
```

## Usage

1. Register a new account or login with existing credentials
2. Navigate to different sections to:
   - Log your exercises and track progress
   - Record your lifts and personal records
   - Track your daily meals and nutrition
   - Monitor your weight changes
   - Calculate your daily caloric needs

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
