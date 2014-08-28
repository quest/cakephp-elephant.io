<?php
/**
 * Copyright 2014, Victor San Martin
 *
 * Licensed under MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author  Victor San Martin <hola[at]victorsanmartin[dot]com>
 * @since 1.0.0
 * @copyright  Copyright 2014
 * @license MIT Licence (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Component', 'Controller');

/**
 * ElephantIO component class
 *
 * @package ElephantIO.Controller.Component
 */
class ElephantIOComponent extends Component {

/**
 * ElephantIO\Client object
 * @var object
 */
	private $__elephantIO;

/**
 * SocketIO url:port
 * @var string
 */
	public $url = 'http://localhost:3000';

/**
 * Socket.IO versión
 * Possibles values: 1X, 0X
 * @var string
 */
	public $version = '1X';

/**
 * Socket.IO options
 * @var array
 */
	public $options = array();

/**
 * Initialize component
 *
 * @param Controller $controller Controller instance
 */
	public function initialize(Controller $controller) {

		$engine = null;
		if ($this->version == '1X') {
			$engine = new ElephantIO\Engine\SocketIO\Version1X($this->url, $this->options);
		}

		$this->__elephantIO = new ElephantIO\Client($engine);
	}

/**
 * init function. Compatibility CakePHP Component
 *
 * @return object ElephantIO\Client instance
 */
	public function init() {
		return $this->__elephantIO->initialize();
	}

/**
 * Magic __call function.
 * Call method from ElephantIO\Client
 *
 * @param string $method Method name
 * @param array $args Arguments
 * @return mixed Return of method
 */
	public function __call($method, $args) {
		return call_user_func_array(
			array($this->__elephantIO, $method),
			$args
		);
	}

/**
 * Close socket on destruct event
 *
 * @return void
 */
	public function __destruct() {
		if ($this->__elephantIO) {
			$this->__elephantIO->close();
		}
	}
}
