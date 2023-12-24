define(['jquery'], function ($) {
    'use strict';

    var modalWidgetMixin = {
        options: {
            confirmMessage: "Please, confirm modal closing."
        },

        /**
         * Added confirming for modal closing
         *
         * @returns {Element}
         */
        closeModal: function () {
            if (!confirm(this.options.confirmMessage)) {
                return this.element;
            }

            return this._super();
        }
    };

    return function (targetWidget) {
        // Example how to extend a widget by mixin object
        $.widget('mage.modal', targetWidget, modalWidgetMixin); // the widget alias should be like for the target widget
        return $.mage.modal; //  the widget by parent alias should be returned
    };
});