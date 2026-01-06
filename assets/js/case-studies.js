document.addEventListener("DOMContentLoaded", function () {
  // Define elements
  const blogContainer = document.getElementById("blog-container");
  const paginationContainer = document.getElementById("pagination-container");
  const filterButtons = document.querySelectorAll(".filter-btn");

  // Define SITE_URL if not defined (though it should be defined in PHP)
  if (typeof SITE_URL === "undefined") {
    console.error("SITE_URL is not defined.");
    return;
  }

  let currentPage = 1;
  let currentCategory = "All";
  const limit = 6;

  // Initialize Filter Buttons
  filterButtons.forEach((btn) => {
    btn.addEventListener("click", function () {
      // Update active state
      filterButtons.forEach((b) => {
        b.classList.remove("bg-main-green", "text-white");
        b.classList.add("bg-[#F5F5F5]", "text-[#A3A3A3]");
      });
      this.classList.remove("bg-[#F5F5F5]", "text-[#A3A3A3]");
      this.classList.add("bg-main-green", "text-white");

      currentCategory = this.dataset.category;
      currentPage = 1;
      fetchCaseStudies();
    });
  });

  // Function to fetch case studies
  async function fetchCaseStudies() {
    // Show loading state (optional)
    blogContainer.style.opacity = "0.5";

    try {
      const response = await fetch(
        `${SITE_URL}/ajax/get_case_studies.php?page=${currentPage}&limit=${limit}&category=${encodeURIComponent(
          currentCategory
        )}`
      );
      const data = await response.json();

      if (data.status === "success") {
        renderCaseStudies(data.data.caseStudies);
        renderPagination(data.data);
      } else {
        console.error("Error fetching case studies:", data.message);
        blogContainer.innerHTML =
          '<p class="text-center text-red-500 w-full col-span-3">Failed to load content.</p>';
      }
    } catch (error) {
      console.error("Network error:", error);
    } finally {
      blogContainer.style.opacity = "1";
    }
  }

  // Render Case Study Cards
  function renderCaseStudies(caseStudies) {
    if (caseStudies.length === 0) {
      blogContainer.innerHTML =
        '<p class="text-center text-gray-500 w-full col-span-3 py-10">No case studies found in this category.</p>';
      return;
    }

    const html = caseStudies
      .map(
        (study) => `
            <div class="group flex flex-col h-full">
                <!-- Image -->
                <div class="relative h-[240px] overflow-hidden rounded-lg mb-4">
                    <img src="${study.image_url}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        alt="${study.title}" loading="lazy">
                    <div class="absolute bottom-2 left-2 px-2 py-1 bg-[#F4C300] text-[#1A3B1B] font-bold text-[10px] uppercase">
                        Case Study
                    </div>
                </div>

                <!-- Content -->
                <div class="flex flex-col flex-1">
                    <h3 class="text-xl font-bold text-[#1A3B1B] mb-3 leading-tight group-hover:text-[#415C42] transition-colors">
                        ${study.title}
                    </h3>

                    <p class="text-[#757575] text-sm leading-relaxed mb-4 line-clamp-3">
                        ${study.excerpt}
                    </p>

                    <div class="mt-auto">
                         <span class="text-xs text-[#A3A3A3] block mb-1">Case study | ${study.formatted_date}</span>
                        <a href="${study.link}" class="text-[#1A3B1B] font-bold text-sm hover:underline">Read Case Study</a>
                    </div>
                </div>
            </div>
        `
      )
      .join("");

    blogContainer.innerHTML = html;
  }

  // Render Pagination Controls
  function renderPagination(meta) {
    const { totalPages, currentPage: page } = meta;
    let html = "";

    // Prev Button
    if (page > 1) {
      html += `
                <button onclick="changePage(${page - 1})" 
                    class="text-[#666666] font-base font-normal text-[18px] leading-[140%] tracking-[0.015em] flex items-center gap-2 hover:text-main-green transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M15 5L8 12L15 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>Prev
                </button>`;
    } else {
      html += `
                <button disabled class="text-gray-300 font-base font-normal text-[18px] flex items-center gap-2 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M15 5L8 12L15 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>Prev
                </button>`;
    }

    html += `<div class="flex items-center gap-2">`;

    const range = [];
    if (totalPages <= 7) {
      for (let i = 1; i <= totalPages; i++) range.push(i);
    } else {
      if (page <= 4) {
        for (let i = 1; i <= 5; i++) range.push(i);
        range.push("...");
        range.push(totalPages);
      } else if (page >= totalPages - 3) {
        range.push(1);
        range.push("...");
        for (let i = totalPages - 4; i <= totalPages; i++) range.push(i);
      } else {
        range.push(1);
        range.push("...");
        range.push(page - 1);
        range.push(page);
        range.push(page + 1);
        range.push("...");
        range.push(totalPages);
      }
    }

    range.forEach((p) => {
      if (p === "...") {
        html += `<span class="px-2 text-gray-400">...</span>`;
      } else {
        if (p === page) {
          html += `<button class="bg-[#F4C300] rounded text-[#1A3B1B] w-8 h-8 flex items-center justify-center font-bold">${p}</button>`;
        } else {
          html += `<button onclick="changePage(${p})" class="bg-[#FAE696] hover:bg-[#F4C300] rounded text-[#1A3B1B] w-8 h-8 flex items-center justify-center transition-colors">${p}</button>`;
        }
      }
    });

    html += `</div>`;

    // Next Button
    if (page < totalPages) {
      html += `
                <button onclick="changePage(${page + 1})" 
                    class="text-[#666666] font-base font-normal text-[18px] leading-[140%] tracking-[0.015em] flex items-center gap-2 hover:text-main-green transition-colors">
                    Next
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>`;
    } else {
      html += `
                <button disabled class="text-gray-300 font-base font-normal text-[18px] flex items-center gap-2 cursor-not-allowed">
                    Next
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>`;
    }

    paginationContainer.innerHTML = html;
  }

  // Global function for interaction
  window.changePage = function (p) {
    currentPage = p;
    fetchCaseStudies();
    const nav = document.querySelector(".breadcrumbs");
    if (nav) nav.scrollIntoView({ behavior: "smooth", block: "start" });
  };
});
