# RecipeHub — Recipe Sharing and Meal Planning Platform

## 1. Project Description

RecipeHub is a web-based recipe-sharing and meal-planning platform. It allows users to discover recipes, explore ingredients, save their favorite recipes, and organize meals.

The project is being developed as part of the WEB2001 course.

## 2. Main Features

The planned features include:

- Browse and search recipes.
- Filter recipes by category and difficulty.
- View recipe details and ingredients.
- Register and log in to a user account.
- Save favorite recipes.
- Create and manage meal plans.
- Manage user profile information.
- Provide role-based access for regular users and administrators.

## 3. Technology Stack

### Frontend
- HTML5
- CSS3
- JavaScript
- Bootstrap 5

### Backend
- PHP
- FlightPHP
- PDO

### Database
- MySQL

## 4. Database Design

The planned database includes the following entities:

- **Users** — registered user accounts and roles.
- **Recipes** — recipes shared on the platform.
- **Categories** — recipe categories.
- **Ingredients** — ingredients used in recipes.
- **Recipe_Ingredients** — connects recipes with ingredients.
- **Saved_Recipes** — records recipes saved by users.
- **Meal_Plans** — meal plans belonging to users.
- **Meal_Plan_Items** — recipes scheduled in meal plans.

The preliminary entity relationship diagram is available in `docs/ERD.md`.

## 5. User Roles

### Regular User
A regular user will be able to browse recipes, save favorites, manage meal plans, and update their profile.

### Administrator
An administrator will be able to manage platform content and perform administrative operations.

Test accounts for each role will be documented after authentication is implemented.

## 6. External API Integration

An external API will be integrated into the application as part of the project development. The specific API and its functionality will be documented once selected and implemented.

## 7. Project Structure

```text
recipehub/
├── backend/
│   ├── config/
│   ├── dao/
│   ├── logs/
│   ├── middleware/
│   ├── routes/
│   └── services/
├── docs/
│   ├── ERD.md
│   └── AI_LOG.md
├── frontend/
│   ├── assets/
│   ├── css/
│   ├── js/
│   ├── views/
│   └── index.html
├── AGENTS.md
├── README.md
└── .gitignore
```

## 8. Local Setup

The following steps will be completed as the backend and database are implemented:

1. Clone the repository.
2. Configure the PHP environment and required dependencies.
3. Create the MySQL database.
4. Import the database schema and initial data.
5. Configure the database connection.
6. Start the PHP backend.
7. Open the frontend through a local development server.

Detailed setup instructions will be updated as the application develops.

## 9. API Documentation

Swagger/OpenAPI documentation will be added when the backend API is implemented.

## 10. Deployment

The application deployment link will be added after the application is deployed.

## 11. Project Status

The initial milestone focuses on project structure, static frontend pages, navigation, and preliminary database planning. Backend functionality, database integration, authentication, and API integration will be developed in subsequent milestones.