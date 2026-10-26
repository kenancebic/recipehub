const pages = {
    home: "views/home.html",
    recipes: "views/recipes.html",
    "recipe-details": "views/recipe-details.html",
    login: "views/login.html",
    register: "views/register.html",
    "saved-recipes": "views/saved-recipes.html",
    "meal-planner": "views/meal-planner.html",
    profile: "views/profile.html"
};

async function loadPage() {
    const pageContent = document.getElementById("page-content");
    let pageName = window.location.hash.substring(1) || "home";

    if (!pages[pageName]) {
        pageName = "home";
    }

    try {
        const response = await fetch(pages[pageName]);

        if (!response.ok) {
            throw new Error("Page could not be loaded.");
        }

        pageContent.innerHTML = await response.text();

        // Update the active navigation link.
        document.querySelectorAll(".navbar-nav .nav-link").forEach(link => {
            link.classList.toggle(
                "active",
                link.getAttribute("href") === `#${pageName}`
            );
        });

        // Display the selected recipe after the details HTML has loaded.
        if (pageName === "recipe-details") {
            displaySelectedRecipe();
        }

        window.scrollTo(0, 0);

    } catch (error) {
        pageContent.innerHTML = `
            <section class="container py-5 text-center">
                <h2>Unable to load this page</h2>
                <p>Please run RecipeHub using the Live Server extension in VS Code.</p>
            </section>
        `;

        console.error(error);
    }
}

// Load the correct page when the URL hash changes.
window.addEventListener("hashchange", loadPage);
window.addEventListener("DOMContentLoaded", loadPage);


// SEARCH AND FILTERS

document.addEventListener("input", function (event) {
    if (event.target.id === "recipe-search") {
        filterRecipes();
    }
});

document.addEventListener("change", function (event) {
    if (
        event.target.id === "recipe-category" ||
        event.target.id === "recipe-difficulty"
    ) {
        filterRecipes();
    }
});

function filterRecipes() {
    const searchInput = document.getElementById("recipe-search");
    const categorySelect = document.getElementById("recipe-category");
    const difficultySelect = document.getElementById("recipe-difficulty");
    const recipeItems = document.querySelectorAll(".recipe-item");
    const noRecipes = document.getElementById("no-recipes");

    if (!searchInput || !categorySelect || !difficultySelect) {
        return;
    }

    const searchTerm = searchInput.value.toLowerCase().trim();
    const selectedCategory = categorySelect.value;
    const selectedDifficulty = difficultySelect.value;

    let visibleRecipes = 0;

    recipeItems.forEach(function (recipe) {
        const name = (recipe.dataset.name || "").toLowerCase();
        const ingredients = (recipe.dataset.ingredients || "").toLowerCase();
        const category = recipe.dataset.category || "";
        const difficulty = recipe.dataset.difficulty || "";

        const matchesSearch =
            name.includes(searchTerm) ||
            ingredients.includes(searchTerm);

        const matchesCategory =
            selectedCategory === "all" ||
            category === selectedCategory;

        const matchesDifficulty =
            selectedDifficulty === "all" ||
            difficulty === selectedDifficulty;

        const matches =
            matchesSearch &&
            matchesCategory &&
            matchesDifficulty;

        recipe.classList.toggle("d-none", !matches);

        if (matches) {
            visibleRecipes++;
        }
    });

    if (noRecipes) {
        noRecipes.classList.toggle("d-none", visibleRecipes > 0);
    }
}


// SAVE THE SELECTED RECIPE

document.addEventListener("click", function (event) {
    const link = event.target.closest('a[href="#recipe-details"]');

    if (!link) {
        return;
    }

    const card = link.closest(".recipe-item");

    if (!card) {
        return;
    }

    const image = card.querySelector("img");
    const title = card.querySelector("h3");

    const recipe = {
        name: card.dataset.name ||
            (title ? title.textContent.trim() : "Recipe"),

        ingredients: card.dataset.ingredients || "",
        category: card.dataset.category || "",
        difficulty: card.dataset.difficulty || "",
        image: image ? image.src : ""
    };

    sessionStorage.setItem("selectedRecipe", JSON.stringify(recipe));
});


// DISPLAY THE SELECTED RECIPE

function displaySelectedRecipe() {
    const recipe = JSON.parse(
        sessionStorage.getItem("selectedRecipe") || "null"
    );

    const detailName = document.getElementById("detail-name");

    if (!recipe || !detailName) {
        return;
    }

    detailName.textContent = recipe.name || "Recipe Details";

    const detailDescription =
        document.getElementById("detail-description");

    if (detailDescription) {
        detailDescription.textContent =
            `Discover how to prepare ${recipe.name || "this recipe"}.`;
    }

    const detailCategory =
        document.getElementById("detail-category");

    if (detailCategory) {
        detailCategory.textContent = recipe.category || "General";
    }

    const detailDifficulty =
        document.getElementById("detail-difficulty");

    if (detailDifficulty) {
        detailDifficulty.textContent =
            recipe.difficulty || "Not specified";
    }

    const detailIngredients =
        document.getElementById("detail-ingredients");

    if (detailIngredients) {
        detailIngredients.textContent =
            recipe.ingredients || "Ingredients will be added soon.";
    }

    const detailImage =
        document.getElementById("detail-image");

    if (detailImage && recipe.image) {
        detailImage.src = recipe.image;
        detailImage.alt = recipe.name || "Selected recipe";
    }
}
