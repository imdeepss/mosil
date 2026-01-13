document.addEventListener("DOMContentLoaded", function () {
  const glossaryGrid = document.getElementById("glossary-grid");
  const loadMoreBtn = document.getElementById("load-more-btn");
  const loadMoreContainer = document.getElementById("load-more-container");
  const letterButtons = document.querySelectorAll(".letter-btn");
  const modal = document.getElementById("glossary-modal");
  const modalTitle = document.getElementById("glossary-modal-title");
  const modalBody = document.getElementById("glossary-modal-body");
  const modalClose = document.getElementById("glossary-modal-close");
  const searchInput = document.getElementById("glossary-search-input");
  const searchResults = document.getElementById("search-results");

  // Check SITE_URL
  if (typeof SITE_URL === "undefined") {
    console.error("SITE_URL is not defined.");
    return;
  }

  let currentLetter = "A";
  let currentOffset = 0;
  let limit = 8;
  let isLoading = false;
  let totalItems = 0;
  let searchTimeout = null;
  let highlightKeyword = null;

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
      highlightKeyword = null; // Reset highlight
      limit = 8; // Reset limit
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

  // Search Input Listener
  if (searchInput) {
    searchInput.addEventListener("input", function (e) {
      const query = e.target.value.trim();
      console.log("Search input:", query);
      clearTimeout(searchTimeout);

      if (query.length < 1) {
        searchResults.classList.add("hidden");
        searchResults.innerHTML = "";
        return;
      }

      searchTimeout = setTimeout(() => {
        fetchSearchResults(query);
      }, 300);
    });

    // Close search results on click outside
    document.addEventListener("click", function (e) {
      if (
        searchResults &&
        !searchResults.contains(e.target) &&
        e.target !== searchInput
      ) {
        searchResults.classList.add("hidden");
      }
    });
  }

  // Search Result Click (Delegated)
  if (searchResults) {
    searchResults.addEventListener("click", function (e) {
      const resultItem = e.target.closest(".search-result-item");
      if (resultItem) {
        const keyword = resultItem.dataset.keyword;
        const letter = keyword.charAt(0).toUpperCase();

        // Set state
        currentLetter = letter;
        currentOffset = 0;
        limit = 1000; // Load all to ensure highlighted item is visible
        highlightKeyword = keyword;

        // UI Updates
        updateActiveLetter(letter);
        searchResults.classList.add("hidden");
        searchInput.value = ""; // Optional: clean input

        // Fetch
        fetchGlossary(false);
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
        btn.classList.add("bg-[#F4C300]", "text-[#1A3B1B]");
      } else {
        btn.classList.add("bg-[#F5F5F5]", "text-[#A3A3A3]");
        btn.classList.remove("bg-[#F4C300]", "text-[#1A3B1B]");
      }
    });
  }

  async function fetchSearchResults(query) {
    console.log("Fetching results for:", query);
    try {
      const response = await fetch(
        `${SITE_URL}/ajax/get_glossary.php?search=${encodeURIComponent(query)}`
      );
      const data = await response.json();

      if (data.status === "success") {
        renderSearchResults(data.data.items);
      } else {
        console.warn("Search returned status:", data.status);
      }
    } catch (error) {
      console.error("Search error:", error);
    }
  }

  function renderSearchResults(items) {
    if (!items || items.length === 0) {
      searchResults.innerHTML =
        '<div class="px-4 py-2 text-[#757575] text-sm">No results found</div>';
      searchResults.classList.remove("hidden");
      return;
    }

    const html = items
      .map(
        (item) => `
        <div class="search-result-item px-4 py-2 hover:bg-[#F5F5F5] cursor-pointer text-[#1A3B1B] text-sm border-b border-[#F5F5F5] last:border-none duration-200 transition-colors" data-keyword="${item.keyword}">
            ${item.keyword}
        </div>
      `
      )
      .join("");

    searchResults.innerHTML = html;
    searchResults.classList.remove("hidden");
  }

  async function fetchGlossary(append) {
    isLoading = true;
    if (loadMoreBtn) loadMoreBtn.innerText = "Loading...";

    // If we have a highlighter query and we are resetting (not appending), we might want to ensure we fetch enough items?
    // For now, respect standard pagination. If the item is not in the first page, it won't be highlighted.
    // NOTE: Ideally we'd ask backend "find page for this keyword".
    // Proceeding with standard logic.

    try {
      const response = await fetch(
        `${SITE_URL}/ajax/get_glossary.php?letter=${currentLetter}&limit=${limit}&offset=${currentOffset}`
      );
      const data = await response.json();

      if (data.status === "success") {
        totalItems = data.data.total;
        renderGlossary(data.data.items, append);
        updateLoadMoreVisibility();

        // Handle Highlight Scroll
        if (highlightKeyword && !append) {
          setTimeout(() => {
            const highlightedCard = document.querySelector(
              `[data-card-keyword="${highlightKeyword}"]`
            );
            if (highlightedCard) {
              highlightedCard.scrollIntoView({
                behavior: "smooth",
                block: "center",
              });
            }
            // Reset after generic highlight
            // highlightKeyword = null; // Keep it? No need.
          }, 100);
        }
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
        const isLong = item.explanation.length > 150;
        const displayText = isLong
          ? item.explanation.substring(0, 250) + "..."
          : item.explanation;

        const isHighlighted =
          highlightKeyword && item.keyword === highlightKeyword;
        const borderClass = isHighlighted
          ? "border-[#F4C300] border-2 shadow-lg"
          : "border-transparent"; // Custom highlight

        return `
            <div data-card-keyword="${
              item.keyword
            }" class="glossary-card bg-[#F5F5F5] px-4 py-6 rounded flex flex-col gap-4 justify-start items-start h-full hover:bg-primary transition-all ease-in-out duration-300 group ${borderClass} box-border">
                <h4 class="glossary-title text-[#666666] font-base font-bold text-[18px] leading-[140%] tracking-[0.015em] capitalize group-hover:text-main-green">
                    ${item.keyword}
                </h4>
                <div class="text-[#666666] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em] line-clamp-4 group-hover:text-[#757575] transition-colors">
                    ${displayText}
                </div>
                ${
                  isLong
                    ? `<button class="read-more-btn text-[#666666] font-base font-bold text-[16px] leading-[150%] tracking-[0.015em] capitalize group-hover:text-main-green mt-auto cursor-pointer" 
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
    if (loadMoreContainer) {
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
