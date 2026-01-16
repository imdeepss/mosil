/**
 * Admin Dashboard JavaScript
 */

// Import jQuery (if not already included in your HTML)
// import $ from "jquery"

// Import Bootstrap (if not already included in your HTML)
// import * as bootstrap from "bootstrap"

$(document).ready(() => {
  // Initialize tooltips
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  var tooltipList = tooltipTriggerList.map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
  );

  // Form validation for all forms with class 'needs-validation'
  $(".needs-validation").each(function () {
    $(this).validate({
      errorElement: "div",
      errorClass: "invalid-feedback",
      highlight: (element) => {
        $(element).addClass("is-invalid").removeClass("is-valid");
      },
      unhighlight: (element) => {
        $(element).addClass("is-valid").removeClass("is-invalid");
      },
      errorPlacement: (error, element) => {
        error.insertAfter(element);
      },
    });
  });

  // Confirm delete
  $(".btn-delete").on("click", (e) => {
    if (!confirm("Are you sure you want to delete this item?")) {
      e.preventDefault();
    }
  });

  // Toggle sidebar on mobile
  $("#sidebarToggle").on("click", () => {
    $("body").toggleClass("sb-sidenav-toggled");
  });

  // Add active class to nav links based on current page
  const currentLocation = window.location.pathname;
  const menuItems = document.querySelectorAll(".nav-link");
  const menuLength = menuItems.length;

  for (let i = 0; i < menuLength; i++) {
    if (menuItems[i].getAttribute("href") === currentLocation) {
      menuItems[i].classList.add("active");

      // If it's a submenu item, expand the parent menu
      const parentCollapse = menuItems[i].closest(".collapse");
      if (parentCollapse) {
        parentCollapse.classList.add("show");
        const parentTrigger = document.querySelector(
          `[data-bs-target="#${parentCollapse.id}"]`
        );
        if (parentTrigger) {
          parentTrigger.setAttribute("aria-expanded", "true");
          parentTrigger.classList.add("active");
        }
      }
    }
  }

  // File input preview
  $(".custom-file-input").on("change", function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).next(".custom-file-label").html(fileName);

    // Image preview
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = (e) => {
        $("#imagePreview").attr("src", e.target.result);
        $("#imagePreview").show();
      };
      reader.readAsDataURL(this.files[0]);
    }
  });

  // DataTables initialization (if available)
  if ($.fn.DataTable) {
    $(".dataTable").DataTable({
      responsive: true,
    });
  }
});

/**
 * Show alert message
 *
 * @param {string} message The message to display
 * @param {string} type The type of alert (success, danger, warning, info)
 */
function showAlert(message, type = "info") {
  const alertPlaceholder = document.getElementById("alertPlaceholder");
  if (!alertPlaceholder) return;

  const wrapper = document.createElement("div");
  wrapper.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;

  alertPlaceholder.append(wrapper);

  // Auto-dismiss after 5 seconds
  setTimeout(() => {
    const alert = bootstrap.Alert.getOrCreateInstance(
      wrapper.querySelector(".alert")
    );
    alert.close();
  }, 5000);
}

/**
 * Format date to a readable format
 *
 * @param {string} dateString The date string to format
 * @return {string} The formatted date
 */
function formatDate(dateString) {
  const options = { year: "numeric", month: "long", day: "numeric" };
  return new Date(dateString).toLocaleDateString(undefined, options);
}
