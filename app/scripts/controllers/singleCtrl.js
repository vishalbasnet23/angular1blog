'use strict';

/**
 * @ngdoc function
 * @name blogApp.controller:SingleCtrl
 * @description
 * # SingleCtrl
 * Controller of the blogApp
 */
angular.module('blogApp')
  .controller('SingleCtrl', function ( $scope, wpFactory, $routeParams, $http) {
    $scope.post;
    $scope.slug = $routeParams.slug;
    $scope.customizerFields;
    $scope.FeaturedPosts;
    $scope.MostViewedPosts;
    $scope.getPost = function(){
      wpFactory.getPost($scope.slug).then(function(success){
        $scope.post = success[0];
        document.querySelector('title').innerHTML = success[0].title.rendered;
      },function error(err) {
        console.log(err);
      })
    }
    $scope.getPost();
    $scope.getCustomizerFields = function() {
      wpFactory.getCustomizerFields().then(function(success){
        $scope.customizerFields = success
      }, function error(err) {
        console.log(err);
      });
    };
    $scope.getCustomizerFields();
    $scope.getFeaturedPosts = function() {
      wpFactory.getPostsByCat('featured', 3, 0).then(function(success){
        $scope.FeaturedPosts = success;
      }, function error(err) {
        console.log(err);
      });
    };
    $scope.getFeaturedPosts();
    $scope.getMostViewedPosts = function() {
      wpFactory.getPostsByCat('most-viewed', 5, 0).then(function(success){
        $scope.MostViewedPosts = success;
      }, function error(err) {
        console.log(err);
      });
    };
    $scope.getMostViewedPosts();
  });
