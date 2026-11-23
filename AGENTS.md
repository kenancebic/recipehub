# RecipeHub — Development Guidelines

## 1. Project Overview

RecipeHub is a recipe-sharing and meal-planning platform developed for the WEB2001 course.

The application allows users to browse recipes, manage ingredients, save their favorite recipes, and organize meal plans.

The project uses HTML, CSS, JavaScript, Bootstrap, PHP, FlightPHP, PDO, and MySQL.

## 2. Project Structure

- `frontend/` contains the user interface.
- `frontend/css/` contains stylesheets.
- `frontend/js/` contains JavaScript functionality.
- `frontend/views/` contains HTML page templates.
- `frontend/assets/` contains static assets.
- `backend/` contains the server-side application.
- `backend/routes/` contains API route definitions.
- `backend/services/` contains business logic and validation.
- `backend/dao/` contains database access logic.
- `backend/middleware/` contains reusable middleware when implemented.
- `backend/config/` contains configuration files.
- `backend/logs/` contains application logs.
- `backend/docs/` contains API documentation, including the OpenAPI specification.
- `backend/database.sql` contains the database schema and sample data.
- `docs/` contains project documentation and planning materials.
- `docs/ERD.md` documents the database structure and relationships.
- `docs/AI_LOG.md` records AI assistance and development issues.

## 3. Technology Requirements

- Use the technologies covered by the course.
- Use HTML, CSS, JavaScript, and Bootstrap for the frontend.
- Use PHP and FlightPHP for backend routing and API functionality.
- Use PDO for database access.
- Use MySQL as the database management system.
- Use Composer to manage PHP dependencies.
- Do not introduce unrelated frameworks or libraries without approval.

## 4. Coding Guidelines

- Use descriptive variable, function, and class names.
- Keep code readable and consistently formatted.
- Avoid unnecessary code duplication.
- Separate presentation, business logic, and database access.
- Keep business logic and validation inside service classes.
- Keep database queries and database operations inside DAO classes.
- Services should be the layer that communicates with DAOs.
- Reuse common functionality when appropriate.
- Validate user input before processing it.
- Handle errors without exposing sensitive information.
- Use PDO prepared statements for database queries.
- Follow the existing project structure and coding conventions.

## 5. Security Guidelines

- Store passwords securely using appropriate password hashing.
- Never store plain-text passwords.
- Validate user input on the server side.
- Protect restricted operations with appropriate authorization when authentication is implemented.
- Do not commit database passwords, API keys, or other secrets.
- Keep local configuration files out of version control.
- Use role-based access control for restricted functionality when implemented.
- Avoid exposing sensitive application details in error messages.
- Return appropriate HTTP status codes for API responses.

## 6. Database Guidelines

- Use primary keys and foreign keys where appropriate.
- Maintain relationships between related entities.
- Use appropriate data types and constraints.
- Keep database access code in the DAO layer.
- Use prepared statements for database operations.
- Keep database credentials in local configuration files.
- Document significant database design changes in `docs/ERD.md`.
- Keep the database schema and sample data updated in `backend/database.sql`.

## 7. API Guidelines

- Define backend endpoints using FlightPHP.
- Keep route definitions inside `backend/routes/`.
- Use service classes to process application-specific logic.
- Return JSON responses from API endpoints.
- Use appropriate HTTP status codes.
- Validate incoming request data before performing database operations.
- Document API endpoints using the OpenAPI specification.
- Keep the Swagger UI documentation accessible through the project's documentation route.

## 8. External API Guidelines

- Keep third-party API communication inside a dedicated service.
- Store API keys in configuration files rather than directly in application code.
- Set reasonable connection and request timeouts.
- Handle connection failures, invalid responses, and unsuccessful HTTP status codes.
- Log relevant external API failures.
- Return user-friendly error messages without exposing internal details.
- Document external API endpoints in the OpenAPI specification.

## 9. Documentation

- Keep `README.md` updated as the project develops.
- Record AI assistance and actual issues encountered in `docs/AI_LOG.md`.
- Update the ERD when the database design changes.
- Document API endpoints in `backend/docs/openapi.yaml`.
- Keep setup instructions and project information accurate.
- Document external API functionality and local configuration requirements.

## 10. Git Workflow

- Use descriptive commit messages.
- Develop milestone work on the appropriate Git branch.
- Review changes before committing.
- Do not commit logs, secrets, passwords, API keys, or unnecessary generated files.
- Keep local configuration files excluded through `.gitignore`.
- Submit