<?php

/**
 * Plugin Name: monPotager
 */

use monPotager\Plugin;
use monPotager\Api;


require __DIR__ . '/vendor-monpotager/autoload.php';

$monPotager = new Plugin();

register_activation_hook(
   __FILE__,
   [$monPotager, 'activate']
);


register_deactivation_hook(
   __FILE__,
   [$monPotager, 'deactivate']
);

$api = new Api();
