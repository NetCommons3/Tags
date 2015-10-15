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
		$FakeModel->deleteAll(array('key' => 1), true, true);
		$count = $FakeModel->find('count');
		$this->assertEqual($count, 0);
	}

/**
 * タグ取得
 *
 * @return void
 */
	public function testGetTagByTagId() {
		$FakeModel = ClassRegistry::init('FakeModel');
		$this->_unloadTrackable($FakeModel);

		$tag = $FakeModel->getTagByTagId(1);
		$this->assertEqual($tag['Tag']['name'], 'タグ1');
	}

/**
 * test After save
 *
 * @return void
 */
	public function testAfterSave() {
		$FakeModel = ClassRegistry::init('FakeModel');
		$this->_unloadTrackable($FakeModel);

		$FakeModel->create();
		$data['FakeModel']['block_id'] = 1;
		$data['Tag'] = array(
			'name' => 'tag1',
			'name' => 'tag2',
		);
		$result = $FakeModel->save($data);
		$this->assertInternalType('array', $result);

		//Tag save fail
		$mock = $this->getMockForModel('Tags.Tag', ['saveTags']);
		$mock->expects($this->once())
			->method('saveTags')
			->will($this->returnValue(false));

		$FakeModel->create();
		$this->setExpectedException('InternalErrorException');
		$FakeModel->save($data);
	}

/**
 * タグ条件ありのFind
 *
 * @return void
 */
	public function testFindWithTag() {
		$FakeModel = ClassRegistry::init('FakeModel');
		$this->_unloadTrackable($FakeModel);

		$conditions = array('Tag.id' => 1);
		$result = $FakeModel->find('all', array('conditions' => $conditions));
		$this->assertInternalType('array', $result);

		$conditions = array('TagsContent.tag_id' => 1);
		$result = $FakeModel->find('all', array('conditions' => $conditions));
		$this->assertInternalType('array', $result);
	}

/**
 * test beforeFind. 1コンテンツに複数タグがついていて、その複数タグが検索にヒットしても、検索結果に同じコンテンツが複数でてこないこと。
 *
 * @see https://github.com/NetCommons3/Tags/issues/5
 * @return void
 */
	public function testFixFindResultContentsDuplicate() {
		$FakeModel = ClassRegistry::init('FakeModel');
		$this->_unloadTrackable($FakeModel);

		$conditions = array('Tag.name LIKE ' => 'タグ%');
		$result = $FakeModel->find('all', array('conditions' => $conditions));
		$this->assertInternalType('array', $result);

		// ヒットするタグが複数あっても、結びついてるコンテンツは1つだけなので、検索結果は1件。
		$this->assertEquals(1, count($result));
	}

/**
 * 検索結果にタグがくっついてるか
 *
 * @return void
 */
	public function testAfterFind() {
		$FakeModel = ClassRegistry::init('FakeModel');
		$this->_unloadTrackable($FakeModel);

		$fake = $FakeModel->findById(1);
		$this->assertEquals(count($fake['Tag']), 2);
	}

/**
 * モデルの別名使用テスト
 *
 * @return void
 */
	public function testGetTagUsedAlias() {
		$FakeModel = ClassRegistry::init(array('class' => 'FakeModel', 'alias' => 'FakeModelAlias'));
		$this->_unloadTrackable($FakeModel);

		$conditions = array('Tag.id' => 1);
		$result = $FakeModel->find('all', array('conditions' => $conditions));
		$this->assertInternalType('array', $result);
	}
}
