<?php
/**
 * TagFixture
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for TagFixture
 */
class FakeModelFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
		'origin_id' => array('type' => 'integer'),
		'block_id' => array('type' => 'integer'),
		'is_active' => array('type' => 'integer'),
		'is_latest' => array('type' => 'integer'),
		'name' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'origin_id' => 1,
			'block_id' => 1,
			'is_active' => 1,
			'is_latest' => 0,
			'name' => 'Lorem ipsum dolor sit amet',
		),
		array(
			'id' => 2,
			'origin_id' => 1,
			'block_id' => 1,
			'is_active' => 0,
			'is_latest' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
		),
	);

}
