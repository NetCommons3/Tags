<?php
/**
 * Tag Model
 *
 * @property Block $Block
 * @property Language $Language
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('TagsAppModel', 'Tags.Model');

/**
 * Summary for Tag Model
 */
class Tag extends TagsAppModel {

/**
 * @var int recursiveで余計なもんとってこんように -1
 */
	public $recursive = -1;

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'block_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'model' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'origin_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Block' => array(
			'className' => 'Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Language' => array(
			'className' => 'Language',
			'foreignKey' => 'language_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * コンテンツIDと関連づくタグを返す
 *
 * @param string $modelName モデル名
 * @param int $contentId コンテンツID
 * @return array タグ
 */
	public function getTagsByContentId($modelName, $contentId) {
		$conditions = array(
			'TagsContent.model' => $modelName,
			'TagsContent.content_id' => $contentId,
		);
		$options = array(
			'conditions' => $conditions,
		);
		$options['joins'] = array(
			array('table' => 'tags_contents',
				'alias' => 'TagsContent',
				'type' => 'LEFT',
				'conditions' => array(
					'Tag.id = TagsContent.tag_id',
				)
			)
		);
		$tags = $this->find('all', $options);
		return $tags;
	}

/**
 * タグの保存
 *
 * @param int $blockId ブロックID
 * @param string $modelName タグ使用モデルのモデル名
 * @param int $contentId 保存するタグと関連づくコンテンツのID
 * @param array $tags 保存するタグ
 * @return bool
 */
	public function saveTags($blockId, $modelName, $contentId, $tags) {
		$this->setDataSource('master');

		$TagsContent = ClassRegistry::init('Tags.TagsContent');
		$TagsContent->setDataSource('master');

		if (!is_array($tags)) {
			$tags = array();
		}
		// 存在しないタグを保存
		// タグへのリンクを保存
		$tagNameList = array();
		foreach ($tags as $tag) {
			if (isset($tag['name'])) {
				$tagNameList[] = $tag['name'];
			}
		}
		foreach ($tagNameList as $tagName) {
			//
			$savedTag = $this->findByBlockIdAndName($blockId, $tagName);
			if (!$savedTag) {
				// $tagがないなら保存
				$data = $this->create();

				$data['Tag']['name'] = $tagName;
				$data['Tag']['block_id'] = $blockId;
				$data['Tag']['model'] = $modelName;
				if ($this->save($data)) {
					$savedTag = $this->findById($this->id);
				} else {
					return false;
				}
			}
			// save link
			$link = $TagsContent->create();
			$link['TagsContent']['content_id'] = $contentId;
			$link['TagsContent']['model'] = $modelName;
			$link['TagsContent']['tag_id'] = $savedTag['Tag']['id'];

			if (!$TagsContent->save($link)) {
				return false;
			}
		}
		return true;
	}

/**
 * origin_idがセットされてなかったらorigin_id=idとしてアップデート
 *
 * @param bool $created created
 * @param array $options options
 * @return void
 */
	public function afterSave($created, $options = array()) {
		if ($created) {
			if (empty($this->data[$this->name]['origin_id'])) {
				// origin_id がセットされてなかったらkey=idでupdate
				$this->originId = $this->data[$this->name]['id'];
				$this->saveField('origin_id', $this->data[$this->name]['id'], array('callbacks' => false)); // ここで$this->dataがリセットされる
			}
		}
	}

/**
 * 使われてないタグの自動削除
 *
 * @param Model $Model タグ使用モデル
 * @param int $blockId ブロックID
 * @return void
 */
	public function cleanup(Model $Model, $blockId) {
		$this->setDataSource('master');
		// 下記SQLを分解再構築した is_latest or is_activeなコンテンツとつなっがてないタグidを列挙するクエリ
		//select tags.id from tags
		//LEFT JOIN tags_contents ON tags.id = tags_contents.tag_id
		//LEFT JOIN blog_entries ON tags_contents.model = 'BlogEntry' AND tags_contents.`content_id` = blog_entries.id
		//AND (blog_entries.is_latest = 1 OR blog_entries.is_active = 1)
		//
		//WHERE tags.model = 'BlogEntry' AND tags.block_id = 5
		//group by tags.id
		//having count(blog_entries.id) = 0;

		$conditions = array(
			'Tag.model' => $Model->name,
			'Tag.block_id' => $blockId,
		);
		//$options = array(
		//	'conditions' => $conditions,
		//);
		$options = array();
		$options['conditions'] = $conditions;
		$options['joins'] = array(
			array(
				'table' => 'tags_contents',
				'alias' => 'TagsContent',
				'type' => 'LEFT',
				'conditions' => array(
					'Tag.id = TagsContent.tag_id',
				),
			),
			array(
				'table' => $Model->useTable,
				'alias' => $Model->name,
				'type' => 'LEFT',
				'conditions' => array(
					'TagsContent.content_id = ' . $Model->name . '.id',
					'( ' . $Model->name . '.is_latest = 1 OR ' . $Model->name . '.is_active =1 )',
				),
			),

		);
		$options['group'] = array(
			//'Tag.id having',
			sprintf('Tag.id having count(%s.id) = 0', $Model->name),
		);
		$options['fields'] = array(
			'Tag.id',
			//'Tag.content_count',
		);

		//$this->virtualFields['content_count'] = sprintf('count(%s.id)', $Model->name);
		//$options['recursive'] = -1;
		$tags = $this->find('all', $options);
		//unset($this->virtualFields['content_count']);
		$deleteTargetIds = array();
		foreach ($tags as $tag) {
			$deleteTargetIds[] = $tag['Tag']['id'];
		}
		$this->deleteAll(array('Tag.id' => $deleteTargetIds), false);
	}
}
