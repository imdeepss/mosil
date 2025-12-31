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

    /**
     * Updates the visible content and highlights the active item.
     * @param {number} index - The index of the item to activate.
     */
    function updateQuadraContent(index) {
      // Guard clause for array bounds
      if (!data[index]) return;

      // 1. Update Description with Fade Effect
      // Reset animation
      descEl.classList.remove("animate-fadeIn");
      descEl.style.opacity = "0";

      // Update text after a short delay for the fade-out effect
      setTimeout(() => {
        descEl.textContent = data[index].description;
        descEl.style.opacity = "1";
        descEl.classList.add("animate-fadeIn");
      }, 200);

      // 2. Update Cards (Left Side Images)
      cards.forEach((card) => {
        const cardIndex = parseInt(card.dataset.index, 10);
        const isTarget = cardIndex === index;

        // Toggle classes based on active state
        // Using toggle for cleaner class management where possible,
        // but explicit add/remove is safer for specific sets of utility classes.
        if (isTarget) {
          card.classList.add(
            "ring-4",
            "ring-main-green",
            "z-10",
            "opacity-100"
          );
          card.classList.remove("opacity-50");
        } else {
          card.classList.remove(
            "ring-4",
            "ring-main-green",
            "z-10",
            "opacity-100"
          );
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

    // Attach Click Listeners to Cards
    cards.forEach((card) => {
      card.addEventListener("click", function () {
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
