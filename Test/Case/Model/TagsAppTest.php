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
 * テスト用Fake
 */
class FakeModel extends CakeTestModel {

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
 * Summary for Tag Test Case
 */
class TagsAppTest extends CakeTestCase {

/**
 * Trackableビヘイビアで必用な関連モデルが増えすぎるので除去する
 *
 * @param Model $Model Trackableを引きはがすモデル
 * @return void
 */
	protected function _unloadTrackable(Model $Model) {
		$Model->Behaviors->unload('NetCommons.Trackable');
		$Model->unbindModel(array('belongsTo' => array('TrackableCreator', 'TrackableUpdater')), false);
	}

/**
 * ダミーテスト
 *
 * @return void
 */
	public function testIndex() {
	}
}
