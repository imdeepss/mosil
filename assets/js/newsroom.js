document.addEventListener("DOMContentLoaded", () => {
  // Logic for Case Study items selection on Mobile
  const items = document.querySelectorAll(".case-study-item");

  items.forEach((item) => {
    item.addEventListener("click", (e) => {
      // Only perform toggle logic on mobile (optional check, but classes handle responsive behavior)
      // Actually, we want to toggle classes regardless, styling handles the display.

      // 1. Reset all items to Inactive state (Mobile: Grey)
      items.forEach((el) => {
        // Remove Active Class (Yellow)
        el.classList.remove("bg-[#F4C300]");
        // Add Inactive Class (Grey)
        el.classList.add("bg-[#F5F5F5]");
        // Ensure Hover is present (optional, matches PHP logic)
        el.classList.add("hover:bg-[#F4C300]");

        // Reset Green Bar
        const bar = el.querySelector("span.absolute");
        if (bar) {
          bar.classList.remove("scale-y-100");
          bar.classList.add("scale-y-0");
        }
      });

      // 2. Set Clicked item to Active state (Mobile: Yellow)
      // Add Active Class
      item.classList.add("bg-[#F4C300]");
      // Remove Inactive Class
      item.classList.remove("bg-[#F5F5F5]");
      // Remove Hover (optional, matches PHP logic)
      // item.classList.remove('hover:bg-[#F4C300]');

      // Activate Green Bar
      const activeBar = item.querySelector("span.absolute");
      if (activeBar) {
        activeBar.classList.remove("scale-y-0");
        activeBar.classList.add("scale-y-100");
      }
    });
  });
});
