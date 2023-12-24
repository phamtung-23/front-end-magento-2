define([
    'uiElement',
    'ko'
], function (Component, ko) {
    'use strict';

    return Component.extend({
        defaults: {
            firstName: 'Jason',
            role: 'Front End Engineer',
            location: 'United Kingdom',
            twitter: 'jasonujmaalvis',
            status: ko.observable('Online'),
            bio: ko.observable(''),
            exports: {
                firstName: '${ $.provider }:person.firstName',
                role: '${ $.provider }:person.role',
                location: '${ $.provider }:person.location',
                twitter: '${ $.provider }:person.twitter',
            },
            listens: {
                '${ $.provider }:status': 'statusChanged',
                '${ $.provider }:bio': 'bioChanged'
            },
        },

        initialize: function () {
            this._super();
            return this;
        },

        statusChanged: function (newValue) {
            console.log('status changed to:', newValue);
        },

        bioChanged: function (newValue) {
            console.log('bio changed to:', newValue);
        }
    });
});