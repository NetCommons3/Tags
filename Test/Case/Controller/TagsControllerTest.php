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
		'plugin.tags.tags_content',
		//'plugin.frames.frame', // [frameId=1, blockId=5]
		//'plugin.tags.plugin',
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
		$this->generate(
			'Tags.Tags',
			[
				'components' => [
					'Auth' => ['user'],
					'Session',
					'Security',
				]
			]
		);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Configure::write('Config.language', null);
		CakeSession::write('Auth.User', null);
		parent::tearDown();
	}

/**
 * testSearch method
 *
 * @return void
 */
	public function testSearch() {
		RolesControllerTest::login($this);

		$frameId = 1;
		$keyword = 'タグ';
		$modelName = 'BlogEntry';
		$this->testAction(
			'/tags/tags/search/' . $frameId . '/keyword:' . $keyword . '/target:' . $modelName,
			array(
				'method' => 'get',
				//'return' => 'view',
			)
		);

		$this->assertInternalType('array', $this->vars['results']);

		AuthGeneralControllerTest::logout($this);
	}

/**
 * keyword未指定のとき
 *
 * @return void
 */
	public function testEmptyKeyword() {
		RolesControllerTest::login($this);

		$frameId = 1;
		$keyword = '';
		$modelName = 'BlogEntry';
		$this->testAction('/tags/tags/search/' . $frameId . '/keyword:' . $keyword . '/target:' . $modelName);

		//$this->assertFalse(isset($this->vars['results']));

		AuthGeneralControllerTest::logout($this);
	}
}
