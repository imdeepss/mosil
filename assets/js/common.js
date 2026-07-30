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

      // Hide results container if open
      const results = mobileSearchBar.querySelector(
        ".search-results-container",
      );
      if (results) results.classList.add("hidden");
    }
  }

  if (openMobileSearchBtn) {
    openMobileSearchBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      if (typeof openEvaModal === "function") {
        openEvaModal();
      }
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
      setTimeout(() => sidebarOverlay.classList.add("opacity-50"), 10);
      document.body.classList.add("overflow-hidden");
    } else {
      sidebar.classList.add("translate-x-full", "invisible");
      sidebarOverlay.classList.remove("opacity-50");
      setTimeout(() => sidebarOverlay.classList.add("hidden"), 300);
      document.body.classList.remove("overflow-hidden");
    }
  }

  if (openSidebarBtn) {
    openSidebarBtn.addEventListener("click", (e) => {
      e.stopPropagation();
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
    slidesPerView: "auto",
    centeredSlides: false,
    spaceBetween: 16,
    loop: true,
    loopedSlides: 5, // Ensure enough duplicates for smooth loop with auto width
    loopAdditionalSlides: 2,
    watchSlidesProgress: true, // Improves visibility calculation
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
        slidesPerView: "auto",
        centeredSlides: false, // Keep desktop left-aligned
        spaceBetween: 20,
      },
    },
    on: {
      slideChange: function () {
        const activeSlide = this.slides[this.activeIndex];
        if (!activeSlide) return;

        const title = activeSlide.getAttribute("data-title");
        const tagline = activeSlide.getAttribute("data-tagline");
        const desc = activeSlide.getAttribute("data-desc");
        const link = activeSlide.getAttribute("data-link");

        const titleEl = document.querySelector(".industry-title");
        const taglineEl = document.querySelector(".industry-tagline");
        const descEl = document.querySelector(".industry-desc");
        const linkEl = document.querySelector(".industry-link");

        if (titleEl) titleEl.innerText = title;
        if (taglineEl) taglineEl.innerText = tagline;
        if (descEl) descEl.innerText = desc;
        if (linkEl) linkEl.href = link;
      },
    },
  });

  const mobilePrevBtns = document.querySelectorAll(".industry-mobile-prev");
  const mobileNextBtns = document.querySelectorAll(".industry-mobile-next");

  mobilePrevBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.stopPropagation();
      swiper.slidePrev();
    });
  });

  mobileNextBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.stopPropagation();
      swiper.slideNext();
    });
  });

  const contentSwiper = new Swiper(".contentSwiper", {
    effect: "fade",
    fadeEffect: { crossFade: true },
    allowTouchMove: false,
    speed: 300,
    loop: true,
    slidesPerView: 1,
  });

  const imageSwiper = new Swiper(".imageSwiper", {
    slidesPerView: "auto",
    spaceBetween: 20,
    loop: true,
    speed: 300,
    centeredSlides: false,
    grabCursor: true,
    navigation: {
      nextEl: ".nav-next",
      prevEl: ".nav-prev",
    },

    on: {
      init: function () {
        this.slides[this.activeIndex].classList.add("is-expanded");
        this.update();
      },

      slideChangeTransitionStart: function () {
        contentSwiper.slideToLoop(this.realIndex);

        const activeIndex = this.activeIndex;
        const slides = this.slides;

        // Manually correct translation on desktop to account for width change
        // This prevents the carousel from overshooting/rubber-banding because Swiper
        // calculates position based on the "expanded" width of the previous slide,
        // but we are shrinking it during the transition.
        if (window.innerWidth >= 1024) {
          const collapsedWidth = 270;
          const gap = 20;
          const stride = collapsedWidth + gap;
          // Calculate where the wrapper SHOULD be if all previous slides were collapsed
          const targetTranslate = -1 * activeIndex * stride;

          this.setTranslate(targetTranslate);
        }

        for (let i = 0; i < slides.length; i++) {
          if (i === activeIndex) {
            slides[i].classList.add("is-expanded");
          } else {
            slides[i].classList.remove("is-expanded");
          }
        }
      },

      slideChangeTransitionEnd: function () {
        this.update();
      },
    },
  });
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
    slidesPerView: "auto",
    spaceBetween: 20,
    loop: true,
    speed: 1000,
    allowTouchMove: false,
    freeMode: true,
    autoplay: {
      delay: 0,
      disableOnInteraction: false,
    },
    easing: "linear",

    breakpoints: {
      768: {
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
    slidesPerView: 2,
    spaceBetween: 16,
    loop: false,
    speed: 600,
    navigation: {
      nextEl: ".relevant-next",
      prevEl: ".relevant-prev",
    },
    breakpoints: {
      768: {
        slidesPerView: "auto", // Set to auto to respect CSS fixed width
        spaceBetween: 20,
      },
    },
  });

  // Manually bind navigation for multiple buttons (Mobile/Desktop)
  document.querySelectorAll(".relevant-prev").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      relevantProductsSwiper.slidePrev();
    });
  });
  document.querySelectorAll(".relevant-next").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      relevantProductsSwiper.slideNext();
    });
  });

  const caseStudySwiper = new Swiper(".caseStudySwiper", {
    slidesPerView: 1,
    spaceBetween: 16,
    loop: false,
    speed: 600,
    navigation: {
      nextEl: ".case-next",
      prevEl: ".case-prev",
    },
    breakpoints: {
      768: {
        slidesPerView: "auto",
        spaceBetween: 40,
      },
    },
  });

  // Manually bind navigation for multiple buttons (Mobile/Desktop)
  document.querySelectorAll(".case-prev").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      caseStudySwiper.slidePrev();
    });
  });
  document.querySelectorAll(".case-next").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      caseStudySwiper.slideNext();
    });
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
    effect: "fade",
    fadeEffect: {
      crossFade: true,
    },
    speed: 0,
    loop: false,
    navigation: {
      nextEl: ".history-next",
      prevEl: ".history-prev",
    },
  });

  const whoWeAreSwiper = new Swiper(".who-we-are-swiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: false,
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

  // Global Contact Modal Logic
  const globalModal = document.getElementById("globalContactModal");
  const openGlobalBtns = document.querySelectorAll(
    ".open-global-contact-modal",
  );
  const closeGlobalBtn = document.getElementById("closeGlobalContactModal");
  const globalBackdrop = document.getElementById("globalContactBackdrop");
  const stickyBtn = document.querySelector(".mosil-contact-sticky");
  const globalForm = document.getElementById("globalContactForm");

  function toggleGlobalModal(show) {
    if (!globalModal) return;

    if (show) {
      globalModal.classList.remove("hidden");
      document.body.style.overflow = "hidden";
      if (stickyBtn) stickyBtn.style.display = "none";
    } else {
      globalModal.classList.add("hidden");
      document.body.style.overflow = "";
      if (stickyBtn) stickyBtn.style.display = ""; // Restore default display
    }
  }

  if (openGlobalBtns) {
    openGlobalBtns.forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.preventDefault();
        toggleGlobalModal(true);
      });
    });
  }

  if (closeGlobalBtn) {
    closeGlobalBtn.addEventListener("click", () => toggleGlobalModal(false));
  }

  if (globalBackdrop) {
    globalBackdrop.addEventListener("click", () => toggleGlobalModal(false));
  }

  document.addEventListener("keydown", (e) => {
    if (
      e.key === "Escape" &&
      globalModal &&
      !globalModal.classList.contains("hidden")
    ) {
      toggleGlobalModal(false);
    }
  });

  // Global Contact Form Submission
  if (globalForm) {
    // Validation Setup (Reusable from contact page logic)
    const validators = {
      email: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
      tel: (value) => /^[0-9+\-\s]{10,}$/.test(value),
      pincode: (value) => /^[0-9]{4,6}$/.test(value.trim()),
      default: (value) => value.trim().length > 0,
    };

    const validateField = (input) => {
      let type = "default";
      if (input.name === "email") type = "email";
      else if (input.name === "contact") type = "tel";
      else if (input.name === "pincode") type = "pincode";

      const isValid = validators[type](input.value);
      const wrapper = input.parentElement;
      const errorMsg = wrapper.querySelector(".error-text");

      if (!isValid) {
        input.classList.add("input-error");
        if (errorMsg) errorMsg.classList.remove("hidden");
      } else {
        input.classList.remove("input-error");
        if (errorMsg) errorMsg.classList.add("hidden");
      }
      return isValid;
    };

    // Live validation
    const inputs = globalForm.querySelectorAll("input, textarea");
    inputs.forEach((input) => {
      input.addEventListener("blur", () => {
        if (input.value.trim() !== "") validateField(input);
      });
      input.addEventListener("input", () => {
        if (input.classList.contains("input-error")) {
          input.classList.remove("input-error");
          const wrapper = input.parentElement;
          const errorMsg = wrapper.querySelector(".error-text");
          if (errorMsg) errorMsg.classList.add("hidden");
        }
      });
    });

    globalForm.addEventListener("submit", function (e) {
      e.preventDefault();

      let isFormValid = true;
      inputs.forEach((input) => {
        if (!validateField(input)) isFormValid = false;
      });

      if (!isFormValid) return;

      const btn = document.getElementById("globalSubmitBtn");
      const responseDiv = document.getElementById("globalContactResponse");
      const formData = new FormData(globalForm);

      // Disable UI
      const originalText = btn.innerText;
      btn.disabled = true;
      btn.innerText = "Sending...";
      responseDiv.classList.add("hidden");

      fetch(`${SITE_URL}/ajax/contact.php`, {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            responseDiv.innerText =
              data.message === "success"
                ? "Thank you! Your message has been sent successfully."
                : data.message;
            responseDiv.className =
              "mb-4 p-2 rounded text-center text-sm font-medium bg-green-100 text-green-700";
            responseDiv.classList.remove("hidden");
            globalForm.reset();
            inputs.forEach((i) => i.classList.remove("input-error"));
            // Auto close after success
            setTimeout(() => {
              toggleGlobalModal(false);
              responseDiv.classList.add("hidden");
            }, 3000);
          } else {
            throw new Error(data.message || "Something went wrong.");
          }
        })
        .catch((err) => {
          console.error(err);
          responseDiv.innerText =
            err.message || "An unexpected error occurred. Please try again.";
          responseDiv.className =
            "mb-4 p-2 rounded text-center text-sm font-medium bg-red-100 text-red-700";
          responseDiv.classList.remove("hidden");
        })
        .finally(() => {
          btn.disabled = false;
          btn.innerText = originalText;
        });
    });
  }

  // Footer Subscribe Form
  const subscribeForm = document.getElementById("footerSubscribeForm");
  if (subscribeForm) {
    subscribeForm.addEventListener("submit", function (e) {
      e.preventDefault();

      const emailInput = subscribeForm.querySelector('input[name="subscribe_email"]');
      const responseDiv = document.getElementById("footerSubscribeResponse");
      const btn = subscribeForm.querySelector("button[type='submit']");
      const email = emailInput.value.trim();

      // Simple email validation
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        responseDiv.innerText = "Please enter a valid email address.";
        responseDiv.className = "mt-2 text-xs font-medium text-red-500 hidden";
        responseDiv.classList.remove("hidden");
        return;
      }

      const originalText = btn.innerHTML;
      btn.disabled = true;
      btn.innerText = "Sending...";
      responseDiv.classList.add("hidden");

      const formData = new FormData();
      formData.append("email", email);

      fetch(`${SITE_URL}/ajax/subscribe.php`, {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            responseDiv.innerText = "Subscribed successfully!";
            responseDiv.className = "mt-2 text-[14px] font-medium text-primary";
            responseDiv.classList.remove("hidden");
            subscribeForm.reset();
            setTimeout(() => {
              responseDiv.classList.add("hidden");
            }, 5000);
          } else {
            throw new Error(data.message || "Something went wrong.");
          }
        })
        .catch((err) => {
          console.error(err);
          responseDiv.innerText = err.message || "An unexpected error occurred.";
          responseDiv.className = "mt-2 text-[14px] font-medium text-red-500";
          responseDiv.classList.remove("hidden");
          setTimeout(() => {
            responseDiv.classList.add("hidden");
          }, 5000);
        })
        .finally(() => {
          btn.disabled = false;
          btn.innerHTML = originalText;
        });
    });
  }
});
