define([
    'ko',
    'uiComponent',
  
  ], function(ko, Component) {
      'use strict';
      return Component.extend({
          defaults: {
              template: 'Magento_Catalog/text-custom-ko',
   
              counter: ko.observable(0)
          },
          initialize: function (config) {
            this._super();
            // this.sale = config.date;
            setInterval(this.reloadTime.bind(this), 1000);
            alert("hello llll");
          },
          reloadTime: function(){
            this.counter(this.counter() + 1);
          },
          getHello: function(){
            return "aloalo" + this.counter();
          }
      });
    
  });