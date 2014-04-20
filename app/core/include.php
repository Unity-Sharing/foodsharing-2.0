<?php 

require_once '../app/core/config.php';
require_once DIR_COMMON . 'Benchmark.php';
Benchmark::init();

require_once DIR_COMMON . 'Db.php';
require_once DIR_COMMON . 'ModelInterface.php';
require_once DIR_COMMON . 'Model.php';
require_once DIR_COMMON . 'View.php';
require_once DIR_COMMON . 'CoreController.php';
require_once DIR_COMMON . 'Controller.php';

require_once DIR_COMMON . 'Session.php';

require_once '../lib/minify/JSMin.php';
require_once '../lib/minify/CssMin.php';
require_once DIR_CORE . 'functions.php';

require_once DIR_COMMON . 'Toolkit.php';
require_once DIR_CORE . 'autoload.php';

Benchmark::out('Include files');

require_once DIR_CORE . 'boot.php';

Benchmark::out('Booting');

require_once DIR_CORE . 'postboot.php';