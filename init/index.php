<?php

require dirname(__DIR__, 1) . '/vendor/autoload.php';

use Classes\Models\DatabaseConnector as DatabaseConnector;

require 'init_db.php';

$database = new DatabaseConnector();

require 'init_tables.php';
require 'init_triggers.php';
