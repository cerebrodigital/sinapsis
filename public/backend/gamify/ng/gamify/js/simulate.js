var UserID = 1;
﻿var rootPath = "../../ng/";
var templatePath = rootPath + "gamify/templates/";
var apiPath = "../../api/";
var defaultimagePath = "images/badge.png";
var imagedirectoryPath = "contents/badges/";

"use strict";
var mediasoftApp = angular.module('mediasoftApp', ['ngRoute', 'httpServices', 'programServices', 'ng.shims.placeholder'])

.config(['$routeProvider',
  function ($routeProvider) {
      $routeProvider.
        when('/', {
            templateUrl: templatePath + "simulate/core.html",
            controller: 'manageController'
        }).
        when('/rewards', {
            templateUrl: templatePath + "simulate/rewards.html",
            controller: 'rewardsController'
        }).
        when('/levels', {
            templateUrl: templatePath + "simulate/levels.html",
            controller: 'levelsController'
        }).
        when('/points', {
            templateUrl: templatePath + "simulate/points.html",
            controller: 'pointsController'
        }).
        when('/credits', {
            templateUrl: templatePath + "simulate/credits.html",
            controller: 'creditsController'
        }).
        when('/packages', {
            templateUrl: templatePath + "simulate/packages.html",
            controller: 'packagesController'
        }).
        when('/events', {
            templateUrl: templatePath + "simulate/events.html",
            controller: 'eventsController'
        }).
        otherwise({
            redirectTo: '/'
        });
  }])

.controller('manageController', ['$scope', 'mediasoftHTTP', 'localService', function ($scope, mediasoftHTTP, localService) {
    $scope.Nav = localService.getNav();
    $scope.NavOptions = localService.getNavOptions();
    $scope.selectedIndex = 0;
    $scope.message = "";
    $scope.type = 1;
    $scope.Data = [];
    $scope.Categories = [];
    $scope.userBadges = [];
    $scope.selectedID = 0;
    $scope.photocss = "img-rounded";
    $scope.photopath = imagedirectoryPath;
    $scope.photoname = ""; // name of photo to display
    $scope.defaultphoto = defaultimagePath;
    $scope.selectedCategory = 0;

    var loadSuccess = function (data, status) {
        $scope.showLoader = false;
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'error') {
            $scope.message = data.message;
        }
        else {
            if (typeof data.Records != "undefined") {
                $scope.Data = data.Records;
                // load user badges
                loadUserBadges();
            }
            else
                $scope.message = "Failed to open records";
        }
    };

    var categorySuccess = function (data, status) {
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'error') {
            $scope.message = data.message;
        }
        else {
            if (typeof data.Records != "undefined") {
                $scope.Categories = data.Records;
            }
            else
                $scope.message = "Failed to open records";
        }
    };
    var loadError = function (data, status, headers, config) {
        $scope.message = "Error occured";
    }

    $scope.filter = function (categoryid) {
        $scope.selectedID = categoryid;
        loadBadges(categoryid);
    };

    loadBadges(0); // load all badges

    function loadBadges(categoryid) {
        $scope.selectedCategory = categoryid;
        $scope.showLoader = true;
        var url = apiPath + "gabadges/load";
        mediasoftHTTP.actionProcess(url, [{
            type: $scope.type,
            category_id: categoryid,
            loadall: true,
            order: "priority",
            direction: "desc"
        }])
        .success(loadSuccess)
        .error(loadError);
    }


    var loadError = function (data, status, headers, config) {
        $scope.message = "Error occured";
    }

    var url = apiPath + "gacategories/load";
    mediasoftHTTP.actionProcess(url, [{
        type: $scope.type,
        loadall: true,
        order: "priority",
        direction: "desc"
    }])
    .success(categorySuccess)
    .error(loadError);


    var userSuccess = function (data, status) {
        $scope.showLoader = false;
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'error') {
            $scope.message = data.message;
        }
        else {
            if (typeof data.Records != "undefined") {
                $scope.userBadges = data.Records;

                if ($scope.userBadges.length > 0) {
                    for (var i = 0 ; i < $scope.Data.length; i++) {
                        $scope.Data[i].isawarded = false;
                        for (var j = 0 ; j < $scope.userBadges.length; j++) {
                            if ($scope.Data[i].id == $scope.userBadges[j].badge_id) {
                                $scope.Data[i].isawarded = true;
                            }
                        }
                    }
                }
            }
            else
                $scope.message = "Failed to open records";
        }
    };


    function loadUserBadges() {
        $scope.showLoader = true;
        var url = apiPath + "gauserbadges/load";
        mediasoftHTTP.actionProcess(url, [{
            userid: UserID,
            type: $scope.type,
            loadall: true,
            order: "badge_id",
            direction: "desc"
        }])
        .success(userSuccess)
        .error(loadError);
    }

    var awardSuccess = function (data, status) {
        $scope.showLoader = false;
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'success') {
            $scope.message = "Operation completed successfully";
            $scope.messagecss = "alert-success";
            loadUserBadges();
        }
        else {
            $scope.message = "Failed to delete record";
        }
    };


    $scope.award = function (_id, _icon) {
        $scope.showLoader = true;
        var url = apiPath + "gacore/award";
        mediasoftHTTP.actionProcess(url, [{ userid: UserID, badge_id: _id }])
        .success(awardSuccess)
        .error(loadError);
    };


}])
.controller('rewardsController', ['$scope', 'mediasoftHTTP', 'localService', function ($scope, mediasoftHTTP, localService) {
    $scope.Nav = localService.getNav();
    $scope.NavOptions = localService.getNavOptions();
    $scope.selectedIndex = 1;  // rewards
    $scope.message = "";
    $scope.type = 2; // 2: rewards
    $scope.Data = [];
    $scope.userBadges = [];
    $scope.Categories = [];
    $scope.selectedID = 0;
    $scope.photocss = "img-rounded";
    $scope.photopath = imagedirectoryPath;
    $scope.photoname = ""; // name of photo to display
    $scope.defaultphoto = defaultimagePath;
    $scope.selectedCategory = 0;

    var loadSuccess = function (data, status) {
        $scope.showLoader = false;
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'error') {
            $scope.message = data.message;
        }
        else {
            if (typeof data.Records != "undefined") {
                $scope.Data = data.Records;
                // load user badges
                loadUserBadges();
            }
            else
                $scope.message = "Failed to open records";
        }
    };

    var categorySuccess = function (data, status) {
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'error') {
            $scope.message = data.message;
        }
        else {
            if (typeof data.Records != "undefined") {
                $scope.Categories = data.Records;
            }
            else
                $scope.message = "Failed to open records";
        }
    };
    var loadError = function (data, status, headers, config) {
        $scope.message = "Error occured";
    }

    $scope.filter = function (categoryid) {
        $scope.selectedID = categoryid;
        loadBadges(categoryid);
    };

    loadBadges(0); // load all badges

    function loadBadges(categoryid) {
        $scope.selectedCategory = categoryid;
        $scope.showLoader = true;
        var url = apiPath + "gabadges/load";
        mediasoftHTTP.actionProcess(url, [{
            type: $scope.type,
            category_id: categoryid,
            loadall: true,
            order: "priority",
            direction: "desc"
        }])
        .success(loadSuccess)
        .error(loadError);
    }

   

    var loadError = function (data, status, headers, config) {
        $scope.message = "Error occured";
    }

   

    var url = apiPath + "gacategories/load";
    mediasoftHTTP.actionProcess(url, [{
        type: $scope.type,
        loadall: true,
        order: "priority",
        direction: "desc"
    }])
    .success(categorySuccess)
    .error(loadError);


    var userSuccess = function (data, status) {
        $scope.showLoader = false;
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'error') {
            $scope.message = data.message;
        }
        else {
            if (typeof data.Records != "undefined") {
                $scope.userBadges = data.Records;

                if ($scope.userBadges.length > 0) {
                    for (var i = 0 ; i < $scope.Data.length; i++) {
                        $scope.Data[i].isawarded = false;
                        for (var j = 0 ; j < $scope.userBadges.length; j++) {
                            if ($scope.Data[i].id == $scope.userBadges[j].badge_id) {
                                $scope.Data[i].isawarded = true;
                            }
                        }
                    }
                }
            }
            else
                $scope.message = "Failed to open records";
        }
    };


    function loadUserBadges() {
        $scope.showLoader = true;
        var url = apiPath + "gauserbadges/load";
        mediasoftHTTP.actionProcess(url, [{
            userid: UserID,
            type: $scope.type,
            loadall: true,
            order: "badge_id",
            direction: "desc"
        }])
        .success(userSuccess)
        .error(loadError);
    }

    var awardSuccess = function (data, status) {
        $scope.showLoader = false;
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'success') {
            $scope.message = "Operation completed successfully";
            $scope.messagecss = "alert-success";
            loadUserBadges();
        }
        else {
            $scope.message = "Failed to delete record";
        }
    };


    $scope.award = function (_id, _icon) {
        $scope.showLoader = true;
        var url = apiPath + "gacore/award";
        mediasoftHTTP.actionProcess(url, [{ userid: UserID, badge_id: _id }])
        .success(awardSuccess)
        .error(loadError);
    };

}])

.controller('levelsController', ['$scope', 'mediasoftHTTP', 'localService', function ($scope, mediasoftHTTP, localService) {
    $scope.Nav = localService.getNav();
    $scope.NavOptions = localService.getNavOptions();
    $scope.selectedIndex = 2;  // rewards
    $scope.message = "";
    $scope.type = 3; // 2: rewards
    $scope.Data = [];
    $scope.Categories = [];
    $scope.userLevel = [];
    $scope.selectedID = 0;
    $scope.photocss = "img-rounded";
    $scope.photopath = imagedirectoryPath;
    $scope.photoname = ""; // name of photo to display
    $scope.defaultphoto = defaultimagePath;
    $scope.selectedCategory = 0;

    var loadSuccess = function (data, status) {
        $scope.showLoader = false;
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'error') {
            $scope.message = data.message;
        }
        else {
            if (typeof data.Records != "undefined") {
                $scope.Data = data.Records;
                // load user level information
                loadUserLevel();
            }
            else
                $scope.message = "Failed to open records";
        }
    };

    var categorySuccess = function (data, status) {
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'error') {
            $scope.message = data.message;
        }
        else {
            if (typeof data.Records != "undefined") {
                $scope.Categories = data.Records;
            }
            else
                $scope.message = "Failed to open records";
        }
    };
    var loadError = function (data, status, headers, config) {
        $scope.message = "Error occured";
    }

    $scope.filter = function (categoryid) {
        $scope.selectedID = categoryid;
        loadBadges(categoryid);
    };

    loadBadges(0); // load all badges

    function loadBadges(categoryid) {
        $scope.selectedCategory = categoryid;
        $scope.showLoader = true;
        var url = apiPath + "gabadges/load";
        mediasoftHTTP.actionProcess(url, [{
            type: $scope.type,
            category_id: categoryid,
            loadall: true,
            order: "priority",
            direction: "desc"
        }])
        .success(loadSuccess)
        .error(loadError);
    }

    var loadError = function (data, status, headers, config) {
        $scope.message = "Error occured";
    }

  
    var url = apiPath + "gacategories/load";
    mediasoftHTTP.actionProcess(url, [{
        type: $scope.type,
        loadall: true,
        order: "priority",
        direction: "desc"
    }])
    .success(categorySuccess)
    .error(loadError);


    var userSuccess = function (data, status) {
        $scope.showLoader = false;
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'error') {
            $scope.message = data.message;
        }
        else {
            if (typeof data.Records != "undefined") {
                $scope.userLevel = data.Records;
                if ($scope.userLevel.length > 0) {
                    var Level = $scope.userLevel[0].levels;
                    for (var i = 0 ; i < $scope.Data.length; i++) {
                        if ($scope.Data[i].ilevel <= Level) {
                            $scope.Data[i].isawarded = true;
                        } else {
                            $scope.Data[i].isawarded = false;
                        }
                    }
                }
            }
            else
                $scope.message = "Failed to open records";
        }
    };


    function loadUserLevel() {
        $scope.showLoader = true;
        var url = apiPath + "gacore/loaduserlevels";
        mediasoftHTTP.actionProcess(url, [{
            userid: UserID,
            loadall: true,
            order: "userid",
            direction: "desc"
        }])
        .success(userSuccess)
        .error(loadError);
    }

    var awardSuccess = function (data, status) {
        $scope.showLoader = false;
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'success') {
            $scope.message = "Operation completed successfully";
            $scope.messagecss = "alert-success";
            loadUserLevel();
        }
        else {
            $scope.message = "Failed to delete record";
        }
    };


    $scope.award = function (_id, _icon) {
        $scope.showLoader = true;
        var url = apiPath + "gacore/award";
        mediasoftHTTP.actionProcess(url, [{ userid: UserID, badge_id: _id }])
        .success(awardSuccess)
        .error(loadError);
    };
}])

.controller('pointsController', ['$scope', 'mediasoftHTTP', 'localService', function ($scope, mediasoftHTTP, localService) {
    $scope.Nav = localService.getNav();
    $scope.NavOptions = localService.getNavOptions();
    $scope.selectedIndex = 3;  // points
    $scope.message = "";
    $scope.type = 4; // 4: points
    $scope.userLevel = [];
    $scope.Data = [];
    $scope.Categories = [];
    $scope.selectedID = 0;
    $scope.photocss = "img-rounded";
    $scope.photopath = imagedirectoryPath;
    $scope.photoname = ""; // name of photo to display
    $scope.defaultphoto = defaultimagePath;
    $scope.selectedCategory = 0;

    var loadSuccess = function (data, status) {
        $scope.showLoader = false;
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'error') {
            $scope.message = data.message;
        }
        else {
            if (typeof data.Records != "undefined") {
                $scope.Data = data.Records;
                // load user level information
                loadUserLevel();
            }
            else
                $scope.message = "Failed to open records";
        }
    };

    var categorySuccess = function (data, status) {
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'error') {
            $scope.message = data.message;
        }
        else {
            if (typeof data.Records != "undefined") {
                $scope.Categories = data.Records;
            }
            else
                $scope.message = "Failed to open records";
        }
    };
    var loadError = function (data, status, headers, config) {
        $scope.message = "Error occured";
    }

    $scope.filter = function (categoryid) {
        $scope.selectedID = categoryid;
        loadBadges(categoryid);
    };

    loadBadges(0); // load all badges

    function loadBadges(categoryid) {
        $scope.selectedCategory = categoryid;
        $scope.showLoader = true;
        var url = apiPath + "gabadges/load";
        mediasoftHTTP.actionProcess(url, [{
            type: $scope.type,
            category_id: categoryid,
            loadall: true,
            order: "priority",
            direction: "desc"
        }])
        .success(loadSuccess)
        .error(loadError);
    }

    var loadError = function (data, status, headers, config) {
        $scope.message = "Error occured";
    }
    
    var url = apiPath + "gacategories/load";
    mediasoftHTTP.actionProcess(url, [{
        type: $scope.type,
        loadall: true,
        order: "priority",
        direction: "desc"
    }])
    .success(categorySuccess)
    .error(loadError);


    var userSuccess = function (data, status) {
        $scope.showLoader = false;
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'error') {
            $scope.message = data.message;
        }
        else {
            if (typeof data.Records != "undefined") {
                $scope.userLevel = data.Records;
                if ($scope.userLevel.length > 0) {
                    
                }
            }
            else
                $scope.message = "Failed to open records";
        }
    };


    function loadUserLevel() {
        $scope.showLoader = true;
        var url = apiPath + "gacore/loaduserlevels";
        mediasoftHTTP.actionProcess(url, [{
            userid: UserID,
            loadall: true,
            order: "userid",
            direction: "desc"
        }])
        .success(userSuccess)
        .error(loadError);
    }

    var awardSuccess = function (data, status) {
        $scope.showLoader = false;
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'success') {
            $scope.message = "Operation completed successfully";
            $scope.messagecss = "alert-success";
            loadUserLevel();
        }
        else {
            $scope.message = "Failed to delete record";
        }
    };


    $scope.award = function (_id, _icon) {
        $scope.showLoader = true;
        var url = apiPath + "gacore/award";
        mediasoftHTTP.actionProcess(url, [{ userid: UserID, badge_id: _id }])
        .success(awardSuccess)
        .error(loadError);
    };
}])

.controller('creditsController', ['$scope', 'mediasoftHTTP', 'localService', function ($scope, mediasoftHTTP, localService) {
    $scope.Nav = localService.getNav();
    $scope.NavOptions = localService.getNavOptions();
    $scope.selectedIndex = 4;  // credits
    $scope.message = "";
    $scope.type = 5; // 4: credits
    $scope.Data = [];
    $scope.Categories = [];
    $scope.userLevel = [];
    $scope.selectedID = 0;
    $scope.photocss = "img-rounded";
    $scope.photopath = imagedirectoryPath;
    $scope.photoname = ""; // name of photo to display
    $scope.defaultphoto = defaultimagePath;
    $scope.selectedCategory = 0;

    var loadSuccess = function (data, status) {
        $scope.showLoader = false;
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'error') {
            $scope.message = data.message;
        }
        else {
            if (typeof data.Records != "undefined") {
                $scope.Data = data.Records;
                // load user level information
                loadUserLevel();
            }
            else
                $scope.message = "Failed to open records";
        }
    };

    var categorySuccess = function (data, status) {
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'error') {
            $scope.message = data.message;
        }
        else {
            if (typeof data.Records != "undefined") {
                $scope.Categories = data.Records;
            }
            else
                $scope.message = "Failed to open records";
        }
    };
    var loadError = function (data, status, headers, config) {
        $scope.message = "Error occured";
    }

    $scope.filter = function (categoryid) {
        $scope.selectedID = categoryid;
        loadBadges(categoryid);
    };

    loadBadges(0); // load all badges

    function loadBadges(categoryid) {
        $scope.selectedCategory = categoryid;
        $scope.showLoader = true;
        var url = apiPath + "gabadges/load";
        mediasoftHTTP.actionProcess(url, [{
            type: $scope.type,
            category_id: categoryid,
            loadall: true,
            order: "priority",
            direction: "desc"
        }])
        .success(loadSuccess)
        .error(loadError);
    }

    
    var loadError = function (data, status, headers, config) {
        $scope.message = "Error occured";
    }

    var url = apiPath + "gacategories/load";
    mediasoftHTTP.actionProcess(url, [{
        type: $scope.type,
        loadall: true,
        order: "priority",
        direction: "desc"
    }])
    .success(categorySuccess)
    .error(loadError);

    var userSuccess = function (data, status) {
        $scope.showLoader = false;
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'error') {
            $scope.message = data.message;
        }
        else {
            if (typeof data.Records != "undefined") {
                $scope.userLevel = data.Records;
                if ($scope.userLevel.length > 0) {

                }
            }
            else
                $scope.message = "Failed to open records";
        }
    };


    function loadUserLevel() {
        $scope.showLoader = true;
        var url = apiPath + "gacore/loaduserlevels";
        mediasoftHTTP.actionProcess(url, [{
            userid: UserID,
            loadall: true,
            order: "userid",
            direction: "desc"
        }])
        .success(userSuccess)
        .error(loadError);
    }

    var awardSuccess = function (data, status) {
        $scope.showLoader = false;
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'success') {
            $scope.message = "Operation completed successfully";
            $scope.messagecss = "alert-success";
            loadUserLevel();
        }
        else {
            $scope.message = "Failed to delete record";
        }
    };


    $scope.award = function (_id, _icon) {
        $scope.showLoader = true;
        var url = apiPath + "gacore/award";
        mediasoftHTTP.actionProcess(url, [{ userid: UserID, badge_id: _id }])
        .success(awardSuccess)
        .error(loadError);
    };

}])
.controller('packagesController', ['$scope', 'mediasoftHTTP', 'localService', function ($scope, mediasoftHTTP, localService) {
    $scope.Nav = localService.getNav();
    $scope.NavOptions = localService.getNavOptions();
    $scope.selectedIndex = 5;  // packages
    $scope.message = "";
    $scope.type = 6; // 4: packages
    $scope.Data = [];
    $scope.Categories = [];
    $scope.selectedID = 0;
    $scope.photocss = "img-rounded";
    $scope.photopath = imagedirectoryPath;
    $scope.photoname = ""; // name of photo to display
    $scope.defaultphoto = defaultimagePath;
    $scope.selectedCategory = 0;

    var loadSuccess = function (data, status) {
        $scope.showLoader = false;
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'error') {
            $scope.message = data.message;
        }
        else {
            if (typeof data.Records != "undefined") {
                $scope.Data = data.Records;
            }
            else
                $scope.message = "Failed to open records";
        }
    };

    var categorySuccess = function (data, status) {
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'error') {
            $scope.message = data.message;
        }
        else {
            if (typeof data.Records != "undefined") {
                $scope.Categories = data.Records;
            }
            else
                $scope.message = "Failed to open records";
        }
    };
    var loadError = function (data, status, headers, config) {
        $scope.message = "Error occured";
    }

    $scope.filter = function (categoryid) {
        $scope.selectedID = categoryid;
        loadBadges(categoryid);
    };

    loadBadges(0); // load all badges

    function loadBadges(categoryid) {
        $scope.selectedCategory = categoryid;
        $scope.showLoader = true;
        var url = apiPath + "gabadges/load";
        mediasoftHTTP.actionProcess(url, [{
            type: $scope.type,
            category_id: categoryid,
            loadall: true,
            order: "priority",
            direction: "desc"
        }])
        .success(loadSuccess)
        .error(loadError);
    }

    var loadError = function (data, status, headers, config) {
        $scope.message = "Error occured";
    }

    var url = apiPath + "gacategories/load";
    mediasoftHTTP.actionProcess(url, [{
        type: $scope.type,
        loadall: true,
        order: "priority",
        direction: "desc"
    }])
    .success(categorySuccess)
    .error(loadError);

           
    var awardSuccess = function (data, status) {
        $scope.showLoader = false;
        var isObj = data instanceof Object;
        if (!isObj) {
            $scope.message = "Error occured while processing your request";
        }
        else if (data.status == 'success') {
            $scope.message = "Operation completed successfully";
            $scope.messagecss = "alert-success";
        }
        else {
            $scope.message = "Failed to delete record";
        }
    };
    
    $scope.award = function (_id, _icon) {
        $scope.showLoader = true;
        var url = apiPath + "gacore/award";
        mediasoftHTTP.actionProcess(url, [{ userid: UserID, badge_id: _id }])
        .success(awardSuccess)
        .error(loadError);
    };
}]);


var programServices = angular.module('programServices', []);
programServices.factory('localService', ['$http', 'mediasoftHTTP',
   function ($http, mediasoftHTTP) {
       var navPath = templatePath + "simulate/partials/nav.html";
       var navOptions = [{
           name: "Badges",
           icon: "glyphicon-bookmark",
           redirect: "#/",
           index: 0,
           type: 1
       }, {
           name: "Rewards",
           icon: "glyphicon-heart",
           redirect: "#/rewards",
           index: 1,
           type: 2
       }, {
           name: "Levels",
           icon: "glyphicon-signal",
           redirect: "#/levels",
           index: 2,
           type: 3
       }, {
           name: "Points",
           icon: "glyphicon-star",
           redirect: "#/points",
           index: 3,
           type: 4
       }, {
           name: "Credits",
           icon: "glyphicon-book",
           redirect: "#/credits",
           index: 4,
           type: 5
       }, {
           name: "Packages",
           icon: "glyphicon-qrcode",
           redirect: "#/packages",
           index: 5,
           type: 6
       }];
       var servayTopics = [];
       var actionSuccess = function (data, status) {
           if (data.status == 'success') {

           } else {
               alert("action failed");
           }
       }

       var actionError = function (data, status, headers, config) {
           alert("error occured");
       }

       return {
           getNav: function () {
               return navPath;
           },
           getNavOptions: function () {
               return navOptions;
           },
           getCaption: function (type) {
               var _name = "";
               for (var i = 0; i < navOptions.length; i++) {
                   if (navOptions[i].index == type)
                       _name = navOptions[i - 1].name;
               }
               return _name;
           },
           setTopic: function (topic) {
               servayTopics = topic;
           },
           AddQuestion: function (obj) {
               var url = domain + "topicquestion/create/";
               mediasoftHTTP.actionProcess(url, obj)
                .success(actionSuccess)
                .error(actionError);
           }
       };
   }]);

// $http module
var httpServices = angular.module('httpServices', []);
httpServices.factory('mediasoftHTTP', ['$http',
function ($http) {
    return {
        httpProcess: function (url) {
            return $http.get(url);
        },
        actionProcess: function (url, paramOptions) {
            return $http.post(url, paramOptions);
        }
    };
}]);

