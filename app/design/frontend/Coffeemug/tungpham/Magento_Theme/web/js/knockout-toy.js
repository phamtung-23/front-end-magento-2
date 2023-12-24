define([
    'ko',
    'uiComponent',
  
  ], function(ko, Component) {
      'use strict';
      let self;
      return Component.extend({

        people: ko.observableArray([
          { name: 'Bert' },
          { name: 'Charles' },
          { name: 'Denise' }
        ]),
        
        
        initialize: function (config) {
            this._super();
            self = this;
            // alert("toy inventory ll");
            
        },
        addPerson: function() {
          self.people.push({ name: 'New Person' }); 
        },
        removePerson: function(data) {
          // var indexToRemove = parseInt(event.target.getAttribute('item-index'), 10);
          self.people.remove(data);
        }
      });
  });