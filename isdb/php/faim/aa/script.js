document.addEventListener("DOMContentLoaded", () => {
  const revealEls = document.querySelectorAll(".reveal");
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) entry.target.classList.add("show");
    });
  }, { threshold: 0.12 });

  revealEls.forEach((el) => observer.observe(el));

  const counts = document.querySelectorAll("[data-count]");
  const countObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) return;
      const el = entry.target;
      const target = parseInt(el.dataset.count, 10);
      let current = 0;
      const step = Math.max(1, Math.ceil(target / 60));
      const timer = setInterval(() => {
        current += step;
        if (current >= target) {
          current = target;
          clearInterval(timer);
        }
        el.textContent = current;
      }, 20);
      countObserver.unobserve(el);
    });
  }, { threshold: 0.45 });

  counts.forEach((el) => countObserver.observe(el));

  const bookingForm = document.getElementById("bookingForm");
  if (bookingForm) {
    bookingForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const data = Object.fromEntries(new FormData(bookingForm).entries());
      console.log("Booking check:", data);
      alert("Booking details checked. Open console to see data.");
    });
  }

  const contactForm = document.getElementById("contactForm");
  if (contactForm) {
    contactForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const data = Object.fromEntries(new FormData(contactForm).entries());
      console.log("Contact submission:", data);

      try {
        const response = await fetch("submit.php", {
          method: "POST",
          body: new FormData(contactForm)
        });
        const result = await response.json();
        console.log("PHP response:", result);
        alert(result.message || "Submitted successfully.");
        contactForm.reset();
      } catch (err) {
        console.error(err);
        alert("Form submission failed.");
      }
    });
  }
});