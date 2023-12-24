define([
    'uiComponent'
], function (Component) {
    'use strict';

    return Component.extend({
        defaults: {
            person: {},
            imports: {
                status: '${ $.provider }:status'
            },
            tracks: {
                status: true,
                bio: true
            },
            links: {
                bio: '${ $.provider }:bio'
            },
        },

        initialize: function () {
            this._super();
            return this;
        },

        getTwitterHandle: function () {
            return '@' + this.person.twitter;
        },

        getTwitterUrl: function () {
            return 'https://twitter.com/' + this.person.twitter;
        },

        getButtonText: function () {
            return this.status === 'Online' ? 'Go Offline' : 'Go Online';
        },

        setStatus: function () {
            return this.status === 'Online' ? this.status = 'Offline' : this.status = 'Online';
        }
    });
});