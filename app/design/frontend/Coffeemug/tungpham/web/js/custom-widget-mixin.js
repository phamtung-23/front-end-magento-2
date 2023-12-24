define(['jquery'], function($) {
    'use strict';

    return function(target) {
        $.widget('custom.customWidget', target, {
            // Override or extend widget methods here

            _bindEvents: function() {
                this._super();
                // Modify widget functionality in the mixin
                this.element.css('color', 'blue');
            },
        });

        return $.custom.customWidget;
    };
});