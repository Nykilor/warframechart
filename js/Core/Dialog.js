//Without prefixes
export default function Dialog(dialogId, buttonId) {
  this.$elem = document.getElementById(dialogId);
  this.$elemId = "#" + dialogId;
  this.$buttonId = "#" + buttonId;

  return this;
};

Dialog.prototype.setBasicListners = function(openCallback = false, closeCallback = false) {
  const that = this;

  $(that.$buttonId).click(function() {
    $("body").css("overflow-y", "hidden");
    if (openCallback) {
      openCallback();
    }
    that.$elem.showModal();
    $(that.$elemId).scrollTop(0);
  });

  $(document).on("click", "dialog[open]", function(e) {
    if ($(e.target).is("dialog")) {
      $("body").css("overflow-y", "inherit");
      if (closeCallback) {
        closeCallback();
      }
      that.$elem.close();
    }
  });

  return this;
};
//Jquery kind of with "."/"#" prefix
Dialog.prototype.setCloseButton = function($closeBtn, closeCallback = false) {
  const that = this;
  $(this.$elemId + " " + $closeBtn).click(function() {
    $("body").css("overflow-y", "inherit");
    that.$elem.close();
    if (closeCallback) {
      closeCallback();
    }
  });

  return this;
};
