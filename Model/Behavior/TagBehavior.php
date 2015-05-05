<?php
/**
 * Created by PhpStorm.
 * User: ryuji
 * Date: 15/04/23
 * Time: 18:53
 */
class TagBehavior extends ModelBehavior {

/**
 * @var array 設定
 */
	public $settings;

/**
 * @var Tag タグモデル
 */
	protected $_Tag = null;

/**
 * setup
 *
 * @param Model $Model モデル
 * @param array $settings 設定値
 * @return void
 */
	public function setup(Model $Model, $settings = array()) {
		$this->settings[$Model->alias] = $settings;
		if ($this->_Tag === null) {
			$this->_Tag = ClassRegistry::init('Tags.Tag');
		}
	}

/**
 * タグ保存処理
 *
 * @param Model $Model モデル
 * @param bool $created 新規作成
 * @param array $options options
 * @return void
 */
	public function afterSave(Model $Model, $created, $options = array()) {
		if ($created) {
			if (isset($Model->data['BlogTag'])) {
				$blockId = $Model->data[$Model->name]['block_id'];

				if (!$this->_Tag->saveTags($blockId, $Model->id, $Model->data['BlogTag'])) {
					return false;
				}
			}
		}
	}

	public function beforeFind(Model $Model, $query) {
		// ε(　　　　 v ﾟωﾟ)　＜ 汎用化
		$joinLinkTable = false;
		$joinsTagTable = false;

		$conditions = $query['conditions'];
		$columns = array_keys($conditions);
		// タグ条件あったらタグテーブルとリンクテーブルをJOIN
		if (preg_grep('/^BlogTag\./', $columns)) {
			$joinLinkTable = true;
			$joinsTagTable = true;
		}
		// リンク条件だけならリンクテーブルだけをJOIN
		if (preg_grep('/^BlogEntryTagLink\./', $columns)) {
			$joinLinkTable = true;
		}

		if ($joinLinkTable) {
			$query['joins'][] =
				array(
					'type' => 'LEFT',
					'table' => 'blog_entry_tag_links',
					'alias' => 'BlogEntryTagLink',
					'conditions' => '`' . $Model->name . '`.`id`=`BlogEntryTagLink`.`blog_entry_id`',
				);
		}

		if ($joinsTagTable) {
			$query['joins'][] =
				array(
					'type' => 'LEFT',
					'table' => 'blog_tags',
					'alias' => 'BlogTag',
					'conditions' => '`BlogEntryTagLink`.`blog_tag_id`=`BlogTag`.`id`',
				);
		}

		return $query;
	}

/**
 * タグ情報をFind結果にまぜる
 *
 * @param Model $Model モデル
 * @param mixed $results Find結果
 * @param bool $primary primary
 * @return array $results
 */
	public function afterFind(Model $Model, $results, $primary = false) {
		foreach ($results as $key => $target) {
			if (isset($target[$Model->name]['id'])) {
				$tags = $this->_Tag->getTagsByEntryId($target[$Model->name]['id']);
				$target['BlogTag'] = $tags;
				$results[$key] = $target;
			}
		}

		return $results;
	}
}