(() => {
    const root = document.body;
    const storageKey = "atlas-theme";
    const savedTheme = localStorage.getItem(storageKey);
    const prefersLight = window.matchMedia("(prefers-color-scheme: light)").matches;
    const theme = savedTheme || (prefersLight ? "light" : "dark");

    root.dataset.theme = theme;

    const toggles = document.querySelectorAll("[data-theme-toggle]");

    function syncToggle(button) {
        const nextTheme = root.dataset.theme === "light" ? "dark" : "light";
        button.textContent = root.dataset.theme === "light"
            ? button.dataset.themeLabelLight || "Light"
            : button.dataset.themeLabelDark || "Dark";
        button.setAttribute("aria-label", `Switch to ${nextTheme} mode`);
    }

    toggles.forEach(syncToggle);

    toggles.forEach((button) => {
        button.addEventListener("click", () => {
            root.dataset.theme = root.dataset.theme === "light" ? "dark" : "light";
            localStorage.setItem(storageKey, root.dataset.theme);
            toggles.forEach(syncToggle);
        });
    });

    const reveals = document.querySelectorAll("[data-reveal]");
    if ("IntersectionObserver" in window && reveals.length) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("is-visible");
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        reveals.forEach((element) => observer.observe(element));
    } else {
        reveals.forEach((element) => element.classList.add("is-visible"));
    }
})();
