# Student Course Management System

A comprehensive Student Course Management System built with Laravel and Filament. This system provides a modern, user-friendly interface for managing students, courses, enrollments, attendance, and academic records.

## Features

- **Student Management**
  - Student registration and profile management
  - Student enrollment tracking
  - Academic performance monitoring
  - Attendance tracking

- **Course Management**
  - Course creation and management
  - Course scheduling
  - Course materials and resources
  - Course enrollment tracking

- **Academic Management**
  - Grade management
  - Assessment tracking
  - Progress reports
  - Academic performance analytics

- **Admin Dashboard**
  - Real-time statistics and analytics
  - User management
  - System configuration
  - Report generation

## Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL >= 5.7
- Web Server (Apache/Nginx)

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/student-course-management-system.git
   cd student-course-management-system
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure Database**
   - Create a new MySQL database
   - Update the `.env` file with your database credentials:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=your_database_name
     DB_USERNAME=your_database_username
     DB_PASSWORD=your_database_password
     ```

6. **Run Migrations and Seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Build Assets**
   ```bash
   npm run build
   ```

8. **Start the Development Server**
   ```bash
   php artisan serve
   ```

## Default Login Credentials

After running the seeders, you can log in with these default credentials:

- **Admin**
  - Email: admin@example.com
  - Password: password

## Directory Structure

```
├── app/
│   ├── Filament/         # Filament admin panel resources
│   ├── Http/            # Controllers and middleware
│   ├── Models/          # Eloquent models
│   └── Providers/       # Service providers
├── config/              # Configuration files
├── database/
│   ├── migrations/      # Database migrations
│   └── seeders/        # Database seeders
├── public/             # Public assets
├── resources/
│   ├── css/           # CSS files
│   ├── js/            # JavaScript files
│   └── views/         # Blade templates
└── routes/            # Route definitions
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For support, email support@example.com or create an issue in the repository.

## Acknowledgments

- [Laravel](https://laravel.com)
- [Filament](https://filamentphp.com)
- [Tailwind CSS](https://tailwindcss.com)
