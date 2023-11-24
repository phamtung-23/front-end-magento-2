define([
  'ko',
  'uiComponent',
  'countdown'

], function(ko, Component) {
    'use strict';
    return Component.extend({
        defaults: {
            template: 'Magento_Catalog/timer',
            clock: ko.observable(''),
            sale: ko.observable(''),
        },
        initialize: function (config) {
          this._super();
          this.sale = config.date;
          setInterval(this.reloadTime.bind(this), 1000);
        },
        reloadTime: function(){
          var end = new Date(this.sale);
          var now = new Date();

          var timespan = countdown(now, end);

          this.clock(timespan);
        },
        getTimer: function(){
          return this.clock;
        }
    });
  
});