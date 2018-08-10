<?php

/**
 * @package UASGEAICheck
**/

/*
Plugin Name: EAI Check
Plugin URI: https://uasg.tech/
Description: Check for Email Address Internationalization (EAI). Add the shortcode [eai_check] to the page you want it displayed.
Version: 1.0.0
Author: UASG
Author URI: https://uasg.tech/
License: GPLv2 or later
Text Domain: EAI-Check
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/


// Make sure we don't expose any info if plugin is called directly
defined( 'ABSPATH' ) or die( 'Hi!  I\'m just a plugin, not much I can do when called directly' );

function startsWith($haystack, $needle) {
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}


function uasg_eai_checker() { // Display EAI checker form
    ob_start(); ?>



    <div class="fusion-builder-row fusion-builder-row-inner fusion-row ">
        <form method="post" action="">
            <div class="fusion-layout-column fusion_builder_column fusion_builder_column_2_3  fusion-two-third fusion-column-first 2_3" style="margin-top: 0px;margin-bottom: 20px;width:66.66%;width:calc(66.66% - ( ( 4% ) * 0.6666 ) );margin-right:4%;">
                <div class="fusion-column-wrapper" style="padding: 0px 0px 0px 0px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                    <input id="email" name="user_input" placeholder="Enter Valid Email Address" autocomplete="off" type="text">
                </div>
            </div><!--/input field-->
            <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_3  fusion-one-third fusion-column-last 1_3" style="margin-top: 0px;margin-bottom: 20px;width:33.33%;width:calc(33.33% - ( ( 4% ) * 0.3333 ) );">
                <div class="fusion-column-wrapper" style="padding: 0px 0px 0px 0px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                    <div class="fusion-button-wrapper">
                        <style type="text/css" scoped="scoped">
                            .fusion-button.button-1 .fusion-button-text, .fusion-button.button-1 i {color:#ffffff;}.fusion-button.button-1 {border-width:0px;border-color:#ffffff;}.fusion-button.button-1 .fusion-button-icon-divider{border-color:#ffffff;}.fusion-button.button-1:hover .fusion-button-text, .fusion-button.button-1:hover i,.fusion-button.button-1:focus .fusion-button-text, .fusion-button.button-1:focus i,.fusion-button.button-1:active .fusion-button-text, .fusion-button.button-1:active{color:#ffffff;}.fusion-button.button-1:hover, .fusion-button.button-1:focus, .fusion-button.button-1:active{border-width:0px;border-color:#ffffff;}.fusion-button.button-1:hover .fusion-button-icon-divider, .fusion-button.button-1:hover .fusion-button-icon-divider, .fusion-button.button-1:active .fusion-button-icon-divider{border-color:#ffffff;}.fusion-button.button-1{width:100%;}
                        </style>
                        <input type="submit" name="submit" value="Check Address" class="fusion-button button-flat fusion-button-round button-large button-default button-1">
                    </div>
                </div>
            </div><!--/submit button-->
        </form>
        <?php if(isset($_POST['submit'])) { ?>
        <script>
        // Scrolls to the results section if the results section gets loaded
        jQuery(function(){
            jQuery('#LoadingImage').hide();
            jQuery('html, body').animate({
                scrollTop: jQuery('#results').offset().top -150
            }, 2000);
        });
        </script>
            <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_2  fusion-one-half fusion-column-first 1_2" style="margin-top: 0px;margin-bottom: 20px;width:50%;width:calc(50% - ( ( 4% ) * 0.5 ) );margin-right:4%;">
                <div class="fusion-column-wrapper" style="background-color:#fdfdfd;padding: 20px 20px 20px 20px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                    <div class="fusion-title title sep-underline sep-solid fusion-title-size-three fusion-border-below-title" style="border-bottom-color:#e0dede;margin-top:0px;margin-bottom:40px;">
                        <h3 id="results" class="title-heading-left">Results</h3>
                    </div>
                    <div class="fusion-text">
                        <?php
                            echo '<p>You entered: ', htmlspecialchars($_POST['user_input']), '</p>';
                            $email = $_POST['user_input'];
                            $parts = explode('@', $_POST['user_input']);
                            $home_path = get_home_path();
                            if (sizeof($parts) !== 2 || strlen($parts[1]) === 0) {
                                echo '<p style="color: #cf111d;">Please enter a valid email address.</p>';
                            } else {
                                exec('/usr/bin/python ' . $home_path . 'wp-content/plugins/uasg-eai-check/eaitest.py ' . $email, $reply);
                                $reply_str =  implode('', $reply);
                                echo "$reply_str\n";
                            }
                        ?>
                    </div>
                </div>
            </div><!--/results-->
            <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_2  fusion-one-half fusion-column-last 1_2" style="margin-top: 0px;margin-bottom: 20px;width:50%;width:calc(50% - ( ( 4% ) * 0.5 ) );">
                <div class="fusion-column-wrapper" style="background-color:#fdfdfd;padding: 20px 20px 20px 20px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                    <div class="fusion-title title sep-underline sep-solid fusion-title-size-three fusion-border-below-title" style="border-bottom-color:#e0dede;margin-top:0px;margin-bottom:40px;">
                        <h3 class="title-heading-left">Resources</h3>
                    </div>
                    <div class="fusion-text">
                        <p>View the <a href="https://uasg.tech/wp-content/uploads/2016/06/UASG005-160302-en-quickguide-digital.pdf">Universal Acceptance Quick Guide</a> or take a look at all documentation below.</p>
                        <ul>
                            <li><a style="color: #ff9e1b; text-decoration: underline;" href="/wp-content/uploads/2017/02/UASG014_20170206.pdf" target="_blank" title="Quick Guide to EAI">Quick Guide to EAI</a></li>
                            <li><a style="color: #ff9e1b; text-decoration: underline;" href="/wp-content/uploads/2018/06/UASG012.pdf" target="_blank" title="Detailed Guide to EAI">Detailed Guide to EAI</a></li>
                        </ul>
                    </div>
                </div>
            </div><!--/resources-->
        <?php } ?>
    </div><!--/fusion-builder-row-inner-->
    <?php return ob_get_clean();
}
add_shortcode( 'eai_check', 'uasg_eai_checker' );
