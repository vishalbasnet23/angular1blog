'use strict';

/**
 * @ngdoc service
 * @name blogApp.wpFactory
 * @description
 * # wpFactory
 * Factory in the blogApp.
 */
angular.module('blogApp')
  .factory('wpFactory', function ( $http, $q ) {
    var mainUrl = 'http://localhost/vb23/wp-json/wp/v2';
    var customizerUrl = 'http://localhost/vb23/wp-json/customizer/v1/customizer-fields';

    function handleSuccess(response) {
      return response.data;
    }
    function handleError(response) {
      if(!angular.isObject(response.data) || !response.data.message) {
        return($q.reject("Error"));
      } else {
        return($q.reject(response.data.message));
      }
    }
    function getPosts(perPage, offSet) {
      return($http.get(mainUrl+'/posts?per_page='+perPage+'&offset='+offSet+'&order=desc')
      .then(handleSuccess, handleError));
    }
    function getPost(postSlug) {
      return($http.get(mainUrl+'/posts?filter[name]='+postSlug)
      .then(handleSuccess, handleError));
    }
    function getPostsByCat(catSlug, limit, offset) {
      return($http.get(mainUrl+'/posts?filter[category_name]='+catSlug+'&per_page='+limit+'&offset='+offset)
      .then(handleSuccess,handleError));
    }
    function getCustomizerFields() {
      return($http.get(customizerUrl)
      .then(handleSuccess, handleError));
    };

    return({
      getPosts: getPosts,
      getPost: getPost,
      getCustomizerFields: getCustomizerFields,
      getPostsByCat: getPostsByCat
    })
  });
