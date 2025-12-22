/**
 * NeoPortfolio Admin Scripts
 *
 * Handles the Project Data & Visuals Meta Box.
 * Includes the Feature Repeater, Drag-and-Drop Gallery, and Emoji Picker.
 *
 * @package NeoPortfolio
 * @version 1.0.0
 */

jQuery(document).ready(function ($) {
  "use strict";

  // Features Repeater (Sortable, Add, Delete)

  var featureContainer = $("#features-container");

  /**
   * Initialize jQuery UI Sortable for the Features list.
   * Allows users to drag rows via the header to reorder them.
   */
  if (featureContainer.length) {
    featureContainer.sortable({
      handle: ".row-header",
      axis: "y",
      placeholder: "ui-sortable-placeholder",
      stop: function () {
        // Callback when sorting finishes
        updateFeatureIndexes();
      },
    });
  }

  /**
   * Add New Feature Row.
   * Appends a new HTML template string to the container and re-indexes fields.
   */
  $("#add-feature-row").on("click", function (e) {
    e.preventDefault();

    // Template for a new row. Defaults to "open" state.
    var row = `
            <div class="feature-row open">
                <div class="row-header">
                    <span class="row-title-preview">
                        <span class="dashicons dashicons-move drag-handle"></span>
                        <span class="preview-text">New Feature Item</span>
                    </span>
                    <div class="row-actions">
                        <button type="button" class="toggle-row">Close</button>
                        <button type="button" class="remove-row">Delete</button>
                    </div>
                </div>
                <div class="row-content" style="display:block;">
                    <div class="meta-field">
                        <label>Emoji Icon</label>
                        <div class="emoji-input-wrapper">
                            <input type="text" class="input-emoji" placeholder="">
                            <button type="button" class="emoji-trigger-btn">😀</button>
                        </div>
                    </div>
                    <div class="meta-field">
                        <label>Feature Title</label>
                        <input type="text" class="input-title" placeholder="Title">
                    </div>
                    <div class="meta-field">
                        <label>Description</label>
                        <textarea class="input-text" style="height: 60px;"></textarea>
                    </div>
                </div>
            </div>`;

    featureContainer.append(row);
    updateFeatureIndexes();
  });

  /**
   * Update Feature Indexes.
   * Iterates through all rows and updates the `name` attributes of input fields.
   */
  function updateFeatureIndexes() {
    $("#features-container .feature-row").each(function (i) {
      $(this)
        .find(".input-emoji")
        .attr("name", "neoportfolio_features[" + i + "][emoji]");
      $(this)
        .find(".input-title")
        .attr("name", "neoportfolio_features[" + i + "][title]");
      $(this)
        .find(".input-text")
        .attr("name", "neoportfolio_features[" + i + "][text]");
    });
  }

  /**
   * Toggle Row Visibility.
   * Expands or collapses the details of a feature row.
   */
  $(document).on("click", ".toggle-row", function (e) {
    e.preventDefault();
    var row = $(this).closest(".feature-row");
    var content = row.find(".row-content");
    var btn = $(this);

    if (row.hasClass("open")) {
      content.slideUp(200);
      row.removeClass("open");
      btn.text("Edit");
    } else {
      content.slideDown(200);
      row.addClass("open");
      btn.text("Close");
    }
  });

  /**
   * Preview Update.
   * Updates the header text of the collapsed row as the user types in inputs.
   */
  $(document).on("keyup change", ".input-emoji, .input-title", function () {
    var row = $(this).closest(".feature-row");
    var preview =
      row.find(".input-emoji").val() + " " + row.find(".input-title").val();

    var text = $.trim(preview) === "" ? "New Feature Item" : preview;
    row.find(".preview-text").text(text);
  });

  // Emoji Mart

  let activeEmojiInput = null;

  let emojiPickerInstance = null;

  // Create Modal DOM container immediately upon load.
  $("body").append('<div id="emoji-modal-overlay"></div>');
  const emojiOverlay = $("#emoji-modal-overlay");

  /**
   * Initialize the Emoji Picker
   * Called only when the user clicks the trigger button for the first time.
   * This prevents loading heavy JS resources if the user never uses emojis.
   */
  function initEmojiPicker() {
    if (typeof EmojiMart === "undefined") {
      alert(
        "EmojiMart library failed to load. Please check your internet connection."
      );
      console.error("EmojiMart is undefined.");
      return false;
    }

    console.log("Initializing EmojiMart Instance...");

    const pickerOptions = {
      /**
       * Callback when an emoji is selected.
       */
      onEmojiSelect: (data) => {
        if (activeEmojiInput) {
          activeEmojiInput.val(data.native);
          activeEmojiInput.trigger("change");
        }
        emojiOverlay.hide();
      },
      onClickOutside: (e) => {
        // Native click outside is handled by our overlay click listener below.
      },
      set: "native",
      theme: "light",
    };

    emojiPickerInstance = new EmojiMart.Picker(pickerOptions);
    emojiOverlay.append(emojiPickerInstance);
    return true;
  }

  /**
   * Trigger Picker.
   * Opens the singleton modal. Initializes it if it doesn't exist yet.
   */
  $(document).on("click", ".emoji-trigger-btn", function (e) {
    e.preventDefault();
    e.stopPropagation();

    activeEmojiInput = $(this).prev(".input-emoji");

    if (!emojiPickerInstance) {
      const success = initEmojiPicker();
      if (!success) return;
    }

    emojiOverlay.css("display", "flex");
  });

  /**
   * Close Modal.
   * Hides the overlay when clicking the outside the picker.
   */
  emojiOverlay.on("click", function (e) {
    if (e.target === this) {
      $(this).hide();
      activeEmojiInput = null;
    }
  });

  // Visual Assets Gallery

  var galleryFrame;
  var galleryContainer = $("#gallery-preview-container");
  var galleryInput = $("#neoportfolio_gallery_ids");

  /**
   * Initialize Sortable for Gallery Images.
   */
  if (galleryContainer.length) {
    galleryContainer.sortable({
      update: function () {
        updateGalleryInput();
      },
    });
  }

  /**
   * Open Media Manager.
   * Uses standard WordPress Media API.
   */
  $("#manage-gallery").on("click", function (e) {
    e.preventDefault();

    // Re-open existing frame
    if (galleryFrame) {
      galleryFrame.open();
      return;
    }

    // Create new frame
    galleryFrame = wp.media({
      title: "Select Visual Assets",
      button: {
        text: "Use Selected Images",
      },
      multiple: true,
    });

    // Handle selection
    galleryFrame.on("select", function () {
      var selection = galleryFrame.state().get("selection");

      selection.map(function (attachment) {
        attachment = attachment.toJSON();

        if (
          galleryContainer.find('[data-id="' + attachment.id + '"]').length == 0
        ) {
          // Use thumbnail if available, fall back to full url
          var thumb =
            attachment.sizes && attachment.sizes.thumbnail
              ? attachment.sizes.thumbnail.url
              : attachment.url;

          // Append visual item
          galleryContainer.append(
            '<div class="gallery-item" data-id="' +
              attachment.id +
              '"><span class="gallery-remove">×</span><img src="' +
              thumb +
              '"></div>'
          );
        }
      });

      updateGalleryInput();
    });

    galleryFrame.open();
  });

  /**
   * Remove Gallery Image.
   */
  $(document).on("click", ".gallery-remove", function () {
    $(this).parent().remove();
    updateGalleryInput();
  });

  /**
   * Update Gallery Hidden Input.
   * Scrapes data-id attributes from the DOM and saves as CSV string.
   */
  function updateGalleryInput() {
    var ids = [];
    $("#gallery-preview-container .gallery-item").each(function () {
      ids.push($(this).data("id"));
    });
    galleryInput.val(ids.join(","));
  }

  // Delete Confirm Modal

  let deleteConfirmOverlay;
  let rowToDelete = null;

  // Append the modal HTML to the body only once.
  $("body").append(`
    <div id="delete-confirm-overlay">
      <div id="delete-confirm-modal">
        <h4>Confirm Deletion</h4>
        <p>Are you sure you want to permanently remove this feature row? This action cannot be undone.</p>
        <div class="modal-actions">
          <button type="button" id="delete-cancel-btn" class="button-modal button-modal-cancel">Cancel</button>
          <button type="button" id="delete-confirm-btn" class="button-modal button-modal-confirm">Delete</button>
        </div>
      </div>
    </div>
  `);

  deleteConfirmOverlay = $("#delete-confirm-overlay");

  /**
   * Show Delete Confirmation Modal.
   */
  $(document).on("click", ".remove-row", function (e) {
    e.preventDefault();
    rowToDelete = $(this).closest(".feature-row");
    deleteConfirmOverlay.css("display", "flex");
  });

  /**
   * Confirm Deletion.
   */
  $(document).on("click", "#delete-confirm-btn", function () {
    if (rowToDelete) {
      rowToDelete.remove();
      updateFeatureIndexes();
    }
    deleteConfirmOverlay.hide();
    rowToDelete = null;
  });

  /**
   * Cancel Deletion or Click Outside.
   */
  $(document).on("click", "#delete-cancel-btn, #delete-confirm-overlay", function (e) {
    if (e.target === this || $(e.target).is("#delete-cancel-btn")) {
      deleteConfirmOverlay.hide();
      rowToDelete = null;
    }
  });
});
