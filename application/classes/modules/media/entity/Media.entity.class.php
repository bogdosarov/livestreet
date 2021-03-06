<?php
/**
 * LiveStreet CMS
 * Copyright © 2013 OOO "ЛС-СОФТ"
 *
 * ------------------------------------------------------
 *
 * Official site: www.livestreetcms.com
 * Contact e-mail: office@livestreetcms.com
 *
 * GNU General Public License, version 2:
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * ------------------------------------------------------
 *
 * @link http://www.livestreetcms.com
 * @copyright 2013 OOO "ЛС-СОФТ"
 * @author Maxim Mzhelskiy <rus.engine@gmail.com>
 *
 */

class ModuleMedia_EntityMedia extends EntityORM {

	protected $aValidateRules=array(

	);

	protected $aRelations=array(
		'targets' => array(self::RELATION_TYPE_HAS_MANY,'ModuleMedia_EntityTarget','media_id'),
	);

	protected function beforeSave() {
		if ($this->_isNew()) {
			$this->setDateAdd(date("Y-m-d H:i:s"));
		}
		return true;
	}

	public function getFileWebPath($sWidth = null) {
		if ($this->getFilePath()) {
			if ($sWidth) {
				$aPathInfo=pathinfo($this->getFilePath());
				return $aPathInfo['dirname'].'/'.$aPathInfo['filename'].'_'.$sWidth.'.'.$aPathInfo['extension'];
			} else {
				return $this->getFilePath();
			}
		} else {
			return null;
		}
	}

	public function getData() {
		$aData=@unserialize($this->_getDataOne('data'));
		if (!$aData) {
			$aData=array();
		}
		return $aData;
	}

	public function setData($aRules) {
		$this->_aData['data']=@serialize($aRules);
	}

	public function getDataOne($sKey) {
		$aData=$this->getData();
		if (isset($aData[$sKey])) {
			return $aData[$sKey];
		}
		return null;
	}

	public function setDataOne($sKey,$mValue) {
		$aData=$this->getData();
		$aData[$sKey]=$mValue;
		$this->setData($aData);
	}
}