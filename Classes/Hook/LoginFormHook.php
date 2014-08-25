<?php
namespace CPSIT\CustomLoginSkin\Hook;

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
 * Registers login template for the current domain
 */
class LoginFormHook {

	/**
	 * @var string
	 */
	protected $currentDomain = '';

	/**
	 * @var array
	 */
	protected $extensionConfiguration = array();

	/**
	 * @return void
	 */
	public function process() {
		$this->extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['custom_login_skin']);
		$this->currentDomain = \t3lib_div::getIndpEnv('HTTP_HOST');
		$this->includeTemplate();
		$this->includeStylesheet();

		return NULL;
	}

	/**
	 * @return void
	 */
	protected function includeTemplate() {
		$templateArray = \t3lib_div::trimExplode(LF, $this->extensionConfiguration['templates'], TRUE);
		if (empty($templateArray)) {
			return;
		}

		$templateToUse = '';
		foreach ($templateArray as $template) {
			if (strpos($template, '=') === FALSE && empty($templateToUse)) {
				$templateToUse = $template;
			} else {
				list($domain, $template) = explode('=', $template);
				if ($domain === $this->currentDomain) {
					$templateToUse = $template;
					break;
				}
			}
		}
		unset($template);

		$GLOBALS['TBE_TEMPLATE']->moduleTemplate = $this->getDocumentTemplate()->getHtmlTemplate($templateToUse);
	}

	/**
	 * @return void
	 */
	protected function includeStylesheet() {
		$stylesheetArray = \t3lib_div::trimExplode(LF, $this->extensionConfiguration['stylesheets'], TRUE);
		if (empty($stylesheetArray)) {
			return;
		}

		foreach ($stylesheetArray as $stylesheet) {
			if (strpos($stylesheet, '=') === FALSE) {
				$this->addCssFile($stylesheet);
			} else {
				list($domain, $stylesheet) = explode('=', $stylesheet);
				if ($domain === $this->currentDomain) {
					$this->addCssFile($stylesheet);
				}
			}
		}
		unset($stylesheet);
	}

	/**
	 * @param string $cssFile
	 * @return void
	 */
	protected function addCssFile($cssFile) {
		$cssFile = $this->getRelativeFilePath($cssFile, FALSE, TRUE);
		$this->getDocumentTemplate()->getPageRenderer()->addCssFile($cssFile);

		$directoryName = dirname($cssFile);
		if (!isset($GLOBALS['TBE_STYLES']['skins']['custom_login_skin'])) {
			$GLOBALS['TBE_STYLES']['skins']['custom_login_skin'] = array(
				'name' => 'custom_login_skin',
				'stylesheetDirectories' => array(
					$directoryName => $directoryName,
				)
			);
		} else {
			if (!in_array($directoryName, $GLOBALS['TBE_STYLES']['skins']['custom_login_skin']['stylesheetDirectories'])) {
				$GLOBALS['TBE_STYLES']['skins']['custom_login_skin']['stylesheetDirectories'][$directoryName] = $directoryName;
			}
		}
	}

	/**
	 * @param string $filePath
	 * @return string
	 */
	protected function getRelativeFilePath($filePath) {
		if (substr($filePath, 0, 4) === 'EXT:') {
			list($extensionKey, $file) = explode('/', substr($filePath, 4), 2);
			if (!empty($extensionKey) && \t3lib_extMgm::isLoaded($extensionKey) && !empty($file)) {
				$filePath = \t3lib_extMgm::extRelPath($extensionKey) . $file;
			}
		}

		return $filePath;
	}

	/**
	 * @return \template
	 */
	protected function getDocumentTemplate() {
		return $GLOBALS['TBE_TEMPLATE'];
	}

}

?>