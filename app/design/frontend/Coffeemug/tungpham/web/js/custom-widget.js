define(['jquery'], function($) {
    'use strict';

    $.widget('custom.customWidget', {
        options: {
            // Define default options here
            message: 'Hello, Widget!',
        },

        _create: function() {
            // Initialize your widget
            this._super();
            this._bindEvents();
        },

        _bindEvents: function() {
            var message = this.options.message;
            this.element.text(message);
        },
    });

    return $.custom.customWidget;
});