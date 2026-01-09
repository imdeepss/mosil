document.addEventListener("DOMContentLoaded", () => {
  const sidebar = document.getElementById("sidebar");
  const sidebarOverlay = document.getElementById("sidebarOverlay");
  const openSidebarBtn = document.getElementById("openSidebar");
  const closeSidebarBtn = document.getElementById("closeSidebar");

  // Search Results Logic
  const setupSearchInput = (input) => {
    if (!input) return;
    const parent = input.parentElement;
    const results = parent.querySelector(".search-results");

    if (results) {
      const showResults = () => {
        if (input.value.trim().length > 0) {
          results.classList.remove("hidden");
        } else {
          results.classList.add("hidden");
        }
      };

      input.addEventListener("input", showResults);
      input.addEventListener("focus", showResults);

      // Hide on click outside
      document.addEventListener("click", (e) => {
        if (!parent.contains(e.target)) {
          results.classList.add("hidden");
        }
      });
    }
  };

  // Setup Desktop Search
  const desktopSearchInput = document.querySelector('input[name="search"]');
  setupSearchInput(desktopSearchInput);

  // Setup Mobile Search (Wait for DOM update or standard selector)
  const mobileSearchInput = document.querySelector("#mobileSearchBar input");
  setupSearchInput(mobileSearchInput);

  // Mobile Search Elements
  const openMobileSearchBtn = document.getElementById("openMobileSearch");
  const mobileSearchBar = document.getElementById("mobileSearchBar");
  const openSidebarImg = openSidebarBtn
    ? openSidebarBtn.querySelector("img")
    : null;

  // Store original menu icon
  const menuIconSrc = openSidebarImg ? openSidebarImg.src : "";
  const closeIconSrc = "assets/icons/png/x.png"; // Assuming this path exists based on other usages

  let isSearchOpen = false;

  // Function to toggle Search Mode
  function toggleSearch(open) {
    if (!mobileSearchBar || !openSidebarImg) return;
    isSearchOpen = open;

    if (open) {
      mobileSearchBar.classList.add("w-full");
      // Change Hamburger to Close Icon
      openSidebarImg.src = openSidebarImg.src.replace("menu.png", "x.png");
      // Ensure search input is focused
      const input = mobileSearchBar.querySelector("input");
      if (input) input.focus();
    } else {
      mobileSearchBar.classList.remove("w-full");
      // Revert Hamburger Icon
      openSidebarImg.src = menuIconSrc;
    }
  }

  if (openMobileSearchBtn) {
    openMobileSearchBtn.addEventListener("click", () => {
      toggleSearch(true);
    });
  }

  /**
   * Toggle Sidebar using Tailwind Utility Classes
   * @param {boolean} show - Whether to show or hide the sidebar
   */
  function toggleSidebar(show) {
    if (!sidebar || !sidebarOverlay) return;

    if (show) {
      sidebar.classList.remove("translate-x-full", "invisible");
      sidebarOverlay.classList.remove("hidden");
      setTimeout(() => sidebarOverlay.classList.add("opacity-100"), 10);
      document.body.classList.add("overflow-hidden");
    } else {
      sidebar.classList.add("translate-x-full", "invisible");
      sidebarOverlay.classList.remove("opacity-100");
      setTimeout(() => sidebarOverlay.classList.add("hidden"), 300);
      document.body.classList.remove("overflow-hidden");
    }
  }

  if (openSidebarBtn) {
    openSidebarBtn.addEventListener("click", (e) => {
      e.stopPropagation();

      // IF Search is open, clicking this button should CLOSE search, NOT open sidebar
      if (isSearchOpen) {
        toggleSearch(false);
        return;
      }

      toggleSidebar(true);
    });
  }

  if (closeSidebarBtn) {
    closeSidebarBtn.addEventListener("click", () => toggleSidebar(false));
  }

  if (sidebarOverlay) {
    sidebarOverlay.addEventListener("click", () => toggleSidebar(false));
  }

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") toggleSidebar(false);
  });

  const hasSubmenu = document.querySelectorAll(".has-submenu");

  hasSubmenu.forEach((item) => {
    const toggleBtn = item.querySelector(".submenu-toggle");

    // Find the submenu wrapper (div with grid)
    const submenuWrapper = item.querySelector(".submenu-wrapper");
    // Find the icons
    const plusIcon = item.querySelector(".plus-icon");
    const minusIcon = item.querySelector(".minus-icon");

    if (toggleBtn && submenuWrapper) {
      toggleBtn.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();

        // Toggle the grid expansion
        submenuWrapper.classList.toggle("grid-rows-[1fr]");

        // Toggle icons if they exist
        if (plusIcon && minusIcon) {
          plusIcon.classList.toggle("hidden");
          minusIcon.classList.toggle("hidden");
        }
      });
    }
  });

  const observerOptions = { threshold: 0.5 };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const counters = entry.target.querySelectorAll(".counter");
        counters.forEach((counter) => {
          const target = +counter.getAttribute("data-target");
          const duration = 2000;
          const increment = target / (duration / 16);

          let current = 0;
          const updateCount = () => {
            current += increment;
            if (current < target) {
              counter.innerText = Math.ceil(current);
              requestAnimationFrame(updateCount);
            } else {
              counter.innerText = target;
            }
          };
          updateCount();
        });
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  const statsSection = document.querySelector(".animate-slide-right");
  if (statsSection) observer.observe(statsSection);

  const swiper = new Swiper(".industrySwiper", {
    slidesPerView: 1.2,
    spaceBetween: 20,
    loop: true,
    speed: 800,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: ".swiper-next",
      prevEl: ".swiper-prev",
    },
    breakpoints: {
      1024: {
        slidesPerView: 2.5,
      },
    },
    on: {
      slideChange: function () {
        const activeSlide = this.slides[this.activeIndex];

        const title = activeSlide.getAttribute("data-title");
        const tagline = activeSlide.getAttribute("data-tagline");
        const desc = activeSlide.getAttribute("data-desc");
        const link = activeSlide.getAttribute("data-link"); // Get the link

        const contentBox = document.querySelector(
          ".relative.z-10.flex.flex-col.gap-4"
        );

        contentBox.style.opacity = "0";

        setTimeout(() => {
          document.querySelector(".industry-title").innerText = title;
          document.querySelector(".industry-tagline").innerText = tagline;
          document.querySelector(".industry-desc").innerText = desc;
          const linkEl = document.querySelector(".industry-link");
          if (linkEl) linkEl.href = link; // Update the link href

          contentBox.style.opacity = "1";
          contentBox.style.transition = "opacity 0.4s ease";
        }, 300);
      },
    },
  });

  const mobilePrev = document.querySelector(".industry-mobile-prev");
  const mobileNext = document.querySelector(".industry-mobile-next");

  if (mobilePrev) {
    mobilePrev.addEventListener("click", () => swiper.slidePrev());
  }

  if (mobileNext) {
    mobileNext.addEventListener("click", () => swiper.slideNext());
  }

  // const brandSwiper = new Swiper(".logoSwiper", {
  //   slidesPerView: "auto",
  //   spaceBetween: 50,
  //   loop: true,
  //   speed: 1000,
  //   allowTouchMove: false,
  //   autoplay: {
  //     delay: 0,
  //     disableOnInteraction: false,
  //     pauseOnMouseEnter: false,
  //   },
  //   breakpoints: {
  //     768: {
  //       slidesPerView: 3,
  //       spaceBetween: 20,
  //     },
  //   },
  // });

  const brandSwiper = new Swiper(".logoSwiper", {
    slidesPerView: 3,
    spaceBetween: 20,

    loop: true,
    speed: 1000,
    allowTouchMove: false,
    autoplay: {
      delay: 0,
      disableOnInteraction: false,
      pauseOnMouseEnter: false,
    },

    breakpoints: {
      768: {
        slidesPerView: 4,
        spaceBetween: 50,
      },
    },
  });

  const newsSwiper = new Swiper(".newsSwiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    navigation: {
      nextEl: ".news-next",
      prevEl: ".news-prev",
    },
    breakpoints: {
      768: {
        enabled: false,
        slidesPerView: 3,
        spaceBetween: 32,
      },
    },
  });

  const edgeSwiper = new Swiper(".edgeSwiper", {
    effect: "fade",
    fadeEffect: {
      crossFade: true,
    },
    speed: 1500, // Smooth transition speed
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    autoplay: {
      delay: 4000,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
      renderBullet: function (index, className) {
        return (
          '<span class="' +
          className +
          ' swiper-pagination-bullet-custom"></span>'
        );
      },
    },
    breakpoints: {
      768: {
        slidesPerView: 1,
      },
    },
  });

  // New Swiper Initializations for Product Detail Page
  const relevantProductsSwiper = new Swiper(".relevantProductsSwiper", {
    slidesPerView: 1.2,
    spaceBetween: 16,
    loop: true,
    breakpoints: {
      768: {
        slidesPerView: 3.2,
        spaceBetween: 20,
      },
    },
  });

  const caseStudySwiper = new Swiper(".caseStudySwiper", {
    slidesPerView: 1.2,
    spaceBetween: 16,
    loop: true,
    breakpoints: {
      768: {
        slidesPerView: 3.2,
        spaceBetween: 20,
      },
    },
  });

  // Counter animation logic
  const counters = document.querySelectorAll(".counter");
  const animateCounter = (counter) => {
    const target = parseInt(counter.dataset.target);
    let current = 0;
    const increment = target / 200; // Adjust speed here

    const updateCounter = () => {
      if (current < target) {
        current += increment;
        counter.innerText = Math.ceil(current);
        requestAnimationFrame(updateCounter);
      } else {
        counter.innerText = target;
      }
    };
    updateCounter();
  };

  const section = document.querySelector(".bg-main-green"); // The right panel section
  // const observer = new IntersectionObserver(
  //   (entries, observer) => {
  //     entries.forEach((entry) => {
  //       if (entry.isIntersecting) {
  //         counters.forEach(animateCounter);
  //         observer.disconnect(); // Stop observing once animated
  //       }
  //     });
  //   },
  //   { threshold: 0.5 }
  // ); // Trigger when 50% of the section is visible

  if (section) observer.observe(section);

  const historySwiper = new Swiper(".our-history-swiper", {
    slidesPerView: 1,
    spaceBetween: 30,
    speed: 800,
    loop: true,
    navigation: {
      nextEl: ".history-next",
      prevEl: ".history-prev",
    },
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
  });

  const whoWeAreSwiper = new Swiper(".who-we-are-swiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    navigation: {
      nextEl: ".who-we-are-next",
      prevEl: ".who-we-are-prev",
    },
    breakpoints: {
      768: {
        enabled: false,
        slidesPerView: 5,
        spaceBetween: 20,
      },
    },
  });
});
