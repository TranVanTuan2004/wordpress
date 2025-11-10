<?php
require_once('wp-load.php');
global $wpdb;
$tables = $wpdb->get_results('SHOW TABLES');
foreach ($tables as $table) {
    foreach ($table as $t) {
        echo $t . "\n";
    }
}
?>
