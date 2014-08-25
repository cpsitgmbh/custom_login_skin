<?php
namespace CPSIT\CustomLoginSkin\Extensionmanager\Configuration;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Nicole Cordes <cordes@cps-it.de>, CPS-IT GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Render a textarea for extension manager configuration view
 */
class Textarea {

	/**
	 * @param array $params
	 * @param \t3lib_tsparser_ext $parentObject
	 * @return string
	 */
	public function render($params, $parentObject) {
		$fieldName = htmlspecialchars($params['fieldName']);
		return '<textarea cols="100" id="' . $fieldName . '" name="' . $fieldName . '" rows="5">' . $params['fieldValue'] . '</textarea>';
	}
}

?>