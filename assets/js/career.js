document.addEventListener("DOMContentLoaded", function () {
  const careerForm = document.getElementById("careerForm");
  const submitBtn = document.getElementById("submitBtn");
  const fileInput = document.getElementById("upload");
  const fileLabel = document.getElementById("fileLabel").querySelector("span");

  // Update the label when a file is selected
  fileInput.addEventListener("change", function () {
    if (this.files && this.files.length > 0) {
      fileLabel.textContent = this.files[0].name;
      fileLabel.classList.add("text-main-green", "font-bold");
    }
  });

  // Handle the Form Submission
  careerForm.addEventListener("submit", async function (e) {
    e.preventDefault();

    const ajaxEndpoint = "/ajax/career.php";

    // UI Feedback: Start Loading
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML =
      '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';

    // Prepare Data (Automatically handles files and inputs)
    const formData = new FormData(this);

    try {
      const response = await fetch(ajaxEndpoint, {
        method: "POST",
        body: formData,
      });

      // Parse JSON response from PHP
      const result = await response.json();

      if (result.status === "success") {
        alert(result.message);
        careerForm.reset();
        fileLabel.textContent = "Upload Resume (PDF/DOC)";
        fileLabel.classList.remove("text-main-green", "font-bold");
      } else {
        alert("Error: " + result.message);
      }
    } catch (error) {
      console.error("AJAX Error:", error);
      alert("A network error occurred. Please try again.");
    } finally {
      // UI Feedback: Restore Button
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalBtnText;
    }
  });
});
