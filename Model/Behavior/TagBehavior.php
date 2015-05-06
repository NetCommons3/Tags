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
			$blockId = $Model->data[$Model->name]['block_id'];

			if (isset($Model->data['Tag'])) {
				if (!$this->_Tag->saveTags($blockId, $Model->name, $Model->id, $Model->data['Tag'])) {
					return false;
				}
			}
			// cleanup
			$this->_cleanupTags($Model, $blockId);
		}
	}

/**
 * タグクリーンアップ
 *
 * @param Model $Model タグを使ってるモデル
 * @param int $blockId ブロックID
 * @return void
 */
	protected function _cleanupTags(Model $Model, $blockId) {
		// 使われてないタグを削除
		$this->_Tag->cleanup($Model, $blockId);
		/*
		 * 使われてないタグとは
		 * リンクテーブルTagsContentが存在しないタグ
		 * リンクされたコンテンツがis_activeでもis_latestでもない
		 */
	}

/**
 * 検索時にタグの検索条件があったらJOINする
 *
 * @param Model $Model タグ使用モデル
 * @param array $query find条件
 * @return array タグ検索条件を加えたfind条件
 */
	public function beforeFind(Model $Model, $query) {
		$joinLinkTable = false;
		$joinsTagTable = false;

		$conditions = $query['conditions'];
		$columns = array_keys($conditions);
		// タグ条件あったらタグテーブルとリンクテーブルをJOIN
		if (preg_grep('/^Tag\./', $columns)) {
			$joinLinkTable = true;
			$joinsTagTable = true;
		}
		// リンク条件だけならリンクテーブルだけをJOIN
		if (preg_grep('/^TagsContent\./', $columns)) {
			$joinLinkTable = true;
		}

		if ($joinLinkTable) {
			$query['joins'][] =
				array(
					'type' => 'LEFT',
					'table' => 'tags_contents',
					'alias' => 'TagsContent',
					'conditions' =>
						'`' . $Model->name . '`.`id`=`TagsContent`.`content_id` AND model = \'' . $Model->name . '\'',
				);
		}

		if ($joinsTagTable) {
			$query['joins'][] =
				array(
					'type' => 'LEFT',
					'table' => 'tags',
					'alias' => 'Tag',
					'conditions' => '`TagsContent`.`tag_id`=`Tag`.`id`',
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
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function afterFind(Model $Model, $results, $primary = false) {
		foreach ($results as $key => $target) {
			if (isset($target[$Model->name]['id'])) {

				$tags = $this->_Tag->getTagsByContentId($Model->name, $target[$Model->name]['id']);
				foreach ($tags as $tag) {
					$target['Tag'][] = $tag['Tag'];
				}
				$results[$key] = $target;
			}
		}

		return $results;
	}

/**
 * タグIDを元にタグデータを返す
 *
 * @param Model $Model タグ使用モデル
 * @param int $tagId タグID
 * @return array タグ配列
 */
	public function getTagByTagId($Model, $tagId) {
		$tag = $this->_Tag->findById($tagId);
		return $tag;
	}
}