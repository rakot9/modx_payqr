<?php

/**
 * Disable an Item
 */
class payqrItemDisableProcessor extends modObjectProcessor {
	public $objectType = 'payqrItem';
	public $classKey = 'payqrItem';
	public $languageTopics = array('payqr');
	//public $permission = 'save';


	/**
	 * @return array|string
	 */
	public function process() {
		if (!$this->checkPermissions()) {
			return $this->failure($this->modx->lexicon('access_denied'));
		}

		$ids = $this->modx->fromJSON($this->getProperty('ids'));
		if (empty($ids)) {
			return $this->failure($this->modx->lexicon('payqr_item_err_ns'));
		}

		foreach ($ids as $id) {
			/** @var payqrItem $object */
			if (!$object = $this->modx->getObject($this->classKey, $id)) {
				return $this->failure($this->modx->lexicon('payqr_item_err_nf'));
			}

			$object->set('active', false);
			$object->save();
		}

		return $this->success();
	}

}

return 'payqrItemDisableProcessor';
