<?php
/**
 * TagFixture
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for TagFixture
 */
class TagFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'block_id' => 1,
			'model' => 'BlogEntry',
			'key' => '1',
			'language_id' => 1,
			'name' => 'タグ1',
			'created_user' => 1,
			'created' => '2015-05-05 01:32:05',
			'modified_user' => 1,
			'modified' => '2015-05-05 01:32:05'
		),
		array(
			'id' => 2,
			'block_id' => 5,
			'model' => 'BlogEntry',
			'key' => '2',
			'language_id' => 1,
			'name' => 'タグ2',
			'created_user' => 1,
			'created' => '2015-05-05 01:32:05',
			'modified_user' => 1,
			'modified' => '2015-05-05 01:32:05'
		),
		array(
			'id' => 3,
			'block_id' => 5,
			'model' => 'BlogEntry',
			'key' => '3',
			'language_id' => 1,
			'name' => 'タグ3',
			'created_user' => 1,
			'created' => '2015-05-05 01:32:05',
			'modified_user' => 1,
			'modified' => '2015-05-05 01:32:05'
		),
		array(
			'id' => 4,
			'block_id' => 1,
			'model' => 'FakeModel',
			'key' => '4',
			'language_id' => 1,
			'name' => 'タグ4',
			'created_user' => 1,
			'created' => '2015-05-05 01:32:05',
			'modified_user' => 1,
			'modified' => '2015-05-05 01:32:05'
		),
		array(
			'id' => 5,
			'block_id' => 1,
			'model' => 'FakeModel',
			'key' => '5',
			'language_id' => 1,
			'name' => 'タグ5',
			'created_user' => 1,
			'created' => '2015-05-05 01:32:05',
			'modified_user' => 1,
			'modified' => '2015-05-05 01:32:05'
		),
		array(
			'id' => 6,
			'block_id' => 2,
			'model' => 'Video',
			'key' => '6',
			'language_id' => 2,
			'name' => 'タグ6',
			'created_user' => 1,
			'created' => '2015-05-05 01:32:05',
			'modified_user' => 1,
			'modified' => '2015-05-05 01:32:05'
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Tags') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new TagsSchema())->tables['tags'];
		parent::init();
	}

}
