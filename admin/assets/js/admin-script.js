/**
 * Admin Dashboard JavaScript
 */

// Import jQuery (if not already included in your HTML)
import $ from "jquery"

// Import Bootstrap (if not already included in your HTML)
import * as bootstrap from "bootstrap"

$(document).ready(() => {
  // Toggle the side navigation
  $("#sidebarToggle, #sidebarToggleTop").on("click", (e) => {
    $("body").toggleClass("sidebar-toggled")
    $(".sidebar").toggleClass("toggled")
    if ($(".sidebar").hasClass("toggled")) {
      $(".sidebar .collapse").collapse("hide")
    }
  })

  // Close any open menu accordions when window is resized below 768px
  $(window).resize(() => {
    if ($(window).width() < 768) {
      $(".sidebar .collapse").collapse("hide")
    }

    // Toggle the side navigation when window is resized below 480px
    if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
      $("body").addClass("sidebar-toggled")
      $(".sidebar").addClass("toggled")
      $(".sidebar .collapse").collapse("hide")
    }
  })

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $("body.fixed-nav .sidebar").on("mousewheel DOMMouseScroll wheel", function (e) {
    if ($(window).width() > 768) {
      var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail
      this.scrollTop += (delta < 0 ? 1 : -1) * 30
      e.preventDefault()
    }
  })

  // Scroll to top button appear
  $(document).on("scroll", function () {
    var scrollDistance = $(this).scrollTop()
    if (scrollDistance > 100) {
      $(".scroll-to-top").fadeIn()
    } else {
      $(".scroll-to-top").fadeOut()
    }
  })

  // Smooth scrolling using jQuery easing
  $(document).on("click", "a.scroll-to-top", function (e) {
    var $anchor = $(this)
    $("html, body")
      .stop()
      .animate(
        {
          scrollTop: $($anchor.attr("href")).offset().top,
        },
        1000,
        "easeInOutExpo",
      )
    e.preventDefault()
  })

  // Initialize tooltips
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl))

  // Form validation for all forms with class 'needs-validation'
  $(".needs-validation").each(function () {
    $(this).validate({
      errorElement: "div",
      errorClass: "invalid-feedback",
      highlight: (element) => {
        $(element).addClass("is-invalid").removeClass("is-valid")
      },
      unhighlight: (element) => {
        $(element).addClass("is-valid").removeClass("is-invalid")
      },
      errorPlacement: (error, element) => {
        error.insertAfter(element)
      },
    })
  })

  // Confirm delete
  $(".btn-delete").on("click", (e) => {
    if (!confirm("Are you sure you want to delete this item?")) {
      e.preventDefault()
    }
  })

  // File input preview
  $(".custom-file-input").on("change", function () {
    var fileName = $(this).val().split("\\").pop()
    $(this).next(".custom-file-label").html(fileName)

    // Image preview
    if (this.files && this.files[0]) {
      var reader = new FileReader()
      reader.onload = (e) => {
        $("#imagePreview").attr("src", e.target.result)
        $("#imagePreview").show()
      }
      reader.readAsDataURL(this.files[0])
    }
  })

  // DataTables initialization (if available)
  if ($.fn.DataTable) {
    $(".datatable").DataTable({
      responsive: true,
    })
  }

  // Auto-dismiss alerts after 5 seconds
  setTimeout(() => {
    $(".alert-dismissible").alert("close")
  }, 5000)

  // Toggle dark mode
  $("#darkModeToggle").on("click", () => {
    $("body").toggleClass("dark-mode")

    // Save preference to localStorage
    if ($("body").hasClass("dark-mode")) {
      localStorage.setItem("darkMode", "enabled")
    } else {
      localStorage.setItem("darkMode", "disabled")
    }
  })

  // Check for saved dark mode preference
  if (localStorage.getItem("darkMode") === "enabled") {
    $("body").addClass("dark-mode")
  }
})

/**
 * Show alert message
 *
 * @param {string} message The message to display
 * @param {string} type The type of alert (success, danger, warning, info)
 */
function showAlert(message, type = "info") {
  const alertPlaceholder = document.getElementById("alertContainer")
  if (!alertPlaceholder) return

  const wrapper = document.createElement("div")
  wrapper.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `

  alertPlaceholder.append(wrapper)

  // Auto-dismiss after 5 seconds
  setTimeout(() => {
    const alert = bootstrap.Alert.getOrCreateInstance(wrapper.querySelector(".alert"))
    alert.close()
  }, 5000)
}

/**
 * Format date to a readable format
 *
 * @param {string} dateString The date string to format
 * @return {string} The formatted date
 */
function formatDate(dateString) {
  const options = { year: "numeric", month: "long", day: "numeric" }
  return new Date(dateString).toLocaleDateString(undefined, options)
}

/**
 * Format currency
 *
 * @param {number} amount The amount to format
 * @param {string} currency The currency code (default: USD)
 * @return {string} The formatted currency
 */
function formatCurrency(amount, currency = "USD") {
  return new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: currency,
  }).format(amount)
}

/**
 * Truncate text to a specified length
 *
 * @param {string} text The text to truncate
 * @param {number} length The maximum length
 * @return {string} The truncated text
 */
function truncateText(text, length = 100) {
  if (text.length <= length) return text
  return text.substring(0, length) + "..."
}

/**
 * Generate a random ID
 *
 * @param {number} length The length of the ID
 * @return {string} The generated ID
 */
function generateId(length = 8) {
  const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"
  let id = ""
  for (let i = 0; i < length; i++) {
    id += chars.charAt(Math.floor(Math.random() * chars.length))
  }
  return id
}

/**
 * Debounce function to limit how often a function can be called
 *
 * @param {Function} func The function to debounce
 * @param {number} wait The wait time in milliseconds
 * @return {Function} The debounced function
 */
function debounce(func, wait = 300) {
  let timeout
  return function (...args) {
    clearTimeout(timeout)
    timeout = setTimeout(() => func.apply(this, args), wait)
  }
}
