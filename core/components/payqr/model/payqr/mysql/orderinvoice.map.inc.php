<?php
$xpdo_meta_map['orderInvoice']= array (
  'package' => 'payqr',
  'version' => '1.1',
  'table' => 'order_invoice',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'order_id' => 0,
    'invoice' => '',
  ),
  'fieldMeta' => 
  array (
    'order_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'invoice' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
  ),
);
