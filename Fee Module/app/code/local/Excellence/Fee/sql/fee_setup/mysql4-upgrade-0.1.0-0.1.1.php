<?php

$installer = $this;

$installer->startSetup();

$installer->run("

		ALTER TABLE  `".$this->getTable('sales/quote_address')."` ADD  `fee_amount` DECIMAL( 10, 2 ) NOT NULL;
		ALTER TABLE  `".$this->getTable('sales/quote_address')."` ADD  `base_fee_amount` DECIMAL( 10, 2 ) NOT NULL;

		");

$installer->endSetup();