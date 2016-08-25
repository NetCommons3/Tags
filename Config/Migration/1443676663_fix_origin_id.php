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
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'comment' => 'block id |  ブロックID | blocks.id | '),
					'model' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'origin_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false, 'comment' => 'tag key | タグKey |  | '),
					'language_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
					'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'tag name | タグ名 |  | ', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'created user | 作成者 | users.id | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'modified user | 更新者 | users.id | '),
				),
				'tags_contents' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
					'model' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => false),
					'tag_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => false),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'created user | 作成者 | users.id | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'modified user | 更新者 | users.id | '),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'tags' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'block id |  ブロックID | blocks.id | '),
					'model' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'origin_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'tag key | タグKey |  | '),
					'language_id' => array('type' => 'integer', 'null' => true, 'default' => null),
					'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'comment' => 'tag name | タグ名 |  | ', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'created user | 作成者 | users.id | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'modified user | 更新者 | users.id | '),
				),
				'tags_contents' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
					'model' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11),
					'tag_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'created user | 作成者 | users.id | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'modified user | 更新者 | users.id | '),
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
