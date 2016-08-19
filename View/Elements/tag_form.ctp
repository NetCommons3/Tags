<?php
if ($tagData) {
	$tags = array();
	foreach ($tagData as $tag) {
		$tags[] = array(
			'name' => $tag['name'],
		);
	}
	$tagsJson = json_encode($tags);
} else {
	$tagsJson = json_encode(array());
}
?>
<style>
	.tags-textbox{
		width:120px;
	}
</style>
<div class="form-group form-inline"
	 ng-controller="Tags.TagEdit"
	 ng-init="init(<?php printf("%d, '%s', %s", Current::read('Block.id'), $modelName, h($tagsJson)) ?>)">

	<label class="control-label">
		<?php echo __d('tags', 'tag'); ?>
	</label>

	<div>
		<input type="text" ng-model="newTag[0]" ng-change="change(0)" class="form-control"
			style="width:120px;"/>
		<input type="text" ng-model="newTag[1]" ng-change="change(1)" class="form-control"
			style="width:120px;"/>
		<button type="button" class="btn btn-success btn-s" ng-click="addTag()">
			<span class=""><?php echo __d('tags', 'Add tag') ?></span>
		</button>
	</div>

	<div class="dropdown" ng-show="showResult[0]">
		<ul class="dropdown-menu" style="display: block" >
			<li role="presentation">
				<a role="menuitem" tabindex="-1" href="#" ng-repeat="searchTag in
				tagSearchResult[0]" ng-click="selectTag(searchTag, 0)">
					{{searchTag}}
				</a>
			</li>
		</ul>

	</div>
	<div class="dropdown" ng-show="showResult[1]" style="margin-left: 120px;">
		<ul class="dropdown-menu" style="display: block" >
			<li role="presentation">
				<a role="menuitem" tabindex="-1" href="#" ng-repeat="searchTag in
				tagSearchResult[1]" ng-click="selectTag(searchTag, 1)">
					{{searchTag}}
				</a>
			</li>
		</ul>

	</div>

	<div>
		<span ng-repeat="tag in tags" >
			<span class="label label-default" ng-click="removeTag(tag)" style="cursor:pointer ">
				{{tag.name}}
				&nbsp;
				<span class="glyphicon glyphicon-remove small"><span class="sr-only">Remove tags</span> </span>
			</span>
			&nbsp;
			<input type="hidden" name="data[Tag][{{$index}}][name]" value="{{tag.name}}"/>
		</span>
	</div>
</div>


