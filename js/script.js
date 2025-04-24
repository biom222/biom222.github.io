document.addEventListener("DOMContentLoaded", function () {
    console.log("Сайт загружен!");

    // === Бургер-меню ===
    const burger = document.querySelector('.burger');
    const navLinks = document.querySelector('.nav-links');

    if (burger && navLinks) {
        burger.addEventListener("click", function () {
            navLinks.classList.toggle("active");
        });
    }


    // === Параллакс ===
    const headers = document.querySelectorAll(".header, .contact-header");

    if (headers.length > 0) {
        window.addEventListener("scroll", function () {
            let scrollY = window.scrollY;
            headers.forEach(h => {
            });
        });
    }

    // === Анимация появления элементов (services, advantage, faq-item) ===
    const elements = document.querySelectorAll(".service, .advantage, .faq-item");
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
            }
        });
    }, { threshold: 0.5 });

    elements.forEach(el => observer.observe(el));

    // === Анимация счетчиков достижений ===
    const counters = document.querySelectorAll(".counter");
    let counterStarted = false;

    function animateCounters() {
        console.log("Анимация началась!");
        counters.forEach(counter => {
            let target = +counter.dataset.target;
            let suffix = counter.dataset.suffix || "";
            let current = 0;
            let step = Math.ceil(target / 100);

            function updateCounter() {
                if (current < target) {
                    current += step;
                    if (current > target) current = target;
                    counter.innerText = current + suffix;
                    setTimeout(updateCounter, 30);
                } else {
                    counter.innerText = target + suffix;
                }
            }

            updateCounter();
        });
    }

    function checkScrollForCounters() {
        const statsSection = document.querySelector(".stats");
        if (!statsSection) return; // <-- добавь проверку!

        const sectionTop = statsSection.getBoundingClientRect().top;
        const windowHeight = window.innerHeight;

        if (sectionTop < windowHeight && !counterStarted) {
            animateCounters();
            counterStarted = true;
        }
    }

    // Проверка при прокрутке
    window.addEventListener("scroll", checkScrollForCounters);
    // Проверка сразу, если уже видно
    checkScrollForCounters();

    // === Слайдер для отзывов ===
    const reviewSlider = document.querySelector(".review-slider");
    const reviews = document.querySelectorAll(".review");
    const prevBtn = document.querySelector(".slider-prev");
    const nextBtn = document.querySelector(".slider-next");

    let currentIndex = 0;
    const totalReviews = reviews.length;

    function showReview(index) {
        currentIndex = (index + totalReviews) % totalReviews; // Циклическая навигация
        reviewSlider.style.transition = "transform 0.5s ease-in-out";
        reviewSlider.style.transform = `translateX(-${currentIndex * 100}%)`;
    }

    if (prevBtn && nextBtn) {
        prevBtn.addEventListener("click", () => showReview(currentIndex - 1));
        nextBtn.addEventListener("click", () => showReview(currentIndex + 1));
    }

    const burgerBtn = document.querySelector('.burger');
    const navLinksMenu = document.querySelector('.nav-links');

    if (burgerBtn && navLinksMenu) {
        burgerBtn.addEventListener("click", function () {
            navLinksMenu.classList.toggle("active");
        });
    }

    // === Анимация появления элементов на странице контакты ===
    const contactBoxes = document.querySelectorAll(".contact-box");
    const contactForm = document.querySelector(".contact-form");
    const mapContainer = document.querySelector(".map-container");

    const contactElements = [...contactBoxes, contactForm, mapContainer];

    const contactObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
            }
        });
    }, { threshold: 0.5 });

    contactElements.forEach(el => {
        if (el) {
            contactObserver.observe(el);
        }
    });

    // Анимация карточек портфолио
    const portfolioItems = document.querySelectorAll('.portfolio-item');

    const portfolioObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
            }
        });
    }, { threshold: 0.5 });

    portfolioItems.forEach(item => portfolioObserver.observe(item));

    // Открытие/закрытие модалки
    const modal = document.getElementById('modal');
    const openButtons = document.querySelectorAll('.details-btn');
    const closeButton = document.getElementById('closeModal');

    // Проверяем, что модалка существует
    if (modal) {
        openButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden'; // блокируем скролл
            });
        });

        // Проверяем, что кнопка закрытия тоже существует
        if (closeButton) {
            closeButton.addEventListener('click', () => {
                modal.classList.remove('active');
                document.body.style.overflow = ''; // возвращаем скролл
            });
        }

        // Закрытие по клику вне модального контента
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }

    // Анимация появления карточек цен
    const pricingCards = document.querySelectorAll('.pricing-card');
    const pricingObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
            }
        });
    }, { threshold: 0.5 });

    pricingCards.forEach(card => pricingObserver.observe(card));

    function toggleMenu() {
        const navLinks = document.querySelector('.nav-links');
        navLinks.classList.toggle('active');
    }

    // Показать кнопку при скролле вниз
    window.onscroll = function () {
        const btn = document.getElementById("toTopBtn");
        if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
            btn.style.display = "block";
        } else {
            btn.style.display = "none";
        }
    };

    // Скролл вверх при клике
    document.getElementById("toTopBtn").onclick = function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };


});