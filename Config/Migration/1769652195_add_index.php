<?php
/**
 * インデックス追加のみ。
 *
 * @package Researchmap\RmNetCommons\Config\Migration
 */
class AddIndex1769652195 extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_index';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'tags' => array(
					'indexes' => array(
						'idx1_p_tags' => array('column' => array('model', 'block_id'), 'unique' => 0),
					),
				),
				'tags_contents' => array(
					'indexes' => array(
						'idx1_p_tags_contents' => array('column' => array('tag_id'), 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'tags' => array('indexes' => array('idx1_p_tags')),
				'tags_contents' => array('indexes' => array('idx1_p_tags_contents')),
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
