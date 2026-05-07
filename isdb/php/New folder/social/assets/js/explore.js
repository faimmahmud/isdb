(() => {
    const searchInput = document.getElementById("explore_q");
    if (!searchInput) {
        return;
    }

    const placeholders = [
        "Search by caption, creator, or filename",
        "Try: mountain, hello, faim, pdf",
        "Discover posts by mood, media type, or creator",
        "Look for a file name, image theme, or short note"
    ];

    let index = 0;
    window.setInterval(() => {
        index = (index + 1) % placeholders.length;
        searchInput.placeholder = placeholders[index];
    }, 3600);
})();
