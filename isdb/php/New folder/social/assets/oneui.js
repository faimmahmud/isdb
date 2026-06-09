document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.createElement("canvas");
    canvas.className = "ambient-canvas";
    canvas.style.position = "fixed";
    canvas.style.inset = "0";
    canvas.style.width = "100vw";
    canvas.style.height = "100vh";
    canvas.style.zIndex = "1";
    canvas.style.pointerEvents = "none";
    document.body.appendChild(canvas);

    const ctx = canvas.getContext("2d");
    let w = 0, h = 0, dots = [];

    function resize() {
        w = canvas.width = window.innerWidth;
        h = canvas.height = window.innerHeight;
        dots = [];
        const count = window.innerWidth < 800 ? 36 : 78;

        for (let i = 0; i < count; i++) {
            dots.push({
                x: Math.random() * w,
                y: Math.random() * h,
                r: Math.random() * 1.6 + 0.4,
                vx: Math.random() * 0.22 - 0.11,
                vy: Math.random() * -0.35 - 0.08,
                a: Math.random() * 0.4 + 0.18
            });
        }
    }

    function draw() {
        ctx.clearRect(0, 0, w, h);

        for (const d of dots) {
            d.x += d.vx;
            d.y += d.vy;

            if (d.y < -10) d.y = h + 10;
            if (d.x < -10) d.x = w + 10;
            if (d.x > w + 10) d.x = -10;

            ctx.beginPath();
            ctx.arc(d.x, d.y, d.r, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(255,255,255,${d.a})`;
            ctx.shadowBlur = 10;
            ctx.shadowColor = "rgba(125,211,252,.35)";
            ctx.fill();
        }

        requestAnimationFrame(draw);
    }

    window.addEventListener("resize", resize);
    resize();
    draw();
});