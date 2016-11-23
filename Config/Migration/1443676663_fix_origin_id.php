<?php
/**
 * FixOriginId
 */

/**
 * Class FixOriginId
 */
class FixOriginId extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'fix_origin_id';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'tags' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'comment' => 'ブロックID'),
					'model' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'origin_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false, 'comment' => 'tag key | タグKey |  | '),
					'language_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
					'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'タグ名', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => '更新者'),
				),
				'tags_contents' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
					'model' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => false),
					'tag_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => false),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => '更新者'),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'tags' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID'),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'ブロックID'),
					'model' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'origin_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'tag key | タグKey |  | '),
					'language_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'comment' => 'タグ名', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '更新者'),
				),
				'tags_contents' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'model' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11),
					'tag_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '作成者'),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '更新者'),
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
