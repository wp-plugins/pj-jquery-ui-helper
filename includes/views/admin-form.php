<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
     <form name="f" method="post" action="post.php">
     
     <table width="100%" border="0">
       <tr>
         <td width="45%"><h1>Login Widget AFO Settings</h1></td>
       <td width="55%">&nbsp;</td>
       </tr>
       <tr>
         <td><strong>Login Redirect Page:</strong></td>
       <td><?php
           $args = array(
           'depth'            => 0,
           'selected'         => $redirect_page,
           'echo'             => 1,
           'show_option_none' => '-',
           'id' 			   => 'redirect_page',
           'name'             => 'redirect_page'
           );
           wp_dropdown_pages( $args ); 
         ?></td>
       </tr>

        <tr>
         <td><strong>Logout Redirect Page:</strong></td>
        <td><?php
           $args1 = array(
           'depth'            => 0,
           'selected'         => $logout_redirect_page,
           'echo'             => 1,
           'show_option_none' => '-',
           'id' 			   => 'logout_redirect_page',
           'name'             => 'logout_redirect_page'
           );
           wp_dropdown_pages( $args1 ); 
         ?></td>
       </tr>

       <tr>
         <td><strong>Link in Username:</strong></td>
       <td><?php
           $args2 = array(
           'depth'            => 0,
           'selected'         => $link_in_username,
           'echo'             => 1,
           'show_option_none' => '-',
           'id' 			   => 'link_in_username',
           'name'             => 'link_in_username'
           );
           wp_dropdown_pages( $args2 ); 
         ?></td>
       </tr>

       <tr>
         <td>&nbsp;</td>
         <td><input type="submit" name="submit" value="Save" class="button button-primary button-large" /></td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td colspan="2">Use <span style="color:#000066;">[login_widget]</span> shortcode to display login form in post or page.<br />
        Example: <span style="color:#000066;">[login_widget title="Login Here"]</span></td>
       </tr>
     </table>
     </form>
