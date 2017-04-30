<?php

/**
 * Created by PhpStorm.
 * User: blmeena
 * Date: 27/04/17
 * Time: 11:45 PM
 */
/** Configuration Variables **/
date_default_timezone_set('UTC');
define ('DEVELOPMENT_ENVIRONMENT',true);
define ('SECURITYSALT','qJB0rGtIn5UB1xG03efyCp');
define('DB_NAME', 'wingify_product_app');
define('DB_USER', 'root');
define('DB_PASSWORD', 'admin');
define('DB_HOST', 'localhost');

define('BASE_PATH','http://localhost/wingify_app');


define('PAGINATE_LIMIT', '50');