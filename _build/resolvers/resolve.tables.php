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
            }
            
            unset($objects);
            
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

            //Вставляем предопределенные значения для полей: hook_handler_url, log_url
            $modx->query("UPDATE " . $modx->getOption('table_prefix') ."payqr_items SET htmlvalue = '" . "http://" .  $_SERVER['SERVER_NAME'] . "/rest/index.php?_rest=receiver" . "' WHERE name='hook_handler_url'");
            $modx->query("UPDATE " . $modx->getOption('table_prefix') ."payqr_items SET htmlvalue = '" . "http://" .  $_SERVER['SERVER_NAME'] . "/rest/payqr.log" . "' WHERE name='log_url'");

            //копируем директорию "rest" вместе с ее содержимым из места, куда устанавливается модуль:
            // @path: core/components/payqr/
            //
            if(is_dir(MODX_CORE_PATH . 'components/payqr/rest'))
            {
                $isset_rest_dir = false;
                //проверяем существует ли директория "цель"
                if(is_dir(MODX_BASE_PATH . '/rest'))
                {
                    $isset_rest_dir = true;
                }
                else
                {
                    if(mkdir(MODX_BASE_PATH . '/rest', 0755))
                    {
                        $isset_rest_dir = true;
                    }
                }

                if($isset_rest_dir)
                {
                    copy(MODX_CORE_PATH . 'components/payqr/rest/index.php', MODX_BASE_PATH . '/rest/index.php');
                }
            }

            //создаем таблицу для связки order_id и invoice
            /*$payqrDataFile = MODX_CORE_PATH . 'components/payqr/model/schema/orderinvoice.data.schema.xml';

            unset($objects);
            if (is_file($payqrDataFile)) {
                $schema = new SimpleXMLElement($payqrDataFile, 0, true);
                if (isset($schema->object)) {
                    foreach ($schema->object as $object) {
                        $objects[] = $object;
                    }
                }
                unset($schema);
            }
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

                $payqr_settings = $modx->newObject('orderInvoice');

                $payqr_settings->fromArray($insert_data);

                $saved = $payqr_settings->save();
            }*/

            //проверяем установлена ли платежная система в shopkeeper3_config
            $result = $modx->query("SELECT value, xtype FROM ". $modx->getOption('table_prefix') ."shopkeeper3_config WHERE setting = 'payments'");

            if (is_object($result)) 
            {
                $row = $result->fetch(PDO::FETCH_ASSOC);

                if(isset($row['xtype']) && $row['xtype'] == 'array')
                {
                    $payments = json_decode( $row['value'], true );
                }

                $is_Payqr = false;

                foreach($payments as $payment)
                {
                    if($payment['label'] == 'PayQR')
                    {
                        $is_Payqr = true;
                    }
                }

                if(!$is_Payqr)
                {
                    $payments[] = array('label' => 'PayQR', id => 101);
                    //Производим обновление
                    $modx->query("UPDATE " . $modx->getOption('table_prefix') ."shopkeeper3_config SET value = '" . json_encode($payments, JSON_UNESCAPED_UNICODE) . "' WHERE setting='payments'");
                }
            }
            break;

        case xPDOTransport::ACTION_UNINSTALL:
            //$modx->log(modX::LOG_LEVEL_ERROR, 'Could not get classes from schema file.');
            
            $removed = $modx->exec('DROP TABLE IF EXISTS '.$modx->getOption('table_prefix').'payqr_items');
            
            if ($removed === false && $modx->errorCode() !== '' && $modx->errorCode() !== PDO::ERR_NONE) {
                print 'Could not drop table! ERROR: ' . print_r($modx->pdo->errorInfo(),true); 
            } 
            
            //удаляем таблицу-связку 
            $removed = $modx->exec('DROP TABLE IF EXISTS '.$modx->getOption('table_prefix').'order_invoice');
            
            if ($removed === false && $modx->errorCode() !== '' && $modx->errorCode() !== PDO::ERR_NONE) {
                print 'Could not drop table! ERROR: ' . print_r($modx->pdo->errorInfo(),true); 
            } 
            
            $result = $modx->query("SELECT value, xtype FROM ". $modx->getOption('table_prefix') ."shopkeeper3_config WHERE setting = 'payments'");
                
            if (is_object($result))
            {
                $row = $result->fetch(PDO::FETCH_ASSOC);

                if(isset($row['xtype']) && $row['xtype'] == 'array')
                {
                    $payments = json_decode( $row['value'], true );
                }
                
                foreach($payments as $key_p => $payment)
                {
                    if($payment['label'] == 'PayQR')
                    {
                        unset($payments[$key_p]);
                    }
                }
                //Производим обновление
                $modx->query("UPDATE " . $modx->getOption('table_prefix') ."shopkeeper3_config SET value = '" . json_encode($payments, JSON_UNESCAPED_UNICODE) . "' WHERE setting='payments'");
            }
            
            //удаляем директорию /rest
            if(is_dir(MODX_BASE_PATH . 'rest'))
            {
                $dir = MODX_BASE_PATH . 'rest';
                $objects = scandir(MODX_BASE_PATH . 'rest');
                foreach ($objects as $object) 
                { 
                    if ($object != "." && $object != "..") 
                    { 
                        if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
                    } 
                } 
                reset($objects); 
                
                rmdir(MODX_BASE_PATH . 'rest');
            }
            
            return true;
    }
}
return true;
