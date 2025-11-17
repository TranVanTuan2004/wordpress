<?php
get_header();
$active_tab = 'login';
include locate_template('auth/auth-tabs.php', false, false);
get_footer();