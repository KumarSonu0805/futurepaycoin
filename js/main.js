// ==========================================
// MAIN JS
// ==========================================

document.addEventListener("DOMContentLoaded", () => {

  // =========================
  // 1. LOAD COMPONENTS
  // =========================
  const loadPart = (id, url, callback) => {

    fetch(url)
      .then(res => res.text())
      .then(data => {
        document.getElementById(id).innerHTML = data;

        if (callback) callback();
      })
      .catch(err => console.error(id + " failed to load", err));

  };

  loadPart("header", "./components/header.html", initHeaderEvents);
  loadPart("footer", "./components/footer.html");


  // =========================
  // 2. PROJECT OVERVIEW PARTICLES
  // =========================

  const section = document.querySelector(".project-overview");

  if (section) {

    for (let i = 0; i < 30; i++) {

      let particle = document.createElement("span");

      particle.classList.add("particle");

      section.appendChild(particle);

      particle.style.left = Math.random() * 100 + "%";
      particle.style.top = Math.random() * 100 + "%";

    }

  }


  // =========================
  // 3. ABOUT + VISION REVEAL
  // =========================

  const boxes = document.querySelectorAll(
    ".mission-box, .vision-box, .coin-box"
  );

  const reveal = () => {

    const triggerBottom = window.innerHeight * 0.85;

    boxes.forEach(box => {

      const boxTop = box.getBoundingClientRect().top;

      if (boxTop < triggerBottom) {
        box.classList.add("show");
      }

    });

  };

  window.addEventListener("scroll", reveal);
  reveal();


  // =========================
  // 4. UTILITY OVERVIEW
  // =========================

  const utilityCards = document.querySelectorAll('.utility-card');


  // SCROLL REVEAL

  const revealObserver = new IntersectionObserver(entries => {

    entries.forEach(entry => {

      if (entry.isIntersecting) {

        entry.target.classList.add('show');
        revealObserver.unobserve(entry.target);

      }

    });

  }, { threshold: 0.15 });


  utilityCards.forEach(card => {
    revealObserver.observe(card);
  });



  // =========================
  // 5. CARD 3D TILT
  // =========================

  utilityCards.forEach(card => {

    card.addEventListener('mousemove', e => {

      const rect = card.getBoundingClientRect();

      const cx = rect.left + rect.width / 2;
      const cy = rect.top + rect.height / 2;

      const dx = (e.clientX - cx) / (rect.width / 2);
      const dy = (e.clientY - cy) / (rect.height / 2);

      card.style.transform =
        `translateY(-8px) rotateX(${-dy * 5}deg) rotateY(${dx * 5}deg)`;

    });

    card.addEventListener('mouseleave', () => {
      card.style.transform = '';
    });

  });



  // =========================
  // 6. CARD SHIMMER
  // =========================

  utilityCards.forEach(card => {

    card.addEventListener('mouseenter', () => {
      card.classList.add('shimmer');
    });

    card.addEventListener('mouseleave', () => {
      card.classList.remove('shimmer');
    });

  });



  // =========================
  // 7. NUMBER COUNTER
  // =========================

  const cardNums = document.querySelectorAll('.card-num');

  const counterObserver = new IntersectionObserver(entries => {

    entries.forEach(entry => {

      if (entry.isIntersecting) {

        const el = entry.target;

        const target = parseInt(el.textContent, 10);

        let start = 0;

        const step = setInterval(() => {

          start++;

          el.textContent = start < 10 ? '0' + start : start;

          if (start >= target) clearInterval(step);

        }, 60);

        counterObserver.unobserve(el);

      }

    });

  }, { threshold: 0.5 });


  cardNums.forEach(num => {
    counterObserver.observe(num);
  });



  // =========================
  // 8. MOBILE STAGGER DELAY
  // =========================

  if (window.innerWidth <= 768) {

    utilityCards.forEach((card, index) => {

      card.style.transitionDelay = (index * 0.12) + 's';

    });

  }

});


// ==========================================
// HEADER MENU EVENTS
// ==========================================

function initHeaderEvents() {

  const toggleBtn = document.querySelector(".fp-menu-toggle");
  const slideMenu = document.querySelector(".fp-slide-menu");
  const closeMenu = document.querySelector(".fp-slide-close");

  if (!toggleBtn || !slideMenu) {
    console.warn("Menu elements not found");
    return;
  }

  // OPEN MENU
  toggleBtn.addEventListener("click", (e) => {

    e.stopPropagation();
    slideMenu.classList.toggle("active");

  });

  // CLOSE MENU BUTTON
  if (closeMenu) {

    closeMenu.addEventListener("click", () => {

      slideMenu.classList.remove("active");

    });

  }

  // CLOSE ON LINK CLICK
  slideMenu.querySelectorAll("a").forEach(link => {

    link.addEventListener("click", () => {

      slideMenu.classList.remove("active");

    });

  });

  // CLOSE ON OUTSIDE CLICK
  document.addEventListener("click", (e) => {

    if (!slideMenu.contains(e.target) && !toggleBtn.contains(e.target)) {

      slideMenu.classList.remove("active");

    }

  });

}