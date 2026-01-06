document.addEventListener("DOMContentLoaded", function () {
  const glossaryGrid = document.getElementById("glossary-grid");
  const loadMoreBtn = document.getElementById("load-more-btn");
  const loadMoreContainer = document.getElementById("load-more-container");
  const letterButtons = document.querySelectorAll(".letter-btn");
  const modal = document.getElementById("glossary-modal");
  const modalTitle = document.getElementById("glossary-modal-title");
  const modalBody = document.getElementById("glossary-modal-body");
  const modalClose = document.getElementById("glossary-modal-close");

  // Check SITE_URL
  if (typeof SITE_URL === "undefined") {
    console.error("SITE_URL is not defined.");
    return;
  }

  let currentLetter = "A";
  let currentOffset = 0;
  const limit = 8;
  let isLoading = false;
  let totalItems = 0;

  // Initial Load
  init();

  function init() {
    // Set 'A' as active visually
    updateActiveLetter("A");
    fetchGlossary(false);
  }

  // --- Event Listeners ---

  // Letter Click
  letterButtons.forEach((btn) => {
    btn.addEventListener("click", function () {
      const letter = this.dataset.letter;
      if (letter === currentLetter) return; // No change

      currentLetter = letter;
      currentOffset = 0; // Reset pagination
      updateActiveLetter(letter);
      fetchGlossary(false); // New fetch, replace content
    });
  });

  // Load More Click
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener("click", function () {
      if (!isLoading) {
        currentOffset += limit;
        fetchGlossary(true); // Append content
      }
    });
  }

  // Modal Close
  if (modalClose) {
    modalClose.addEventListener("click", closeModal);
  }
  // Click outside modal to close
  if (modal) {
    modal.addEventListener("click", function (e) {
      if (e.target === modal) closeModal();
    });
  }

  // Read More Click (Delegated)
  glossaryGrid.addEventListener("click", function (e) {
    if (e.target.classList.contains("read-more-btn")) {
      const card = e.target.closest(".glossary-card");
      const title = card.querySelector(".glossary-title").textContent;
      const fullText = e.target.dataset.fullDescription;
      openModal(title, fullText);
    }
  });

  // --- Functions ---

  function updateActiveLetter(letter) {
    letterButtons.forEach((btn) => {
      if (btn.dataset.letter === letter) {
        btn.classList.remove("bg-[#F5F5F5]", "text-[#A3A3A3]");
        btn.classList.add("bg-[#F4C300]", "text-[#1A3B1B]"); // Active styling (based on sample) or user request?
        // User sample had: //on active text-main-green bg-[#F4C300]
        // Default: bg-[#F5F5F5] text-[#A3A3A3]
      } else {
        btn.classList.add("bg-[#F5F5F5]", "text-[#A3A3A3]");
        btn.classList.remove("bg-[#F4C300]", "text-[#1A3B1B]");
      }
    });
  }

  async function fetchGlossary(append) {
    isLoading = true;
    if (loadMoreBtn) loadMoreBtn.innerText = "Loading...";

    try {
      const response = await fetch(
        `${SITE_URL}/ajax/get_glossary.php?letter=${currentLetter}&limit=${limit}&offset=${currentOffset}`
      );
      const data = await response.json();

      if (data.status === "success") {
        totalItems = data.data.total;
        renderGlossary(data.data.items, append);
        updateLoadMoreVisibility();
      } else {
        console.error("Error loading glossary:", data.message);
      }
    } catch (error) {
      console.error("Network error:", error);
    } finally {
      isLoading = false;
      if (loadMoreBtn) loadMoreBtn.innerText = "See More";
    }
  }

  function renderGlossary(items, append) {
    if (!append) {
      glossaryGrid.innerHTML = "";
    }

    if (items.length === 0 && !append) {
      glossaryGrid.innerHTML =
        '<p class="col-span-4 text-center text-gray-500 py-10">No terms found for this letter.</p>';
      return;
    }

    const html = items
      .map((item) => {
        const isLong = item.explanation.length > 120;
        const displayText = isLong
          ? item.explanation.substring(0, 120) + "..."
          : item.explanation;

        return `
            <div class="glossary-card bg-[#F5F5F5] px-4 py-6 rounded flex flex-col gap-4 justify-start items-start h-full">
                <h4 class="glossary-title text-[#666666] font-base font-bold text-[18px] leading-[140%] tracking-[0.015em] capitalize">
                    ${item.keyword}
                </h4>
                <div class="text-[#666666] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em] line-clamp-4">
                    ${displayText}
                </div>
                ${
                  isLong
                    ? `<button class="read-more-btn text-[#666666] font-base font-bold text-[16px] leading-[150%] tracking-[0.015em] capitalize hover:text-main-green mt-auto" 
                       data-full-description="${escapeHtml(item.explanation)}">
                       Read more
                       </button>`
                    : ""
                }
            </div>
        `;
      })
      .join("");

    if (append) {
      glossaryGrid.insertAdjacentHTML("beforeend", html);
    } else {
      glossaryGrid.innerHTML = html;
    }
  }

  function updateLoadMoreVisibility() {
    const currentCount = currentOffset + limit; // Items potentially shown
    // Logic: if currentOffset + limit >= total, hide button.
    // Actually, on initial load (offset 0), we asked for `limit`.
    // If append, we increased offset.
    // It's safer to track how many we actually have on screen, but calculation is fine.

    // Better logic: if the loaded items count (items.length from fetch) < limit, we reached end.
    // OR: if currentOffset + fetched_items_count >= totalItems.

    // Let's use totalItems from backend.
    // We display items from 0 to currentOffset + (fetched count).
    // If we just fetched 'limit' items, and currentOffset + limit < totalItems, show button.

    // Wait, fetchGlossary keeps currentOffset.
    // If we have rendered `currentOffset + newlyFetchedCount` items?
    // Let's simplify:
    if (loadMoreContainer) {
      // We need to know how many items are currently displayed?
      // Or simply:
      if (currentOffset + limit < totalItems) {
        loadMoreContainer.style.display = "block";
      } else {
        loadMoreContainer.style.display = "none";
      }
    }
  }

  function openModal(title, text) {
    if (modalTitle) modalTitle.textContent = title;
    if (modalBody) modalBody.textContent = text;
    if (modal) {
      modal.classList.remove("hidden");
      document.body.style.overflow = "hidden"; // Prevent background scroll
    }
  }

  function closeModal() {
    if (modal) {
      modal.classList.add("hidden");
      document.body.style.overflow = "";
    }
  }

  function escapeHtml(text) {
    if (!text) return "";
    return text
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }
});
