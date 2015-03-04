<?php
return array(
	    'doctrine' => array(
	        'connection' => array(
	            'orm_default' => array(
	                'params' => array(
	                    'host' => 'localhost',
	                    'port' => 3306,
	                    'user' => 'root',
	                    'password' => '19109547',
	                    'dbname' => 'observatoriosocial',
	                    'driverOptions' => array(
	                        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
	                    ),
	                )
	            )
	        )
	    )
	);