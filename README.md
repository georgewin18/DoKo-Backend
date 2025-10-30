
# DoKo - Backend API

## Description

This is a simple backend API developed using **Laravel** to manage task groups and tasks. The API supports CRUD (Create, Read, Update, Delete) operations for two main entities: `Task Group` and `Task`.

## Technologies Used
- **Laravel**: The PHP framework used to build the backend API.
- **Supabase**: The cloud database platform providing a PostgreSQL database.
- **PHP**: the primary programming language.
- **Composer**: A dependency manager for Laravel and PHP.

## Instalation and Setup

Follow these steps to get the project running on your local machine.

### 1. System Requirements

Ensure you have the following software installed:
- **PHP** (version 8.2 or newer)
- **Composer**

### 2. Getting Started

1. clone this repository:

```bash
git clone https://github.com/pens-pbl/2025-doko-backend.git .
cd 2025-doko-backend
```

2. Install all PHP dependencies with Composer:

```bash
composer install
```

3. Create `.env` file according to the `.env.example` file:

```bash
cp .env.example .env
```

### `.env` Configuration

Open the newly created `.env` file and configure the connection to your Supabase database.

You must provide the complete `DATABASE_URL` obtained from your Supabase Dashboard.

```bash
DB_CONNECTION=pgsql
# Get your DB_URL from your project Dashboard > Connect > Choose the Session Pooler
DB_URL="postgres://[USER]:[PASSWORD]@[HOST]:[PORT]/[DATABASE-NAME]
```

### Running the project

Once the setup is complete, you can run the backend with the following steps

1. Run Database Migrations
This command will create all necesary tables in your Supabase database.

```bash
php artisan migrate
```

2. Run Seeders (Optional, for populating initial data)
This command will fill your tables with dummy data useful for testing

```bash
php artisan db:seed
```

3. Start the Laravel Server
This command will start the local development server at `http://127.0.0.1:8000`


```bash
php artisan serve
```

### API Endpoints

Here is a list of the available API endpoints for managing `TaskGroup`, `Task`, and `FocusTimer` resources:


| Method   | URI                     | Descriptiton                        |
|----------|-------------------------|-------------------------------------|
| `GET`    | `/api/task-groups`      | Retrieve all task groups.           |
| `GET`    | `/api/task-groups/{id}` | Retrieve a single task group by ID. |
| `POST`   | `/api/task-groups`      | Create a new task group.            |
| `PUT`    | `/api/task-groups/{id}` | Update a task group's data.         |
| `DELETE` | `/api/task-groups/{id}` | Delete a task group.                |
| `GET`    | `/api/tasks`            | Retrieve all tasks.                 |
| `GET`    | `/api/tasks/{id}`       | Retrieve a single task by ID.       |
| `POST`   | `/api/tasks`            | Create a new task.                  |
| `PUT`    | `/api/tasks/{id}`       | Update a task's data.               |
| `DELETE` | `/api/tasks/{id}`       | Delete a task.                      |
| `GET`    | `/api/focus-timer`      | Retrieve focus timer.               |
| `GET`    | `/api/focus-timer/{id}` | Retrieve a single focus timer by ID.|
| `POST`   | `/api/focus-timer`      | Create a new focus timer.           |
| `PUT`    | `/api/focus-timer/{id}` | Update a focus timer's data.        |
| `DELETE` | `/api/focus-timer/{id}` | Delete a focus timer.               |

### Unit Test

This project includes controller unit tests using Repository Mocking. This isolates controller logic from the database, allowing for fast execution.
These tests verify that controllers call the correct repository methods and return the expected JSON responses.

Here's the command to run the tests:

- Task Group Test:
  ```bash
  php artisan test tests/Unit/TaskGroupControllerTest.php
  ```
  
- Task Test:
  ```bash
  php artisan test tests/Unit/TaskControllerTest.php
  ```
  
- Focus Timer Test:
  ```bash
  php artisan test tests/Unit/FocusTimerControllerTest.php
  ```
