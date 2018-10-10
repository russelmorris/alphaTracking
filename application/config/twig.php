<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 11/10/2018
 * Time: 1:51 AM
 */

$config['twig']['template_dir'] = TWIG_PATH;
$config['twig']['template_ext'] = 'php';
$config['twig']['environment']['autoescape'] = TRUE;
$config['twig']['environment']['cache'] = FALSE;
$config['twig']['environment']['debug'] = FALSE;