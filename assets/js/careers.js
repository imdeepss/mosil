document.addEventListener("DOMContentLoaded", function () {
  const careerForm = document.getElementById("careerForm");
  const submitBtn = document.getElementById("submitBtn");
  const fileInput = document.getElementById("upload");
  const fileLabel = document.getElementById("fileLabel").querySelector("span");
  const formResponse = document.getElementById("formResponse");

  // --- Helper Functions for Validation ---
  function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  function validatePhone(phone) {
    return /^\d{10,15}$/.test(phone.replace(/\D/g, ""));
  }

  function validateExtension(filename) {
    const allowed = ["pdf", "doc", "docx"];
    const ext = filename.split(".").pop().toLowerCase();
    return allowed.includes(ext);
  }

  function showError(input, message) {
    // Check if error already exists
    let existingError = input.parentElement.querySelector(".text-red-500");
    if (!existingError) {
      const errorDiv = document.createElement("div");
      errorDiv.className = "text-red-500 text-sm mt-1 ml-2";
      errorDiv.textContent = message;
      input.parentElement.appendChild(errorDiv);
      input.classList.add("border-red-500");
      input.classList.remove("border-[#DEDEDE]");
    }
  }

  function clearError(input) {
    const existingError = input.parentElement.querySelector(".text-red-500");
    if (existingError) {
      existingError.remove();
    }
    input.classList.remove("border-red-500");
    input.classList.add("border-[#DEDEDE]");
  }

  function validateInput(input) {
    clearError(input);
    const value = input.value.trim();
    const name = input.name;

    if (input.hasAttribute("required") && !value) {
      showError(input, "This field is required.");
      return false;
    }

    if (name === "email" && value && !validateEmail(value)) {
      showError(input, "Please enter a valid email address.");
      return false;
    }

    if (name === "mobile" && value && !validatePhone(value)) {
      showError(input, "Please enter a valid phone number (10-15 digits).");
      return false;
    }

    if (name === "pincode" && value && !/^\d+$/.test(value)) {
      showError(input, "Pincode must be numeric.");
      return false;
    }

    return true;
  }

  // --- Show Response Helper ---
  function showFormResponse(message, type) {
    formResponse.innerHTML = message;
    formResponse.classList.remove(
      "hidden",
      "bg-green-100",
      "text-green-700",
      "bg-red-100",
      "text-red-700"
    );

    if (type === "success") {
      formResponse.classList.add("bg-green-100", "text-green-700");
    } else {
      formResponse.classList.add("bg-red-100", "text-red-700");
    }

    // Auto-hide after 5 seconds if success? Maybe not, keep it visible.
    formResponse.scrollIntoView({ behavior: "smooth", block: "center" });
  }

  // --- Real-time Validation ---
  const inputs = careerForm.querySelectorAll("input, select");
  inputs.forEach((input) => {
    if (input.type !== "file") {
      input.addEventListener("blur", () => validateInput(input));
      input.addEventListener("input", () => clearError(input));
    }
  });

  // --- File Input Handling ---
  fileInput.addEventListener("change", function () {
    const file = this.files[0];
    const parent = this.parentElement;
    // Remove old error if any
    const existingError = parent.querySelector(".text-red-500");
    if (existingError) existingError.remove();

    if (!file) {
      fileLabel.textContent = "Upload Resume (PDF/DOC)";
      fileLabel.classList.remove("text-main-green", "font-bold");
      return;
    }

    // Validate type
    if (!validateExtension(file.name)) {
      showError(fileInput, "Invalid file type. Only PDF, DOC, DOCX allowed.");
      this.value = ""; // Clear
      fileLabel.textContent = "Upload Resume (PDF/DOC)";
      return;
    }

    // Validate size (5MB)
    if (file.size > 5 * 1024 * 1024) {
      showError(fileInput, "File size too large. Max 5MB allowed.");
      this.value = ""; // Clear
      fileLabel.textContent = "Upload Resume (PDF/DOC)";
      return;
    }

    // Success
    fileLabel.textContent = file.name;
    fileLabel.classList.add("text-main-green", "font-bold");
  });

  // --- Form Submission ---
  careerForm.addEventListener("submit", async function (e) {
    e.preventDefault();
    formResponse.classList.add("hidden"); // Hide previous messages

    let isValid = true;
    inputs.forEach((input) => {
      // Skip file input in this loop as it's handled separately or within validateInput logic
      if (input.type !== "file") {
        if (!validateInput(input)) {
          isValid = false;
        }
      }
    });

    // Specific file check for submit
    const file = fileInput.files[0];
    if (!file) {
      showError(fileInput, "Please upload your resume.");
      isValid = false;
    }

    if (!isValid) {
      const firstError = careerForm.querySelector(".text-red-500");
      if (firstError) {
        firstError.parentElement.scrollIntoView({
          behavior: "smooth",
          block: "center",
        });
      }
      return;
    }

    const ajaxEndpoint = "/mosil-new/ajax/career.php";

    // UI Feedback: Start Loading
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.classList.add("cursor-not-allowed", "opacity-70");
    submitBtn.innerHTML =
      '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';

    const formData = new FormData(this);

    try {
      const response = await fetch(ajaxEndpoint, {
        method: "POST",
        body: formData,
      });

      let result;
      const contentType = response.headers.get("content-type");
      if (contentType && contentType.indexOf("application/json") !== -1) {
        result = await response.json();
      } else {
        const text = await response.text();
        console.error("Non-JSON response:", text);
        throw new Error("Server returned an invalid response.");
      }

      if (result.status === "success") {
        showFormResponse(result.message, "success");
        careerForm.reset();
        fileLabel.textContent = "Upload Resume (PDF/DOC)";
        fileLabel.classList.remove("text-main-green", "font-bold");
      } else {
        showFormResponse(result.message || "An error occurred.", "error");
      }
    } catch (error) {
      console.error("AJAX Error:", error);
      showFormResponse(
        "Application could not be sent. Please try again later.",
        "error"
      );
    } finally {
      // UI Feedback: Restore Button
      submitBtn.disabled = false;
      submitBtn.classList.remove("cursor-not-allowed", "opacity-70");
      submitBtn.innerHTML = originalBtnText;
    }
  });
});
