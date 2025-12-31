document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("enquiryModal");
  const openBtns = document.querySelectorAll(".openEnquiryModal");
  const closeBtn = document.getElementById("closeEnquiryModal");
  const backdrop = document.getElementById("modalBackdrop");
  const form = document.querySelector("#enquiryModal form");
  const submitBtn = form.querySelector('button[type="submit"]');
  const messageContainer = document.getElementById("formMessage");

  const resetFeedback = () => {
    if (messageContainer) {
      messageContainer.classList.add("hidden");
      messageContainer.innerHTML = "";
      messageContainer.className =
        "hidden mb-4 text-center text-sm font-medium p-2 rounded";
    }
  };

  function toggleModal(show) {
    if (!modal) return;

    if (show) {
      modal.classList.remove("hidden");
      document.body.style.overflow = "hidden";
      resetFeedback();
    } else {
      modal.classList.add("hidden");
      document.body.style.overflow = "";
    }
  }

  if (openBtns) {
    openBtns.forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.preventDefault();
        toggleModal(true);
      });
    });
  }

  [closeBtn, backdrop].forEach((el) => {
    if (el) el.addEventListener("click", () => toggleModal(false));
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !modal.classList.contains("hidden")) {
      toggleModal(false);
    }
  });

  if (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();

      const originalBtnText = submitBtn.innerHTML;
      submitBtn.innerHTML = `Processing...`;
      submitBtn.disabled = true;
      resetFeedback();

      const formData = new FormData(form);

      fetch(`${SITE_URL}/ajax/submit-enquiry.php`, {
        method: "POST",
        body: formData,
      })
        .then((res) => {
          if (!res.ok) throw new Error("Network response was not ok");
          return res.json();
        })
        .then((data) => {
          if (data.success) {
            messageContainer.innerHTML = data.message;
            messageContainer.className =
              "mb-4 text-center text-sm font-medium text-main-green border border-main-green p-2 bg-green-50";
            messageContainer.classList.remove("hidden");

            form.reset();
            setTimeout(() => toggleModal(false), 2500);
          } else {
            throw new Error(data.message || "An error occurred.");
          }
        })
        .catch((error) => {
          console.error("Submission Error:", error);
          messageContainer.innerHTML =
            error.message || "An error occurred. Please try again.";
          messageContainer.className =
            "mb-4 text-center text-sm font-medium text-red-700 border border-red-700 p-2 bg-red-50";
          messageContainer.classList.remove("hidden");
        })
        .finally(() => {
          submitBtn.innerHTML = originalBtnText;
          submitBtn.disabled = false;
        });
    });
  }
});
