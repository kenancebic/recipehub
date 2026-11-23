# RecipeHub — Recipe Sharing and Meal Planning Platform

## 1. Project Description

RecipeHub is a web-based recipe-sharing and meal-planning platform. It allows users to discover recipes, explore ingredients, save their favorite recipes, and organize meals.

The project is being developed as part of the WEB2001 course.

## 2. Main Features

The platform includes the following functionality:

- Browse and retrieve recipes.
- Organize recipes by categories and difficulty.
- Manage recipe ingredients.
- Save and retrieve favorite recipes.
- Create and manage meal plans.
- Schedule recipes within meal plans.
- Manage user information.
- Search for external recipes using TheMealDB API.

Authentication, authorization, and full frontend-backend integration are planned for subsequent milestones.

## 3. Technology Stack

### Frontend
- HTML5
- CSS3
- JavaScript

### Backend
- PHP 8.3
- FlightPHP
- PDO
- Composer
- cURL

### Database
- MySQL 8.4

### API Documentation
- OpenAPI 3.0.3
- Swagger UI

### External API
- TheMealDB API

## 4. Database Design

The RecipeHub database contains eight main entities:

- **Users** — registered user accounts and roles.
- **Recipes** — recipes shared on the platform.
- **Categories** — recipe categories.
- **Ingredients** — ingredients used in recipes.
- **Recipe_Ingredients** — connects recipes with ingredients and stores quantities.
- **Saved_Recipes** — records recipes saved by users.
- **Meal_Plans** — meal plans belonging to users.
- **Meal_Plan_Items** — recipes scheduled within meal plans.

The database uses primary keys, foreign keys, unique constraints, and relationships to maintain data integrity.

The entity relationship diagram is available in `docs/ERD.md`.

The database schema and sample data are available in:

`backend/database.sql`

## 5. User Roles

### Regular User

A regular user can be associated with recipes, saved recipes, and meal plans.

### Administrator

An administrator role is included in the database design.

Authentication and role-based authorization will be implemented in a subsequent milestone.

Test account credentials will be documented after authentication is implemented.

## 6. Backend Architecture

The backend follows a layered architecture.

### DAO Layer

Data Access Objects handle database operations using PDO and prepared statements.

### Service Layer

Services contain application-specific business logic, validation, and communication with DAO classes.

Services are responsible for interacting with the DAO layer.

### Presentation Layer

FlightPHP handles HTTP requests and provides REST API endpoints.

The API returns JSON responses with appropriate HTTP status codes.

### External API Service

The `ExternalApiService` communicates with TheMealDB using PHP cURL.

It includes:
- Configurable API key.
- Connection timeout and request timeout.
- HTTP response validation.
- JSON response validation.
- Error handling and logging.
- User-friendly error messages.

## 7. External API Integration

RecipeHub integrates with **TheMealDB API** to allow external recipe searches.

The backend endpoint is:

`GET /api/external/meal-search?query=chicken`

Example request:

`http://localhost:8000/api/external/meal-search?query=chicken`

The API returns matching meal information in JSON format.

The API key is stored in the backend configuration and is not exposed to the frontend.

External API errors are handled by the service and written to the backend log file.

## 8. Project Structure

```text
recipehub-m2/
├── backend/
│   ├── config/
│   ├── dao/
│   ├── docs/
│   │   └── openapi.yaml
│   ├── logs/
│   ├── routes/
│   ├── services/
│   ├── utils/
│   ├── vendor/
│   ├── database.sql
│   └── index.php
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

## 9. Local Setup

### Requirements

- PHP 8.3 or later
- MySQL 8.4 or compatible version
- Composer
- A local development environment such as Laragon

### Installation

1. Clone the repository.

2. Install backend dependencies:

```bash
cd backend
composer install
```

3. Create a MySQL database named:

`recipehub`

4. Import the database schema and sample data from:

`backend/database.sql`

5. Configure the database connection in:

`backend/config/config.php`

6. Configure the TheMealDB API key in the same configuration file.

7. Make sure the local configuration file is excluded from Git.

8. Start the backend from the `backend` directory:

```bash
php -S localhost:8000 index.php
```

9. Open the API documentation:

`http://localhost:8000/docs`

## 10. API Documentation

RecipeHub uses OpenAPI 3.0.3 to document its REST API.

Swagger UI is available locally at:

`http://localhost:8000/docs`

The OpenAPI specification is located at:

`backend/docs/openapi.yaml`

The documentation covers the available API endpoints, request parameters, request bodies, and response formats.

## 11. Logging

Backend logs are stored in:

`backend/logs/`

The external API service uses:

`backend/logs/external_api.log`

The log file is used to record external API communication failures.

## 12. Deployment

The application is currently configured for local development.

The deployment link will be added after the application is deployed.

## 13. Project Status

The project is being developed incrementally through the WEB2001 milestones.

Completed development work includes:

- Initial project structure and frontend pages.
- MySQL database design and sample data.
- DAO classes and database operations.
- Business logic services and validation.
- FlightPHP REST API routes.
- OpenAPI documentation and Swagger UI.
- TheMealDB external API integration.

Authentication, authorization, middleware, and complete frontend-backend integration are planned for subsequent milestones.
