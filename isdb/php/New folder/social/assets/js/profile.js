(() => {
    const buttons = document.querySelectorAll("[data-profile-tab]");
    const posts = document.querySelectorAll("[data-profile-kind]");

    if (!buttons.length || !posts.length) {
        return;
    }

    buttons.forEach((button) => {
        button.addEventListener("click", () => {
            const target = button.getAttribute("data-profile-tab") || "all";

            buttons.forEach((entry) => entry.classList.toggle("is-active", entry === button));

            posts.forEach((post) => {
                const kind = post.getAttribute("data-profile-kind");
                const visible = target === "all" || kind === target;
                post.classList.toggle("is-hidden", !visible);
            });
        });
    });
})();
