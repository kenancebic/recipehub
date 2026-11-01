# RecipeHub — Development Guidelines

## 1. Project Overview

RecipeHub is a recipe-sharing and meal-planning platform developed for the WEB2001 course.

The application uses HTML, CSS, JavaScript, Bootstrap, PHP, FlightPHP, PDO, and MySQL.

## 2. Project Structure

- `frontend/` contains the user interface.
- `frontend/css/` contains stylesheets.
- `frontend/js/` contains JavaScript functionality.
- `frontend/views/` contains HTML page templates.
- `frontend/assets/` contains static assets.
- `backend/routes/` contains API route definitions.
- `backend/services/` contains business logic.
- `backend/dao/` contains database access logic.
- `backend/middleware/` contains reusable middleware.
- `backend/config/` contains configuration files.
- `backend/logs/` contains application logs.
- `docs/` contains project documentation and planning materials.

## 3. Technology Requirements

- Use the technologies covered by the course.
- Use HTML, CSS, JavaScript, and Bootstrap for the frontend.
- Use PHP and FlightPHP for backend routing and API functionality.
- Use PDO for database access.
- Use MySQL as the database.
- Do not introduce unrelated frameworks or libraries without approval.

## 4. Coding Guidelines

- Use descriptive variable and function names.
- Keep code readable and consistently formatted.
- Avoid unnecessary duplication.
- Separate presentation, business logic, and database access.
- Reuse common functionality when appropriate.
- Validate user input before processing it.
- Handle errors without exposing sensitive information.
- Use prepared statements for database queries.

## 5. Security Guidelines

- Store passwords securely using appropriate password hashing.
- Never store plain-text passwords.
- Validate and authorize protected operations on the server.
- Do not commit database passwords, API keys, or other secrets.
- Use role-based access control for restricted functionality.
- Avoid exposing sensitive application details in error messages.

## 6. Database Guidelines

- Use primary keys and foreign keys where appropriate.
- Maintain relationships between related entities.
- Use appropriate data types and constraints.
- Keep database access code in the DAO layer.
- Document significant database design changes in `docs/ERD.md`.

## 7. Documentation

- Keep `README.md` updated as the project develops.
- Record AI assistance and actual issues encountered in `docs/AI_LOG.md`.
- Update the ERD when the database design changes.
- Document API endpoints when backend development begins.

## 8. Git Workflow

- Use descriptive commit messages.
- Develop milestone work on the appropriate Git branch.
- Review changes before committing.
- Do not commit logs, secrets, or unnecessary generated files.
- Submit milestone work through a Pull Request for review.

## 9. AI Usage

AI assistance may be used for explanations, debugging, planning, and code suggestions. All generated code must be reviewed, tested, and understood before submission.