define(['jquery'], function($) {
    return function(config) {
        console.log('Custom JS initialized with param:', config.param);
    };
});