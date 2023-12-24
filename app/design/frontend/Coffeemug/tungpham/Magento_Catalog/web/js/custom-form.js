define([
    'jquery',
    'ko',
    'uiComponent',
    'sweet'
], function ($, ko, Component, sweet) {
    'use strict';
    return Component.extend({
        // defaults: {
        //     template: 'Magento_Catalog/custom-form'
        // },

        initialize: function () {
            this._super();
            this.formData = ko.observable({
                name: '',
                email: '',
                message: ''
            });
            this.messageName = ko.observable('');
            this.messageEmail = ko.observable('');
            this.messageMess = ko.observable('');
            this.showMessageName = ko.observable(false);
            this.showMessageEmail = ko.observable(false);
            this.showMessageMess = ko.observable(false);

            return this;
        },

        onSubmit: function () {
            var self = this;

            if (this.validateForm()) {
                // Perform AJAX form submission
                $.ajax({
                    url: 'https://tungpham.cmmage.app/en/contact/index/post/', 
                    method: 'POST',
                    data: {
                        name: this.formData().name,
                        email: this.formData().email,
                        message: this.formData().message
                    },
                    success: function (response) {
                        // Handle success
                        self.showMessageName(true);
                        self.showMessageEmail(true);
                        self.showMessageMess(true);
                        sweet.fire({
                            title: 'Success!',
                            position: "top",
                            text: 'Form submitted successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });

                    },
                    error: function (xhr, status, error) {
                        // Handle error
                        sweet.fire({
                            title: 'Error!',
                            position: "top",
                            text: 'Error submitting the form. Please try again later!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        console.error(xhr, status, error);
                    }
                });
            }
        },

        validateForm: function () {
            // Implement your custom validation logic
            // Return true if validation passes, false otherwise
            var name = this.formData().name;
            var email = this.formData().email;
            var message = this.formData().message;

            // Example validation: Name and email are required
            if (!name) {
                this.messageName('Please fill name.');
                this.showMessageName(true);
                this.showMessageEmail(false);
                this.showMessageMess(false);
                return false;

            }
             if(!email){
                this.messageEmail('Please fill an email.');
                this.showMessageName(false);
                this.showMessageEmail(true);
                this.showMessageMess(false);
                return false;

            }
             if(!message){
                this.messageMess('Please fill a message.');
                this.showMessageName(false);
                this.showMessageEmail(false);
                this.showMessageMess(true);
                return false;

            }
            // Add more validation as needed

            return true;
        }
    });
});
