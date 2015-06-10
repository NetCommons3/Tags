<?php
/**
 * TagsController Test Case
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('TagsController', 'Tags.Controller');

App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');
App::uses('YAControllerTestCase', 'NetCommons.TestSuite');
App::uses('RolesControllerTest', 'Roles.Test/Case/Controller');
App::uses('AuthGeneralControllerTest', 'AuthGeneral.Test/Case/Controller');

App::uses('YAControllerTestCase', 'NetCommons.TestSuite');


/**
 * Summary for TagsController Test Case
 */
class TagsControllerTest extends YAControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.tags.tag',
		'plugin.net_commons.site_setting',
		'plugin.blocks.block',
		'plugin.blocks.block_role_permission',
		'plugin.boxes.box',
		'plugin.comments.comment',
		'plugin.frames.frame', // [frameId=1, blockId=5]
		'plugin.boxes.boxes_page',
		'plugin.containers.container',
		'plugin.containers.containers_page',
		'plugin.m17n.language',
		'plugin.m17n.languages_page',
		'plugin.pages.page',
		'plugin.pages.space',
		'plugin.roles.default_role_permission',
		'plugin.rooms.roles_rooms_user',
		'plugin.rooms.roles_room',
		'plugin.rooms.room',
		'plugin.rooms.room_role_permission',
		'plugin.rooms.plugins_room',
		'plugin.users.user',
		'plugin.users.user_attributes_user',
		'plugin.tags.plugin',
		//'plugin.categories.category',
		//'plugin.categories.category_order',
		//'plugin.likes.like',
		//'plugin.content_comments.content_comment',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		YACakeTestCase::loadTestPlugin($this, 'NetCommons', 'TestPlugin');
		Configure::write('Config.language', 'ja');
	}

/**
 * testSearch method
 *
 * @return void
 */
	public function testSearch() {
		$frameId = 1;
		$keyword = 'タグ';
		$modelName = 'BlogEntry';
		$this->testAction('/tags/tags/search/' . $frameId . '/keyword:' . $keyword . '/target:' . $modelName);

		$this->assertInternalType('array', $this->vars['results']);
	}

/**
 * keyword未指定のとき
 *
 * @return void
 */
	public function testEmptyKeyword() {
		$frameId = 1;
		$keyword = '';
		$modelName = 'BlogEntry';
		$this->testAction('/tags/tags/search/' . $frameId . '/keyword:' . $keyword . '/target:' . $modelName);

		$this->assertFalse(isset($this->vars['results']));
	}
}
