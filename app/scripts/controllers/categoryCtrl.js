'use strict';

/**
 * @ngdoc function
 * @name blogApp.controller:categoryCtrl
 * @description
 * # categoryCtrl
 * Controller of the blogApp
 */
angular.module('blogApp')
  .controller('categoryCtrl', function ( $scope, wpFactory, $routeParams, $http) {
    $scope.posts = [];
    $scope.offSet = 0;
    $scope.postEnd = false;
    $scope.customizerFields;
    $scope.FeaturedPosts;
    $scope.MostViewedPosts;
    $scope.CatSlug = $routeParams.slug;
    $scope.allPosts = function() {
      wpFactory.getPostsByCat($scope.CatSlug, 5, $scope.offSet).then(function(success){
        $scope.posts = success;
        $scope.offSet+=5;
        document.querySelector('title').innerHTML = 'Home | '+$scope.CatSlug;
      },function error(err){
        console.log(err);
      })
    }
    $scope.allPosts();
    $scope.loadMore = function(offset) {
      wpFactory.getPostsByCat($scope.CatSlug, 5, offset).then(function(success){
        angular.forEach(success, function(value, key) {
          $scope.posts.push(value);
        });
        $scope.offSet+=5;
        if(success.length <= 0 ) {
          $scope.postEnd = true;
        }
      },function error(err){
        console.log(err);
      })
    };
    $scope.getCustomizerFields = function() {
      wpFactory.getCustomizerFields().then(function(success){
        $scope.customizerFields = success
      }, function error(err) {
        console.log(err);
      });
    };
    $scope.getCustomizerFields();
    $scope.getFeaturedPosts = function() {
      wpFactory.getPostsByCat('featured', 3).then(function(success){
        $scope.FeaturedPosts = success;
      }, function error(err) {
        console.log(err);
      });
    };
    $scope.getFeaturedPosts();
    $scope.getMostViewedPosts = function() {
      wpFactory.getPostsByCat('most-viewed', 5).then(function(success){
        $scope.MostViewedPosts = success;
      }, function error(err) {
        console.log(err);
      });
    };
    $scope.getMostViewedPosts();

  });
