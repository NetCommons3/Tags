<?php

App::uses('AppController', 'Controller');

class TagsAppController extends AppController {

/**
 * デフォルト値 named
 *
 * @param string $name パラメータ名
 * @param null $default 指定されたパラメータがなかったときのデフォルト値
 * @return int|string
 */
	protected function _getNamed($name, $default = null) {
		$value = isset($this->request->params['named'][$name]) ? $this->request->params['named'][$name] : $default;
		return $value;
	}

}
