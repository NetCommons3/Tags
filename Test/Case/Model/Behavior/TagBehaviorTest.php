<?php
/**
 * TagBehavior Test Case
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('TagBehavior', 'Tags.Model/Behavior');
App::uses('TagsAppTest', 'Tags.Test/Case/Model');

/**
 * テスト用Fake
 */
class Block extends CakeTestModel {

/**
 * @var bool fakeなのでテーブル使わない
 */
	public $useTable = false;
}

/**
 * テスト用Fake
 */
class Language extends CakeTestModel {

/**
 * @var bool fakeなのでテーブル使わない
 */
	public $useTable = false;
}

/**
 * テスト用Fake
 */
class FakeModel extends TagsAppTest {

/**
 * @var array ビヘイビア
 */
	public $actsAs = array('Tags.Tag');

/**
 * schema property
 *
 * @var array
 */
	protected $_schema = array(
		'id' => array('type' => 'integer', 'null' => '', 'default' => '1', 'length' => '8', 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
		'created' => array('type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
		'updated' => array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
	);
}

/**
 * Summary for TagBehavior Test Case
 */
class TagBehaviorTest extends TagsAppTest {

/**
 * fixtures property
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.tags.fake_model',
		'plugin.tags.tag',
		'plugin.tags.tags_content',
		//'plugin.blocks.block',
		//'plugin.net_commons.language',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		// Trackableビヘイビアに引っ張られないために
		$TagModel = ClassRegistry::init('Tags.Tag');
		$this->_unloadTrackable($TagModel);
		//$TagsContentModel = ClassRegistry::init('Tags.TagsContent');
		//$this->_unloadTrackable($TagsContentModel);

		$this->Tag = new TagBehavior();
	}


/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Tag);

		parent::tearDown();
	}

/**
 * 元モデルが削除されて使われなくなったタグが削除されるテスト
 *
 * @return void
 */
	public function testDelete() {
		$FakeModel = ClassRegistry::init('FakeModel');
		$FakeModel->Behaviors->unload('NetCommons.Trackable');

		//$FakeModel->delete(1);
		$count = $FakeModel->find('count');
		$this->assertEqual($count, 2);
		$FakeModel->deleteAll(array('origin_id' => 1), true, true);
		$count = $FakeModel->find('count');
		$this->assertEqual($count, 0);
	}
}
