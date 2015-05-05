/**
 * Created by ryuji on 15/04/30.
 */
NetCommonsApp.controller('Blogs.BlogTagEdit',
  function ($scope, $filter, $http, $document) {
    var where = $filter('filter');

    $scope.frameId = 0;

    $scope.tags = [];
    $scope.newTag = '';

    $scope.init = function(frameId, tags){
      $scope.tags = (tags) ? tags : [];
      $scope.frameId = frameId;


    }


    $scope.addTag = function () {
      if($scope.newTag.length > 0){
        $scope.tags.push({
          name: $scope.newTag
        });
        $scope.newTag = '';
        $scope.showResult = false;

      }
    }

    $scope.showResult = false;
    $scope.showResultStyle = {};
    $scope.tagSearchResult = [];
    $scope.searchUrl = '/blogs/blog_tags/search/';
    // タグ補完
    $scope.change = function () {
      if($scope.newTag.length > 2){
        // 3文字以上になったら検索してみる
        // TODO タグ候補を検索
        var url = $scope.searchUrl + $scope.frameId + '/keyword:' + $scope.newTag + '/request.json';
//console.log(url);
        $http.get(url).
          success(function(data, status, headers, config) {
            $scope.tagSearchResult = data;
            if($scope.tagSearchResult.length > 0){
              $scope.showResult = true;
            }else{
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
    }



    $scope.selectTag = function (selectedTag) {
      $scope.newTag = selectedTag;
      //$scope.showResultStyle = {display:"none"}
      //$scope.showResult = false;
      $scope.showResult = false;
    }

    // 任意の tag を削除
    $scope.removeTag = function (currentTag) {
      $scope.tags = where($scope.tags, function (tag) {
        return currentTag !== tag;
      });
    };

  }
)
