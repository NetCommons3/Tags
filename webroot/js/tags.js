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
          var result = filterFilter($scope.tags, newTag, true);
          return (result.length > 0);
        };

        $scope.addTag = function() {
          angular.forEach($scope.newTag, function(newTag, index) {
            if (newTag.length > 0) {
              // カンマ区切りで分割する

              var addTags = $scope.zenkakuCommmaReplace(newTag).split(',');
              angular.forEach(addTags, function(newTag, index) {
                // 各タグを追加する
                if ($scope.tagExist(newTag) === false) {
                  $scope.tags.push({
                    name: newTag
                  });
                }
              });
            }
            $scope.newTag[index] = '';
            $scope.showResult = [false, false];

          });
        };

        $scope.showResult = [false, false];
        $scope.showResultStyle = {};
        $scope.tagSearchResult = [];

        $scope.searchUrl = NC3_URL + '/tags/tags/search/';

        $scope.zenkakuCommmaReplace = function(tagString) {
          var result = tagString.replace(/(、|，)/g, ',');
          return result;
        };

        // タグ補完
        $scope.change = function(index) {
          // 、　，　　
          var str = $scope.newTag[index];
          // $scope.newTag[index] = $scope.zenkakuCommmaReplace($scope.newTag[index]);
          str = $scope.zenkakuCommmaReplace(str);
          // $scope.zenkakuCommmaReplace($scope.newTag[index]);
          var addTags = str.split(',');

          var inputTag = addTags.pop();
          if (inputTag.length > 0) {
            // 3文字以上になったら検索してみる
            //  タグ候補を検索
            var url = $scope.searchUrl + $scope.blockId +
                '/keyword:' + inputTag + '/target:' + $scope.modelName +
                '/' + Math.random() + '.json';
            $http.get(url).then(function(response) {
              var data = response.data;
              $scope.tagSearchResult[index] = data.results;
              if ($scope.tagSearchResult[index].length > 0) {
                $scope.showResult[index] = true;
              } else {
                $scope.showResult[index] = false;
              }

            }, function(response) {
              //var data = response.data;
              // console.log(data);
            });
          }
          // カンマを変換した文字列を戻したいが、
          // 全角文字がはいってるときはng-change処理中にmodel書き換えると変換した文字列と変換元の文字列が連結されて再度呼び出されてしまうので断念
          // $scope.newTag[index] = str;
        };


        $scope.selectTag = function(selectedTag, index) {

          var addTags = $scope.zenkakuCommmaReplace($scope.newTag[index]).split(',');
          addTags.pop();
          addTags.push(selectedTag);

          $scope.newTag[index] = addTags.join(',');
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

        $scope.handleEnterKeydown = function(e) {
          if (e.which == 13) { // enterキー
            $scope.addTag();
          }
        };
      }
    ]
);
