<?php
/**
 * TagsController
 */
App::uses('TagsAppController', 'Tags.Controller');

/**
 * Tags Controller
 *
 * @property Tag $Tag
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
class TagsController extends TagsAppController {

/**
 * @var array use Models
 */
	public $uses = array(
		'Tags.Tag',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		//'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsFrame',
		//'Security',
	);

/**
 * タグ補完用検索
 *
 * @return void
 */
	public function search() {
		$keyword = $this->_getNamed('keyword', '');
		$modelName = $this->_getNamed('target', '');
		if (empty($keyword) || empty($modelName)) {
			return;
		}
		$blockId = Current::read('Block.id');
		$conditions = array(
			'name LIKE' => '%' . $keyword . '%',
			'block_id' => $blockId,
			'model' => $modelName,
		);
		$tags = $this->Tag->find('all', array('conditions' => $conditions));
		$results = array();
		foreach ($tags as $tag) {
			$results[] = $tag['Tag']['name'];
		}
		$this->set('results', $results);
	}
}
