// ===== Sticky Header =====
const header = document.querySelector("header");

window.addEventListener("scroll", () => {
    header.classList.toggle("sticky", window.scrollY > 0);
});

// ===== Navigation Menu =====
const navMenu = document.querySelector(".nav-menu");
const menuOpenButton = document.querySelector("#menu-open-button");
const menuCloseButton = document.querySelector("#menu-close-button");
const navLinks = document.querySelectorAll(".nav-link");

menuOpenButton?.addEventListener("click", () => {
    navMenu.classList.add("open");
    document.body.style.overflow = "hidden";
    console.log("Menu opened");
});

menuCloseButton?.addEventListener("click", () => {
    navMenu.classList.remove("open");
    document.body.style.overflow = "auto";
    console.log("Menu closed");
});

navLinks.forEach((link) => {
    link.addEventListener("click", () => {
        navMenu.classList.remove("open");
        document.body.style.overflow = "auto";
    });
});

// ===== Initialize Swiper =====
const swiper = new Swiper('.slider-wrapper', {
    loop: true,
    grabCursor: true,
    spaceBetween: 25,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
        dynamicBullets: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        0: { slidesPerView: 1 },
        768: { slidesPerView: 2 },
        1024: { slidesPerView: 3 }
    }
});

// ===== ScrollReveal Animations =====
const sr = ScrollReveal({
    distance: '60px',
    duration: 2500,
    delay: 400,
    reset: true
});

sr.reveal('.home-text', { delay: 200, origin: 'top' });
sr.reveal('.home-img', { delay: 300, origin: 'top' });
sr.reveal('.feature,.product,.cta-content,.contact', { delay: 200, origin: 'top' });

// ===== DOMContentLoaded: Feedback Form & Cart =====
document.addEventListener("DOMContentLoaded", () => {
    // --- Feedback Form ---
    const feedbackForm = document.getElementById("feedback-form");
    const feedbackMessage = document.getElementById("feedback-message");

    feedbackForm?.addEventListener("submit", async function(e) {
        e.preventDefault();

        try {
            const sessionRes = await fetch("http://localhost:3000/session", { credentials: "include" });
            const sessionData = await sessionRes.json();

            if (!sessionData.loggedIn) {
                feedbackMessage.textContent = "You must be logged in to submit feedback!";
                feedbackMessage.style.color = "red";
                return;
            }

            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            const res = await fetch("http://localhost:3000/feedback", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                credentials: "include",
                body: JSON.stringify({ message: data.message })
            });

            const text = await res.text();
            feedbackMessage.textContent = text;
            feedbackMessage.style.color = res.ok ? "green" : "red";

            if (res.ok) feedbackForm.reset();

        } catch (err) {
            feedbackMessage.textContent = "Server error!";
            feedbackMessage.style.color = "red";
            console.error(err);
        }
    });

    // --- Cart Functionality ---
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    const buttons = document.querySelectorAll(".add-to-cart");

    buttons.forEach(button => {
        button.addEventListener("click", () => {
            const item = button.dataset.item;
            const price = parseFloat(button.dataset.price);
            cart.push({ item, price });
            localStorage.setItem("cart", JSON.stringify(cart));
            alert(`${item} added to cart! Total items: ${cart.length}`);
        });
    });

    // Optional: display cart in console
    console.log("Current Cart:", cart);
});
