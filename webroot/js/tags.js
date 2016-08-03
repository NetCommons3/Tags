/**
 * Created by ryuji on 15/04/30.
 */
NetCommonsApp.controller('Tags.TagEdit',
    ['$scope', '$filter', '$http', 'filterFilter', 'NC3_URL',
      function($scope, $filter, $http, filterFilter, NC3_URL) {
        var where = $filter('filter');

        $scope.blockId = 0;
        $scope.modelName = '';
        $scope.tags = [];


        $scope.init = function(blockId, modelName, tags) {
          if (tags) {
            $scope.tags = tags;
          }
          $scope.modelName = modelName;
          $scope.blockId = blockId;
        };

        $scope.newTag = '';


        $scope.tagExist = function(newTag) {
          var result = filterFilter($scope.tags, newTag);
          return (result.length > 0);
        };

        $scope.addTag = function() {
          if ($scope.newTag.length > 0) {
            if ($scope.tagExist($scope.newTag) === false) {
              $scope.tags.push({
                name: $scope.newTag
              });
              $scope.newTag = '';
              $scope.showResult = false;
            }
          }
        };

        $scope.showResult = false;
        $scope.showResultStyle = {};
        $scope.tagSearchResult = [];
        $scope.searchUrl = NC3_URL + '/tags/tags/search/';
        // タグ補完
        $scope.change = function() {
          if ($scope.newTag.length > 2) {
            // 3文字以上になったら検索してみる
            //  タグ候補を検索
            var url = $scope.searchUrl + $scope.blockId +
                '/keyword:' + $scope.newTag + '/target:' + $scope.modelName +
                '/' + Math.random() + '.json';
            // console.log(url);
            $http.get(url).success(function(data, status, headers, config) {
              $scope.tagSearchResult = data.results;
              if ($scope.tagSearchResult.length > 0) {
                $scope.showResult = true;
              } else {
                $scope.showResult = false;
              }

            }).error(function(data, status, headers, config) {
              // console.log(data);
            });
          }
        };


        $scope.selectTag = function(selectedTag) {
          $scope.newTag = selectedTag;
          //$scope.showResultStyle = {display:"none"}
          //$scope.showResult = false;
          $scope.showResult = false;
        };

        // 任意の tag を削除
        $scope.removeTag = function(currentTag) {
          $scope.tags = where($scope.tags, function(tag) {
            return currentTag !== tag;
          });
        };
      }
    ]
);
