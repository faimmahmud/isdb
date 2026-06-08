(() => {
    const pulse = document.getElementById("dashboardPulse");
    const fileInput = document.getElementById("media");
    const fileHint = document.getElementById("dashboardFileHint");

    if (pulse) {
        const messages = [
            "Post from here, then open Explore to see the content reframed as a discovery gallery.",
            "Your profile page now tracks completion, publishing mix, and personal feed history.",
            "Each major page has a separate art direction while the product still feels connected.",
            "This dashboard stays practical while the rest of the product expands around it."
        ];

        let index = 0;
        window.setInterval(() => {
            index = (index + 1) % messages.length;
            pulse.textContent = messages[index];
        }, 4300);
    }

    if (fileInput && fileHint) {
        fileInput.addEventListener("change", () => {
            const file = fileInput.files && fileInput.files[0];
            fileHint.textContent = file
                ? `Selected: ${file.name} (${Math.max(1, Math.round(file.size / 1024))} KB)`
                : "Supported: JPG, PNG, GIF, WEBP, PDF, TXT, DOC, DOCX, ZIP. Max size 10MB.";
        });
    }
})();
