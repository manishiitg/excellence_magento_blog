<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('customer_manager')};
CREATE TABLE {$this->getTable('customer_manager')} (
  `manager_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  PRIMARY KEY (`manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS {$this->getTable('grid_manager')};
CREATE TABLE {$this->getTable('grid_manager')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `manager_id` int(11) NOT NULL ,
  `customer_id` int(11) NOT NULL ,
  `position` int(11) NOT NULL default 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 