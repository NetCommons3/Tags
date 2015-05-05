<div class="form-group"
	 ng-controller="Blogs.BlogTagEdit"
	 ng-init="init(<?php echo $frameId; ?>, <?php echo h(json_encode($tagData)); ?> )">
	<label class="control-label">
		<?php echo __d('blogs', 'tag'); ?>
	</label>

	<div>
		<input type="text" ng-model="newTag" ng-change="change()"/>
		<button type="button" class="btn btn-success btn-xs" ng-click="addTag()">
			<span class=""><?php echo __d('blogs', 'Add tag') ?></span>
		</button>
	</div>

	<div class="dropdown" ng-show="showResult">
		<ul class="dropdown-menu" style="display: block" >
			<li role="presentation">
				<a role="menuitem" tabindex="-1" href="#" ng-repeat="searchTag in tagSearchResult" ng-click="selectTag(searchTag)">
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
			<input type="hidden" name="data[BlogTag][{{$index}}][name]" value="{{tag.name}}"/>
		</span>
	</div>
</div>


