<?php
/**
 * Tag Test Case
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Tag', 'Tags.Model');
App::uses('TagsAppTest', 'Tags.Test/Case/Model');

/**
 * Summary for Tag Test Case
 */
class TagTest extends TagsAppTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.tags.tag',
		'plugin.tags.tags_content',
		//'plugin.tags.block',
		//'plugin.tags.user',
		//'plugin.tags.role',
		//'plugin.tags.group',
		//'plugin.tags.room',
		//'plugin.tags.space',
		//'plugin.tags.box',
		//'plugin.tags.page',
		//'plugin.tags.language',
		//'plugin.tags.groups_language',
		//'plugin.tags.groups_user',
		//'plugin.tags.user_attribute',
		//'plugin.tags.user_attributes_user',
		//'plugin.tags.user_select_attribute',
		//'plugin.tags.user_select_attributes_user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Tag = ClassRegistry::init('Tags.Tag');
		$this->TagsContent = ClassRegistry::init('Tags.TagsContent');
		$this->_unloadTrackable($this->Tag);
		$this->_unloadTrackable($this->TagsContent);
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
 * testGetTagsByContentId method
 *
 * @return void
 */
	public function testGetTagsByContentId() {
		$contentId = 1;
		$tags = $this->Tag->getTagsByContentId('BlogEntry', $contentId);

		$this->assertEqual(count($tags), 1);

		$noTagContentId = 100;
		$tags = $this->Tag->getTagsByContentId('BlogEntry', $noTagContentId);
		$this->assertEqual(count($tags), 0);
	}

/**
 * testSaveTags method
 *
 * @return void
 */
	public function testSaveTags() {
		$blockId = 2;
		$modelName = 'BlogEntry';
		$contentId = 2;
		$tags = array(
			array('name' => 'タグ1'),
			array('name' => 'タグ2'),
			array('name' => 'タグ3'),
		);
		$this->Tag->saveTags($blockId, $modelName, $contentId, $tags);
		$tag1 = $this->Tag->findByBlockIdAndModelAndName($blockId, $modelName, 'タグ1');
		$tag2 = $this->Tag->findByBlockIdAndModelAndName($blockId, $modelName, 'タグ2');
		$tag3 = $this->Tag->findByBlockIdAndModelAndName($blockId, $modelName, 'タグ3');
		$this->assertEqual($tag1['Tag']['name'],'タグ1');
		$this->assertEqual($tag2['Tag']['name'],'タグ2');
		$this->assertEqual($tag3['Tag']['name'],'タグ3');
	}

/**
 * タグ無しでSaveしようとしたら何もしないでTrueを返して終了
 *
 * @return void
 */
	public function testSaveNoTags() {
		$blockId = 2;
		$modelName = 'BlogEntry';
		$contentId = 2;
		$tags = null;
		$resultTrue = $this->Tag->saveTags($blockId, $modelName, $contentId, $tags);
		$this->assertTrue($resultTrue);
	}

// TODO save fail
// TODO TagsContent save fail

/**
 * testCleanup method
 * TODO
 * @return void
 */
	public function testCleanup() {
	}

}
