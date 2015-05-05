<?php
App::uses('BlogsAppController', 'Blogs.Controller');

/**
 * BlogTags Controller
 *
 * @property BlogTag $BlogTag
 * @property PaginatorComponent $Paginator
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
class BlogTagsController extends BlogsAppController {

public $uses = array(
	'Blogs.BlogTag',
);

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function search() {
		$keyword = $this->getNamed('keyword', '');
		if (empty($keyword)) {
			return;
		}
		$conditions = array(
			'name LIKE' => '%' . $keyword . '%',
			'block_id' => $this->viewVars['blockId'],
		);
		$tags = $this->BlogTag->find('all', array('conditions' => $conditions));
		$results = array();
		foreach($tags as $tag){
			$results[] = $tag['BlogTag']['name'];
		}
		$this->set('results', $results);
	}


}
