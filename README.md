# MAW11_ABA

## Description
Copy of "ExerciseLooper" (https://exercice-looper.mycpnv.ch/), an application for create/manage quiz and answer to the different question from the quiz created.

# Getting Started
## Prerequisites
- **PHP** >= 8.2
- **MySQL** >= 8.0 or **MariaDB** >= 10.5
- Composer version 2.8.11
- IDE used (PhpStorm, Visual Studio Code)
- OS supported (Windows 11, MacOS 26.0.1)
  
### Configuration

## Installation

### 1. Clone the repository
```bash
git clone <repository-url>
cd MAW11_ABA
```

### 2. Install dependencies
```bash
composer install
```

### 3. Database setup

Execute the SQL script to create the database and tables:
```bash
mysql -u root -p < database.sql
```

Or if you prefer to execute it manually in MySQL console:
```bash
mysql -u root -p
```
Then:
```sql
source database.sql
```

### 4. Configure database connection

Create a file `Src/Models/Config.php` with your database credentials:
```php
<?php
return [
    'host' => 'localhost',
    'db' => 'Maw11Looper',
    'user' => 'root',
    'pass' => 'your_password',
    'charset' => 'utf8mb4'
];
```

### 5. Run the application

#### Using PHP built-in server (Development)
```bash
cd Public
php -S localhost:8000
```

Then open your browser at: `http://localhost:8000`

## Directory structure
```shell
MAW11_ABA/
├── Public/
│   ├── Assets/
│   │   └── logo-looper.png
│   ├── css/
│   │   ├── 404.css
│   │   ├── common.css
│   │   ├── home.css
│   │   ├── manage-exercise-fields.css
│   │   └── manage-exercise.css
│   └── index.php
│
├── Src/
│   ├── Controllers/
│   │   ├── Answers.php
│   │   ├── Exercises.php
│   │   └── Fields.php
│   │
│   ├── Models/
│   │   ├── Answer.php
│   │   ├── Config.php
│   │   ├── Database.php
│   │   ├── Exercise.php
│   │   ├── Field.php
│   │   └── TestDB.php
│   │
│   ├── Views/
│   │   ├── Answering/
│   │   │   ├── Exercises.php
│   │   │   └── Fulfillment.php
│   │   ├── Answers/
│   │   │   ├── All.php
│   │   │   ├── AllFromAField.php
│   │   │   └── One.php
│   │   ├── Errors/
│   │   │   └── 404.php
│   │   ├── Manage/
│   │   │   ├── EditField.php
│   │   │   ├── ExerciseFields.php
│   │   │   └── Exercises.php
│   │   ├── New/
│   │   │   └── Exercise.php
│   │   └── Home.php
│   │
│   ├── Dispatcher.php
│   └── Renderer.php
│
├── doc/
│   └── Documentation_maw1_1.pdf
│
├── vendor/
│
├── .gitignore
├── composer.json
├── composer.lock
├── database.sql
├── LICENSE
└── README.md
```

## Collaborate

- [Our workflow](https://nvie.com/posts/a-successful-git-branching-model/)

## License
[MIT License](LICENSE)

## Contact

amin.deabreu@eduvaud.ch / bryan.zweiacker@eduvaud.ch / aurelien.robert@eduvaud.ch