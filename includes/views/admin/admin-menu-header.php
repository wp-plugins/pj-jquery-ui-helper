<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo '<div class="wrap">'; //Open wrapping div for admin menu
echo '<h2>' . get_admin_page_title() . '</h2>';//print out the title of the admin page in use
echo '<form method="post" action="options.php">';//open the form to be used