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
            templateUrl: templatePath + "display/core.html",
            controller: 'manageController'
        }).
        when('/rewards', {
            templateUrl: templatePath + "display/rewards.html",
            controller: 'rewardsController'
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
    $scope.userInfo = [];
    $scope.Categories = [];
    $scope.userBadges = [];
    $scope.userRewards = [];
    $scope.userPackages = [];
    $scope.selectedID = 0;
    $scope.photocss = "img-rounded";
    $scope.photopath = imagedirectoryPath;
    $scope.photoname = ""; // name of photo to display
    $scope.defaultphoto = defaultimagePath;
    $scope.selectedCategory = 0;

    // user level information
    var ulevelSuccess = function (data, status) {
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
                $scope.userInfo = data.Records;
                loadUserBadges();
            }
            else
                $scope.message = "Failed to open records";
        }
    };

    var loadError = function (data, status, headers, config) {
        $scope.message = "Error occured";
    }

    loadusersinfo();

    function loadusersinfo() {
        $scope.showLoader = true;
        var url = apiPath + "gacore/loaduserinfo";
        mediasoftHTTP.actionProcess(url, [{
            userid: UserID,
            loadall: true,
            order: "u.userid",
            direction: "desc"
        }])
        .success(ulevelSuccess)
        .error(loadError);
    }


    // user badges information

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
                loadUserRewards();
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
            type: 1,
            loadall: true,
            order: "badge_id",
            direction: "desc"
        }])
        .success(userSuccess)
        .error(loadError);
    }

    var urewardsSuccess = function (data, status) {
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
                $scope.userRewards = data.Records;
                loadUserPackages();
            }
            else
                $scope.message = "Failed to open records";
        }
    };


    function loadUserRewards() {
        $scope.showLoader = true;
        var url = apiPath + "gauserbadges/load";
        mediasoftHTTP.actionProcess(url, [{
            userid: UserID,
            type: 2,
            loadall: true,
            order: "badge_id",
            direction: "desc"
        }])
        .success(urewardsSuccess)
        .error(loadError);
    }

    var packagesSuccess = function (data, status) {
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
                $scope.userPackages = data.Records;
            }
            else
                $scope.message = "Failed to open records";
        }
    };


    function loadUserPackages() {
        $scope.showLoader = true;
        var url = apiPath + "gauserbadges/load";
        mediasoftHTTP.actionProcess(url, [{
            userid: UserID,
            type: 3,
            loadall: true,
            order: "badge_id",
            direction: "desc"
        }])
        .success(packagesSuccess)
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
        var url = apiPath + "simulate/badges/award.php";
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
    $scope.type = 0; // all
    $scope.Data = [];
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
                for (var i = 0; i < $scope.Data.length; i++) {
                    switch (parseInt($scope.Data[i].type)) {
                        case 1:
                            $scope.Data[i].typecaption = "Badge";
                            break;
                        case 2:
                            $scope.Data[i].typecaption = "Reward";
                            break;
                        case 3:
                            $scope.Data[i].typecaption = "Level";
                            break;
                        case 4:
                            $scope.Data[i].typecaption = "Points";
                            break;
                        case 5:
                            $scope.Data[i].typecaption = "Credits";
                            break;
                        case 6:
                            $scope.Data[i].typecaption = "Package";
                            break;
                    }
                }
            }
            else
                $scope.message = "Failed to open records";
        }
    };
      

    loadAchivements(); 

    function loadAchivements() {
        $scope.showLoader = true;
        var url = apiPath + "gacore/loadachievements";
        mediasoftHTTP.actionProcess(url, [{
            type: $scope.type,
            userid: UserID,
            loadall: false,
            order: "id",
            direction: "desc"
        }])
        .success(loadSuccess)
        .error(loadError);
    }


    var loadError = function (data, status, headers, config) {
        $scope.message = "Error occured";
    }

}]);


var programServices = angular.module('programServices', []);
programServices.factory('localService', ['$http', 'mediasoftHTTP',
   function ($http, mediasoftHTTP) {
       var navPath = templatePath + "display/partials/nav.html";
       var navOptions = [{
           name: "Summary",
           icon: "glyphicon-bookmark",
           redirect: "#/",
           index: 0,
           type: 1
       }, {
           name: "Achievements",
           icon: "glyphicon-heart",
           redirect: "#/rewards",
           index: 1,
           type: 2
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

