# RecipeHub — AI Usage Log

## Purpose

This document records AI assistance used during the development of RecipeHub. Suggestions are reviewed and tested before being included in the project.

## Entry 1 — Project Planning

**Purpose:** Plan the project structure and organize the first milestone.

**AI assistance:** Helped organize the frontend, backend, documentation folders, and initial development tasks.

**Outcome:** Created the initial project folder structure.

## Entry 2 — Static Frontend

**Purpose:** Build the initial user interface.

**AI assistance:** Helped draft HTML pages, CSS styling, navigation, recipe cards, and page templates.

**Outcome:** Created the initial static frontend pages.

## Entry 3 — Recipe Search and Filtering

**Purpose:** Add search and filtering functionality to the recipes page.

**AI assistance:** Helped implement JavaScript filtering by recipe name, ingredients, category, and difficulty.

**Outcome:** Search and filtering were tested in the browser.

## Entry 4 — Dynamic Recipe Details

**Purpose:** Display the recipe selected by the user.

**AI assistance:** Helped implement session storage and dynamic updates to the recipe details page.

**Issue encountered:** The selected recipe was not always displayed because the details function could run before the page HTML had been inserted.

**Resolution:** Updated the page-loading logic to call the display function after the details page was loaded. The user tested the frontend and reported that it worked.

## Entry 5 — JavaScript Code Formatting

**Purpose:** Replace the JavaScript file with a corrected version.

**Issue encountered:** Extra formatting text was accidentally copied into the JavaScript file, causing editor errors.

**Resolution:** Removed the extra text so the file began with the correct JavaScript statement. The user confirmed that the issue was resolved.

## Entry 6 — Project Documentation

**Purpose:** Prepare documentation for the initial milestone.

**AI assistance:** Helped draft the preliminary database design, README, and development guidelines.

**Outcome:** Created `docs/ERD.md`, `README.md`, and `AGENTS.md`.

## Review and Responsibility

AI-generated suggestions are reviewed by the project developer. Functionality is tested in the browser where applicable. The developer is responsible for understanding, verifying, and maintaining the submitted code.