<?php
/**
 * TagsContentFixture
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for TagsContentFixture
 */
class TagsContentFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'model' => 'BlogEntry',
			'content_id' => 1,
			'tag_id' => 1,
			'created_user' => 1,
			'created' => '2015-05-12 06:32:38',
			'modified_user' => 1,
			'modified' => '2015-05-12 06:32:38'
		),
		array(
			'id' => 2,
			'model' => 'FakeModel',
			'content_id' => 1,
			'tag_id' => 4,
			'created_user' => 1,
			'created' => '2015-05-12 06:32:38',
			'modified_user' => 1,
			'modified' => '2015-05-12 06:32:38'
		),
		array(
			'id' => 3,
			'model' => 'FakeModel',
			'content_id' => 1,
			'tag_id' => 5,
			'created_user' => 1,
			'created' => '2015-05-12 06:32:38',
			'modified_user' => 1,
			'modified' => '2015-05-12 06:32:38'
		),
		array(
			'id' => 4,
			'model' => 'Video',
			'content_id' => 1,
			'tag_id' => 6,
			'created_user' => 1,
			'created' => '2015-05-12 06:32:38',
			'modified_user' => 1,
			'modified' => '2015-05-12 06:32:38'
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Tags') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new TagsSchema())->tables['tags_contents'];
		parent::init();
	}

}
