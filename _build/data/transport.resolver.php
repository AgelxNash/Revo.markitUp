<?php
/**
 * MarkitUp Document Editor for MODx Revolution
 *
 * @author Borisov Evgeniy <modx@agel-nash.ru>
 *
 * @package markitup
 */

/**
 * Resolver to set which_editor to MarkitUp
 * 
 * @package markitup
 * @subpackage build
 */
$success= true;
if ($pluginid= $object->get('id')) {

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_UPGRADE:
            // remove obsolete plugin properties and files
			$plugin = $object->xpdo->getObject('modPlugin', array('name' => PKG_NAME));
            if ($plugin) {
				$object->xpdo->log(xPDO::LOG_LEVEL_INFO,'Attempting to clear obsolete plugin properties.');
                $plugin->setProperties(array());
                $plugin->save();
                


                $oldAssets = array(MODX_ASSETS_PATH. 'components/markitup/', MODX_MANAGER_PATH. 'components/markitup/');
                foreach ($oldAssets as $path) {
                    if (is_dir($path)) {
                        $object->xpdo->log(xPDO::LOG_LEVEL_INFO, "Attempting to remove old assets directory ($path).");
                        rename($path, rtrim($path,'/')."_backup_".time().'/');
                        break;
                    }
                }
            }
	}
}

return $success;