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
<div class="form-group form-inlinex"
	 ng-controller="Tags.TagEdit"
	 ng-init="init(<?php printf("%d, '%s', %s", Current::read('Block.id'), $modelName, h($tagsJson)) ?>)">

	<label class="control-label">
		<?php echo __d('tags', 'tag'); ?>
	</label>

	<div class="form-inline">
		<input type="text" ng-model="newTag[0]" ng-change="change(0)" ng-keydown="handleEnterKeydown($event)" class="form-control" />
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
	<p class="help-block"><?php echo __d('tags', 'Tag, please be entered in single-byte comma-separated.') ?></p>

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


