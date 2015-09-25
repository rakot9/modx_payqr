<?php

if ($object->xpdo) {
    /** @var modX $modx */
    $modx =& $object->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $packages = array(
				'pdoTools' => array(
					'version_major' => 1,
					'version_minor:>=' =>  8,
				)
			);
            
            
            
            $modelPath = $modx->getOption('payqr_core_path', null, $modx->getOption('core_path') . 'components/payqr/') . 'model/';
            $modx->addPackage('payqr', $modelPath);

            $manager = $modx->getManager();
            $objects = array();
            $schemaFile = MODX_CORE_PATH . 'components/payqr/model/schema/payqr.mysql.schema.xml';
            if (is_file($schemaFile)) {
                $schema = new SimpleXMLElement($schemaFile, 0, true);
                if (isset($schema->object)) {
                    foreach ($schema->object as $object) {
                        $objects[] = (string)$object['class'];
                    }
                }
                unset($schema);
            }
            foreach ($objects as $tmp) {
                // Operate with tables
                $manager->createObjectContainer($tmp);

                $tableFields = array();
                $c = $modx->prepare("SHOW COLUMNS IN {$modx->getTableName($tmp)}");
                $c->execute();
                while ($cl = $c->fetch(PDO::FETCH_ASSOC)) {
                    $tableFields[] = $cl['Field'];
                }

                foreach ($modx->getFields($tmp) as $field => $v) {
                    if (in_array($field, $tableFields)) {
                        unset($tableFields[$field]);
                        $manager->alterField($tmp, $field);
                    } else {
                        $manager->addField($tmp, $field);
                    }
                }
//                foreach ($tableFields as $field) {
//                    $manager->removeField($tmp, $field);
//                }
                // Operate with indexes
                if ($options[xPDOTransport::PACKAGE_ACTION] == xPDOTransport::ACTION_INSTALL) {
                    foreach ($modx->getIndexMeta($tmp) as $name => $meta) {
                        $manager->addIndex($tmp, $name);
                    }
                } else {
                    $indexes = array();
                    $c = $modx->prepare("SHOW INDEX FROM {$modx->getTableName($tmp)}");
                    $c->execute();
                    while ($cl = $c->fetch(PDO::FETCH_ASSOC)) {
                        $indexes[] = $cl['Key_name'];
                    }
                    foreach ($modx->getIndexMeta($tmp) as $name => $meta) {
                        if (in_array($name, $indexes)) {
                            unset($indexes[$name]);
                        } else {
                            $manager->addIndex($tmp, $name);
                        }
                    }
                    foreach ($indexes as $index) {
                        $manager->removeIndex($tmp, $index);
                    }
                }
                
                $payqrDataFile = MODX_CORE_PATH . 'components/payqr/model/schema/payqr.data.schema.xml';
                
                if (is_file($payqrDataFile)) {
                    $schema = new SimpleXMLElement($payqrDataFile, 0, true);
                    if (isset($schema->object)) {
                        foreach ($schema->object as $object) {
                            $objects[] = $object;
                        }
                    }
                    unset($schema);
                }

                //обходим object  в xml
                foreach($objects as $payqr_params)
                {
                    $insert_data = array();
                    
                    foreach($payqr_params->field as $field_row)
                    {
                        $insert_data[(string)$field_row['name']] = (string)$field_row['value'];
                    }
                    
                    if(empty($insert_data))
                    {
                        continue;
                    }
                    
                    $payqr_settings = $modx->newObject('payqrItem');
                    
                    $payqr_settings->fromArray($insert_data);
                    
                    $saved = $payqr_settings->save();
                }
            }
            break;

        case xPDOTransport::ACTION_UNINSTALL:
            // Remove tables if it's need
            /*
            $modelPath = $modx->getOption('payqr_core_path', null, $modx->getOption('core_path') . 'components/payqr/') . 'model/';
            $modx->addPackage('payqr', $modelPath);

            $manager = $modx->getManager();
            $objects = array();
            $schemaFile = MODX_CORE_PATH . 'components/payqr/model/schema/payqr.mysql.schema.xml';
            if (is_file($schemaFile)) {
                $schema = new SimpleXMLElement($schemaFile, 0, true);
                if (isset($schema->object)) {
                    foreach ($schema->object as $object) {
                        $objects[] = (string)$object['class'];
                    }
                }
                unset($schema);
            } else {
                $modx->log(modX::LOG_LEVEL_ERROR, 'Could not get classes from schema file.');
            }
            foreach ($objects as $tmp) {
                $manager->removeObjectContainer($tmp);
            }
            */
            break;
    }
}
return true;
