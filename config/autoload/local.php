<?php
/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 *
 * @NOTE: This file is ignored from Git by default with the .gitignore included
 * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
 * credentials from accidentally being committed into version control.
 */

return array(
    'service_manager'=>array(
        'factories'=>array(
            'Zend\Db\Adapter'=>'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
    'db'=>array(
        'username'=>'root',
        'password'=>'19109547',
        'driver'=>'Pdo_Mysql',
        'dsn'=>'mysql:dbname=ObservatorioSocial',
        'driver_options'=>array(
            PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"
        ),
    ),
);
