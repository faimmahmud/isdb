(() => {
    const pulse = document.getElementById("homePulse");
    if (!pulse) {
        return;
    }

    const messages = [
        "Distinct interfaces, one unified platform language.",
        "The landing page tells the story before the dashboard asks for action.",
        "Real feed data powers the showcase so the product feels alive immediately.",
        "This redesign keeps the PHP core simple while upgrading the perception dramatically."
    ];

    let index = 0;
    window.setInterval(() => {
        index = (index + 1) % messages.length;
        pulse.textContent = messages[index];
    }, 4200);
})();
