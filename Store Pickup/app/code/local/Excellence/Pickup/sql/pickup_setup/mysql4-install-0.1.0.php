<?php

$installer = $this;

$installer->startSetup();

$installer->run("
	CREATE TABLE IF NOT EXISTS {$this->getTable('order_shipping_pickup')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `order_id` int(11) NOT NULL,
	  `store` varchar(255) NOT NULL default '',
	  `name` varchar(255) NOT NULL default '',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup(); 