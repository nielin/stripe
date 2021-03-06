<?php
/**
 * Stripe app model
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2011, Jeremy Harris
 * @link http://42pixels.com
 * @package stripe
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppModel', 'Model');

/**
 * StripeAppModel
 *
 * @package stripe
*/
class StripeAppModel extends AppModel {

/**
 * The datasource
 *
 * @var string
 */
	public $useDbConfig = 'stripe';

/**
 * No table here
 *
 * @var mixed
 */
	public $useTable = false;

/**
 * Returns the last error from Stripe
 *
 * @return string Error
 */
	public function getStripeError() {
		$ds = ConnectionManager::getDataSource($this->useDbConfig);
		return $ds->lastError;
	}

/**
 * beforeValidate
 *
 * @param array $options
 * @return boolean True if the operation should continue, false if it should abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforesave
 */
	public function beforeValidate($options = array()) {
		// create unique ID
		if(empty($this->data[$this->alias]['id'])) {
			$this->data[$this->alias]['id'] = Inflector::slug($this->data[$this->alias]['name'], "-") . String::uuid();
		}
		
		// currency should be lowercase
		if(isset($this->data[$this->alias]['currency'])) {
			$this->data[$this->alias]['currency'] = strtolower($this->data[$this->alias]['currency']);
		}
		return true;
	}
}