// Initialize TinyMCE
function initializeRichEditors() {
  tinymce.init({
    selector: ".rich-editor",
    height: 300,
    plugins: [
      "advlist",
      "autolink",
      "lists",
      "link",
      "image",
      "charmap",
      "print",
      "preview",
      "anchor",
      "searchreplace",
      "visualblocks",
      "code",
      "fullscreen",
      "insertdatetime",
      "media",
      "table",
      "paste",
      "help",
      "wordcount",
    ],
    toolbar:
      "undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | table | help",
    menubar: "file edit view insert format tools table help",
    content_style:
      'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px; }',
    setup: function (editor) {
      editor.on("change", function () {
        editor.save();
      });
    },
  });
}

function initSelect2($container = $(document)) {
  $container.find(".select2").each(function () {
    const $el = $(this);
    const $modalParent = $el.closest(".modal");
    if ($el.hasClass("select2-hidden-accessible")) {
      $el.select2("destroy");
    }
    $el.select2({
      dropdownParent: $modalParent.length ? $modalParent : $(document.body),
      width: "100%",
    });
  });
}

$(document).ready(function () {
  // Initialize TinyMCE on page load
  initializeRichEditors();

  // Initialize Select2 globally on static elements
  initSelect2();

  // Re-initialize Select2 when any modal is shown (for dynamically loaded content)
  $(document).on("shown.bs.modal", function (e) {
    initSelect2($(e.target)); // For modal content
  });
  // Initialize DataTables
  $("#productsTable").DataTable({
    responsive: true,
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excel",
        text: "Export to Excel",
        className: "btn btn-sm btn-success",
        exportOptions: {
          columns: [0, 2, 3, 4, 5],
        },
      },
      {
        extend: "csv",
        text: "Export to CSV",
        className: "btn btn-sm btn-info",
        exportOptions: {
          columns: [0, 2, 3, 4, 5],
        },
      },
    ],
    language: {
      search: "_INPUT_",
      searchPlaceholder: "Search products...",
    },
  });

  // Hide built-in DataTables buttons
  $(".dt-buttons").hide();

  // Trigger Excel export on custom button click
  $("#exportBtn").on("click", function () {
    $(".buttons-excel").click();
  });

  // Slug generation (add + edit)
  $(document).on("keyup", "#product_name", function () {
    const slug = $(this)
      .val()
      .toLowerCase()
      .replace(/[^\w\s-]/g, "")
      .replace(/\s+/g, "-")
      .replace(/-+/g, "-")
      .trim();
    $("#product_slug").val(slug);
  });

  //   $('[id^="product_name"]').each(function () {
  //     const id = $(this).attr("id").replace("product_name", "");
  //     $(this).on("keyup", function () {
  //       const slug = $(this)
  //         .val()
  //         .toLowerCase()
  //         .replace(/[^\w\s-]/g, "")
  //         .replace(/\s+/g, "-")
  //         .replace(/-+/g, "-")
  //         .trim();
  //       $("#product_slug" + id).val(slug);
  //     });
  //   });

  // Auto-dismiss alerts
  setTimeout(function () {
    $(".alert-dismissible").alert("close");
  }, 5000);

  // Delete confirmation
  $(document).on("click", ".delete-btn", function () {
    const productId = $(this).data("id");
    const productName = $(this).data("name");

    Swal.fire({
      title: "Are you sure?",
      text: `You are about to delete the product "${productName}". This action cannot be undone!`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#dc3545",
      cancelButtonColor: "#6c757d",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $("#delete_product_id").val(productId);
        $("#deleteForm").submit();
      }
    });
  });

   $(document).on('change', '#product_image, #tds_file', function() {
    const file = this.files[0];
    if (file) {
        const maxSize = 5 * 1024 * 1024; // 5MB
        const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        const validTdsTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        const validTypes = this.id.includes('product_image') ? validImageTypes : validTdsTypes;

        if (!validTypes.includes(file.type)) {
            alert('Invalid file type. Allowed types: ' + validTypes.join(', '));
            this.value = '';
        } else if (file.size > maxSize) {
            alert('File size exceeds 5MB limit.');
            this.value = '';
        }
    }
});

  // Form validation for add form
  $("#addProductForm").validate({
    rules: {
      product_name: {
        required: true,
        minlength: 3,
      },
      product_slug: {
        required: true,
        minlength: 3,
      },
      "parent_cat[]": {
        required: true,
      },
      short_description: {
        minlength: 10,
      },
    },
    messages: {
      product_name: {
        required: "Please enter a product name",
        minlength: "Minimum 3 characters",
      },
      product_slug: {
        required: "Please enter a slug",
        minlength: "Minimum 3 characters",
      },
      "parent_cat[]": {
        required: "Please select at least one parent category",
      },
      short_description: {
        minlength: "Minimum 10 characters",
      },
    },
    errorElement: "div",
    errorClass: "invalid-feedback",
    highlight: function (element) {
      $(element).addClass("is-invalid").removeClass("is-valid");
    },
    unhighlight: function (element) {
      $(element).addClass("is-valid").removeClass("is-invalid");
    },
    errorPlacement: function (error, element) {
      if (
        element.hasClass("select2") ||
        element.hasClass("select2-hidden-accessible")
      ) {
        error.insertAfter(element.next(".select2-container"));
      } else {
        error.insertAfter(element);
      }
    },
  });

  // Validation for edit forms
  $("form[id^='editProductForm']").each(function () {
    $(this).validate({
      rules: {
        product_name: {
          required: true,
          minlength: 3,
        },
        product_slug: {
          required: true,
          minlength: 3,
        },
        "parent_cat[]": {
          required: true,
        },
        short_description: {
          minlength: 10,
        },
      },
      messages: {
        product_name: {
          required: "Please enter a product name",
          minlength: "Minimum 3 characters",
        },
        product_slug: {
          required: "Please enter a slug",
          minlength: "Minimum 3 characters",
        },
        "parent_cat[]": {
          required: "Please select at least one parent category",
        },
        short_description: {
          minlength: "Minimum 10 characters",
        },
      },
      errorElement: "div",
      errorClass: "invalid-feedback",
      highlight: function (element) {
        $(element).addClass("is-invalid").removeClass("is-valid");
      },
      unhighlight: function (element) {
        $(element).addClass("is-valid").removeClass("is-invalid");
      },
      errorPlacement: function (error, element) {
        if (
          element.hasClass("select2") ||
          element.hasClass("select2-hidden-accessible")
        ) {
          error.insertAfter(element.next(".select2-container"));
        } else {
          error.insertAfter(element);
        }
      },
    });
  });

  // Load edit modal content via AJAX
  $(document).on("click", ".btnEditModal", function () {
    const productId = $(this).data("id");

    $.ajax({
      url: "./_ajax/getProductsDetails.php",
      type: "POST",
      data: {
        id: productId,
      },
      dataType: "html",
      success: function (data) {
        $("#editProductModal").html(data).modal("show");

        // Re-initialize TinyMCE & Select2 in modal
        initializeRichEditors();
        prePopulateImage();
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
      },
    });
  });
});
$(document).on("keyup", "#product_name", function () {
  const slug = $(this)
    .val() // Get the current input value
    .toLowerCase() // Convert to lowercase
    .replace(/[^\w\s-]/g, "") // Remove all non-word characters except spaces and dashes
    .replace(/\s+/g, "-") // Replace spaces with dashes
    .replace(/-+/g, "-") // Replace multiple dashes with a single dash
    .trim(); // Trim leading/trailing whitespace (note: this doesn't affect dashes)

  $("#product_slug").val(slug); // Set the slug to the other input
});



function prePopulateImage() {
    const fileInputs = document.querySelectorAll('input[type="file"]');

    fileInputs.forEach((fileInput) => {
        const existingImageInput = fileInput.parentElement.querySelector('.existing_image');
        if (existingImageInput) {
            const existingFileUrl = existingImageInput.value;
            if (existingFileUrl) {
                fetch(existingFileUrl)
                    .then((response) => response.blob())
                    .then((blob) => {
                        const fileName = existingFileUrl.substring(
                            existingFileUrl.lastIndexOf("/") + 1
                        );
                        const myFile = new File([blob], fileName, { type: blob.type });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(myFile);

                        // 🔐 This line will NOT work in most browsers
                        fileInput.files = dataTransfer.files;

                        // Optional: Set file name as a data attribute (cosmetic use only)
                        fileInput.dataset.file = fileName;
                    })
                    .catch((error) => {
                        console.error("Error loading existing file:", error);
                    });
            }
        }
    });
}


