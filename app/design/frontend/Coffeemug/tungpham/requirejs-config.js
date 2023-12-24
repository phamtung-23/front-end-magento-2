// var config = {
//     map: {
//         '*': {
//             myscript: 'js/app'
//         }
//     }
// };

var config = {
    map: {
        '*': {
            customJs: 'js/custom-js',
            customWidget: 'js/custom-widget',
            customWidgetMixin: 'js/custom-widget-mixin'
        }
    },
    config: {
        mixins: {
            'Magento_Ui/js/modal/modal': {
                'Magento_Theme/js/modal-mixin': true
            }
        }
    },
    paths: {
        slick: 'js/slick.min',
        
    },
    shim: {
        slick: {
            deps: ['jquery']
        }
      }
   };
   