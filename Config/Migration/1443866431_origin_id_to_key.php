<?php
class OriginIdToKey extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'origin_id_to_key';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'tags' => array(
					'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'model'),
				),
			),
			'drop_field' => array(
				'tags' => array('origin_id'),
			),
		),
		'down' => array(
			'drop_field' => array(
				'tags' => array('key'),
			),
			'create_field' => array(
				'tags' => array(
					'origin_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false, 'comment' => 'tag key | タグKey |  | '),
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
