/**
 * Quadra Approach Interaction Logic
 * Handles the switching of active states between Painpoints, Expectation Mapping, etc.
 */
(function () {
  "use strict";

  document.addEventListener("DOMContentLoaded", function () {
    // Ensure we have the data from the page
    if (typeof window.quadraData === "undefined") {
      console.warn("Quadra Data is missing. Interactions disabled.");
      return;
    }

    const data = window.quadraData;
    const cards = document.querySelectorAll(".quadra-card");
    const tabs = document.querySelectorAll(".quadra-tab");
    const descEl = document.getElementById("quadra-description");

    if (!descEl || cards.length === 0) return;

    let activeIndex = 0;
    let transitionTimeout;

    /**
     * Updates the visible content and highlights the active item.
     * @param {number} index - The index of the item to activate.
     */
    function updateQuadraContent(index) {
      // Prevent re-animating the same content
      if (activeIndex === index) return;
      activeIndex = index;

      // Guard clause for array bounds
      if (!data[index]) return;

      // Clear any pending transition to avoid jumping content
      if (transitionTimeout) clearTimeout(transitionTimeout);

      // 1. Update Description with Blur-Fade Effect
      // Remove initial animation class if present
      descEl.classList.remove("animate-fadeIn");

      // Start fade out with blur
      descEl.classList.add("opacity-0", "blur-sm");

      // Update text after transition delay (faster swap)
      transitionTimeout = setTimeout(() => {
        descEl.textContent = data[index].description;
        // Start fade in (remove blur and opacity)
        descEl.classList.remove("opacity-0", "blur-sm");
      }, 150);

      // 2. Update Cards (Left Side Images)
      cards.forEach((card) => {
        const cardIndex = parseInt(card.dataset.index, 10);
        const isTarget = cardIndex === index;

        // Toggle classes based on active state
        // Using toggle for cleaner class management where possible,
        // but explicit add/remove is safer for specific sets of utility classes.
        if (isTarget) {
          card.classList.add("z-10", "opacity-100");
          card.classList.remove("opacity-50");
        } else {
          card.classList.remove("z-10", "opacity-100");
          card.classList.add("opacity-50");
        }
      });

      // 3. Update Tabs (Right Side Links)
      tabs.forEach((tab) => {
        const tabIndex = parseInt(tab.dataset.index, 10);
        const isTarget = tabIndex === index;

        if (isTarget) {
          tab.classList.add("border-b-2", "border-main-green", "font-bold");
          tab.classList.remove("font-normal");
        } else {
          tab.classList.remove("border-b-2", "border-main-green", "font-bold");
          tab.classList.add("font-normal");
        }
      });
    }

    // Attach Hover Listeners to Cards
    cards.forEach((card) => {
      card.addEventListener("mouseenter", function () {
        const index = parseInt(this.dataset.index, 10);
        updateQuadraContent(index);
      });
    });

    // Attach Click Listeners to Tabs
    tabs.forEach((tab) => {
      tab.addEventListener("click", function () {
        const index = parseInt(this.dataset.index, 10);
        updateQuadraContent(index);
      });
    });
  });
})();
