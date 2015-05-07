/**
 * Created by ryuji on 15/04/30.
 */
NetCommonsApp.controller('Tags.TagEdit',
    function($scope, $filter, $http) {
      var where = $filter('filter');

      $scope.frameId = 0;
      $scope.modelName = '';
      $scope.tags = [];


      $scope.init = function(frameId, modelName, tags) {
        console.log(tags);
        if (tags) {
          $scope.tags = tags;
        }
        console.log($scope.tags);
        $scope.modelName = modelName;
        $scope.frameId = frameId;
      };

      $scope.newTag = '';

      $scope.addTag = function() {
        if ($scope.newTag.length > 0) {
          $scope.tags.push({
            name: $scope.newTag
          });
          $scope.newTag = '';
          $scope.showResult = false;

        }
      };

      $scope.showResult = false;
      $scope.showResultStyle = {};
      $scope.tagSearchResult = [];
      $scope.searchUrl = '/tags/tags/search/';
      // タグ補完
      $scope.change = function() {
        if ($scope.newTag.length > 2) {
          // 3文字以上になったら検索してみる
          //  タグ候補を検索
          var url = $scope.searchUrl + $scope.frameId + '/keyword:' + $scope.newTag + '/target:' + $scope.modelName + '/' + Math.random() + '.json';
          console.log(url);
          $http.get(url).
              success(function(data, status, headers, config) {
                $scope.tagSearchResult = data;
                if ($scope.tagSearchResult.length > 0) {
                  $scope.showResult = true;
                } else {
                  $scope.showResult = false;
                }

              }).
              error(function(data, status, headers, config) {
                console.log(data);
              });
          //$scope.tagSearchResult = ["結果1", "結果2", "結果3"];
          //
          //$scope.showResultStyle = {display:"block"}

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
);
