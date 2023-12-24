define([
    'jquery',
    'Magento_Ui/js/modal/modal'
  ], function ($) {
    'use strict';
  
    var modal = function (config, element) {
      var $el = $(element);
      var trigger = $el.find('[data-role="trigger"]');
      var target = $el.find('[data-role="target"]');
      var buttons = [];
  
      // setup buttons
      if (config.buttons) {
        for (var prop in config.buttons) {
          if (config.buttons.hasOwnProperty(prop)) {
            var button = config.buttons[prop];
  
            buttons.push({
              text: button.text,
              class: button.class,
              click: function () {
                this.closeModal();
                // alert('Modal closed');
              }
            });
          }
        }
      }
  
      // setup modal
      target.modal({
        // autoOpen: config.autoOpen,
        buttons: buttons,
        closeText: config.closeText,
        clickableOverlay: config.clickableOverlay,
        focus: config.focus,
        innerScroll: config.innerScroll,
        modalClass: config.modalClass,
        modalLeftMargin: config.modalLeftMargin,
        responsive: config.responsive,
        title: config.title,
        type: config.type,
      });
  
      // setup trigger
      $(trigger).on('click', function () {
        target.modal('openModal');
      });
    };
  
    return modal;
  });