(() => {
    const toggleButtons = document.querySelectorAll("[data-password-toggle]");

    toggleButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const targetId = button.getAttribute("data-target");
            const input = targetId ? document.getElementById(targetId) : null;
            if (!input) {
                return;
            }

            const nextType = input.type === "password" ? "text" : "password";
            input.type = nextType;
            button.textContent = nextType === "password" ? "Show" : "Hide";
        });
    });
})();
