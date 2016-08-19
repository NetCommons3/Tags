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

        $scope.newTag = ['', ''];


        $scope.tagExist = function(newTag) {
          var result = filterFilter($scope.tags, newTag);
          return (result.length > 0);
        };

        $scope.addTag = function() {
          angular.forEach($scope.newTag, function(newTag, index) {
            if (newTag.length > 0) {
              if ($scope.tagExist(newTag) === false) {
                $scope.tags.push({
                  name: newTag
                });
              }
            }
            $scope.newTag[index] = '';
            $scope.showResult = [false, false];

          })
        };

        $scope.showResult = [false, false];
        $scope.showResultStyle = {};
        $scope.tagSearchResult = [];
        $scope.searchUrl = NC3_URL + '/tags/tags/search/';
        // タグ補完
        $scope.change = function(index) {
          if ($scope.newTag[index].length > 2) {
            // 3文字以上になったら検索してみる
            //  タグ候補を検索
            var url = $scope.searchUrl + $scope.blockId +
                '/keyword:' + $scope.newTag[index] + '/target:' + $scope.modelName +
                '/' + Math.random() + '.json';
            $http.get(url).success(function(data, status, headers, config) {
              $scope.tagSearchResult[index] = data.results;
              if ($scope.tagSearchResult[index].length > 0) {
                $scope.showResult[index] = true;
              } else {
                $scope.showResult[index] = false;
              }

            }).error(function(data, status, headers, config) {
              // console.log(data);
            });
          }
        };


        $scope.selectTag = function(selectedTag, index) {
          $scope.newTag[index] = selectedTag;
          //$scope.showResultStyle = {display:"none"}
          //$scope.showResult = false;
          $scope.showResult[index] = false;
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
