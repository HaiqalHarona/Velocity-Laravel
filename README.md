# Task Collab

A task collaboration and budget management system built with Laravel. This application allows users to manage tasks, workspaces, and projects with support for Google and GitHub authentication.

## Requirements

- PHP 8.2 or higher
- Composer
- MySQL
- Node.js & NPM

## Installation

1. Clone the repository
   git clone https://github.com/haiqalharona/task-collab.git
   cd task-collab/notion-budget

2. Install PHP dependencies
   composer install

3. Install Frontend dependencies
   npm install

4. Environment Setup
   cp .env.example .env

5. Generate Application Key
   php artisan key:generate

6. Configure Database
   Open the .env file and update your database settings:
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=notion_budget
   DB_USERNAME=root
   DB_PASSWORD=

7. Run Migrations
   php artisan migrate

## Social Login Setup (Google & GitHub)

To enable social login, you must add your API keys to the .env file.

1. Open .env and add the following lines:

   GITHUB_CLIENT_ID=your_github_client_id
   GITHUB_CLIENT_SECRET=your_github_client_secret
   GITHUB_REDIRECT_URI=http://localhost:8000/auth/github/callback

   GOOGLE_CLIENT_ID=your_google_client_id
   GOOGLE_CLIENT_SECRET=your_google_client_secret
   GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

2. Ensure your Redirect URIs in the Google/GitHub developer consoles match the URIs above exactly.

## Running the Application

1. Start the local server
   php artisan serve

2. Start the frontend build process (in a separate terminal)
   npm run dev

3. Access the application
   Open http://localhost:8000 in your browser.

## Features

- User Authentication (Login/Register)
- Social Login (Google & GitHub)
- Dashboard overview
- Task and Project management
- Workspace collaboration

## License

This project is open-sourced software licensed under the MIT license.
