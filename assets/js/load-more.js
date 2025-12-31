function setupLoadMore(
  containerId,
  itemClass,
  buttonId,
  mobileInitial,
  desktopInitial,
  batchSize
) {
  const container = document.getElementById(containerId);
  if (!container) return;

  const items = container.querySelectorAll(itemClass);
  const loadMoreBtn = document.getElementById(buttonId);

  // Determine initial count based on screen width
  const isMobile = window.innerWidth < 768; // Tailwind md breakpoint
  let visibleCount = isMobile ? mobileInitial : desktopInitial;

  // Helper to update visibility
  const updateVisibility = () => {
    items.forEach((item, index) => {
      if (index < visibleCount) {
        // Remove hidden class if present, ensure display
        item.classList.remove("hidden");
      } else {
        item.classList.add("hidden");
      }
    });

    // Hide button if all items are visible
    if (visibleCount >= items.length) {
      if (loadMoreBtn) {
        loadMoreBtn.classList.add("hidden");
        loadMoreBtn.style.display = "none"; // Force hide
      }
    } else {
      if (loadMoreBtn) {
        loadMoreBtn.classList.remove("hidden");
        loadMoreBtn.style.display = ""; // Reset to default (inline-block from class)
      }
    }
  };

  // Initial run
  updateVisibility();

  // Event listener
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener("click", (e) => {
      e.preventDefault();
      visibleCount += batchSize;
      updateVisibility();
    });
  }

  // Optional: Handle resize if you want to switch logic dynamically,
  // but usually "Load More" state is preserved or reset.
  // For simplicity, we stick to the state started on load, or we can reload on resize.
  // A simple resize check to re-evaluate isMobile often leads to UX jumps.
  // We will stick to the logic: if user resizes, we don't automatically hide items back.
}

document.addEventListener("DOMContentLoaded", () => {
  // Setup for Industry Categories
  setupLoadMore(
    "industry-grid",
    ".industry-item",
    "industry-load-more",
    4,
    8,
    4
  );

  // Setup for Product Categories
  setupLoadMore("product-grid", ".product-item", "product-load-more", 4, 8, 4);
});
