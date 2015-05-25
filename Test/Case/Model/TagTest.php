<?php
/**
 * Tag Test Case
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Tag', 'Tags.Model');

/**
 * Summary for Tag Test Case
 */
class TagTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.tags.tag',
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
	}

/**
 * testSaveTags method
 *
 * @return void
 */
	public function testSaveTags() {
	}

/**
 * testCleanup method
 *
 * @return void
 */
	public function testCleanup() {
	}

}
