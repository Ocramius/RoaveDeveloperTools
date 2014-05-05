'use strict';

angular
    .module('adminApp', [
        'ngResource',
        'ngRoute'
    ])
    .config(function ($routeProvider, $locationProvider) {
        $locationProvider.html5Mode(true).hashPrefix('!');

        $routeProvider
            .when('/', {
                templateUrl: 'views/main.html',
                controller: 'MainCtrl'
            })
            .when('/list-inspections', {
                templateUrl: 'views/list-inspections.html',
                controller: 'listInspectionsCtrl'
            })
            .when('/inspection/:inspectionId', {
                templateUrl: 'views/inspection.html',
                controller: 'inspectionCtrl'
            })
            .otherwise({
                redirectTo: '/'
            });
    });
