function setupLoadMore(
  containerId,
  itemClass,
  buttonId,
  mobileInitial,
  desktopInitial,
  batchSize,
) {
  const container = document.getElementById(containerId);
  if (!container) return;

  const items = container.querySelectorAll(itemClass);
  const loadMoreBtn = document.getElementById(buttonId);

  // Determine initial count based on screen width
  const isMobile = window.innerWidth < 768; // Tailwind md breakpoint
  const initialCount = isMobile ? mobileInitial : desktopInitial;
  let visibleCount = initialCount;

  // Helper to update visibility
  const updateVisibility = () => {
    let allVisible = true;

    items.forEach((item, index) => {
      if (index < visibleCount) {
        item.classList.remove("hidden");
      } else {
        item.classList.add("hidden");
        allVisible = false;
      }
    });

    if (loadMoreBtn) {
      // If total items are fewer than or equal to initial count, always hide button
      if (items.length <= initialCount) {
        loadMoreBtn.classList.add("hidden");
        loadMoreBtn.style.display = "none";
      } else {
        // Otherwise, managing button state
        loadMoreBtn.classList.remove("hidden");
        loadMoreBtn.style.display = ""; // Reset to default

        if (visibleCount >= items.length) {
          loadMoreBtn.innerText = "See less";
        } else {
          loadMoreBtn.innerText = "See more";
        }
      }
    }
  };

  // Initial run
  updateVisibility();

  // Event listener
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener("click", (e) => {
      e.preventDefault();

      if (visibleCount >= items.length) {
        // "See less" logic: remove last batch, but don't go below initial
        visibleCount = Math.max(initialCount, visibleCount - batchSize);
      } else {
        // "See more" logic
        visibleCount += batchSize;
      }

      updateVisibility();
    });
  }
}

document.addEventListener("DOMContentLoaded", () => {
  // Setup for Industry Categories
  setupLoadMore(
    "industry-grid",
    ".industry-item",
    "industry-load-more",
    4,
    8,
    8,
  );

  // Setup for Product Categories
  setupLoadMore("product-grid", ".product-item", "product-load-more", 4, 8, 4);
});
