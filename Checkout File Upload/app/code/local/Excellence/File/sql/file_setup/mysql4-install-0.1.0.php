<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('quote_file')};
CREATE TABLE {$this->getTable('quote_file')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `quote_id` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `type`  varchar(255) NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS {$this->getTable('order_file')};
CREATE TABLE {$this->getTable('order_file')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `order_id` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `type`  varchar(255) NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


    ");

$installer->endSetup(); 