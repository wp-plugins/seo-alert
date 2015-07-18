<?php

/* 
 * Copyright (C) 2014 Velvary Pty Ltd
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace VanillaBeans\SEOAlert;
            // If this file is called directly, abort.
            if ( ! defined( 'WPINC' ) ) {
                    die;
            }


function RegisterSettings(){
	register_setting( 'vbean-seoalert-settings', 'vbean_seoalert_recipients' );
	register_setting( 'vbean-seoalert-settings', 'vbean_seoalert_message' );
        register_setting( 'vbean-seoalert-settings', 'vbean_seoalert_subject' );
	register_setting( 'vbean-seoalert-settings', 'vbean_seoalert_googlebot' );
	register_setting( 'vbean-seoalert-settings', 'vbean_seoalert_yahoobot' );
	register_setting( 'vbean-seoalert-settings', 'vbean_seoalert_bingbot' );
	register_setting( 'vbean-seoalert-settings', 'vbean_seoalert_othersearch' );
	register_setting( 'vbean-seoalert-settings', 'vbean_seoalert_botcount' );
	register_setting( 'vbean-seoalert-settings', 'vbean_seoalert_googlebotcount' );
	register_setting( 'vbean-seoalert-settings', 'vbean_seoalert_yahoobotcount' );
	register_setting( 'vbean-seoalert-settings', 'vbean_seoalert_bingbotcount' );
	register_setting( 'vbean-seoalert-settings', 'vbean_seoalert_googlelastvisit' );
	register_setting( 'vbean-seoalert-settings', 'vbean_seoalert_yahoolastvisit' );
	register_setting( 'vbean-seoalert-settings', 'vbean_seoalert_binglastvisit' );
    
}

function SettingsPage(){
        $seobotcount = intval(get_option('vbean_seoalert_googlebotcount'));
        $yahoobotcount = intval(get_option('vbean_seoalert_yahoobotcount'));
        $bingbotcount = intval(get_option('vbean_seoalert_bingbotcount'));    
    
    ?>
<script language="javascript" type="text/javascript">
<?php
?>
</script>

<style>
    #vbexcludelist{
        position:relative;
        display:inline-table;
        width:100%;
        border: 1px groove;
        background-color: #f6c9cc;
        padding:5px;
    }
    .vbexcludelistitemcontainer{
        padding:5px;
        position:relative;
        display:inline-block;
        width:100%;
        margin-bottom:3px;
    }
    
    .vbexcludelistitempath{
        border-bottom:1px dashed;
        display:inline-block;
        width:70%;
    }
    
    .vbexcludelistitemline{
        border-bottom:1px dashed;
        display:inline-block;
        text-align:right;
        margin-right:7px;
        width:10%;
    }
    .vbexcludelistitemremove{
        text-align:right;
        display:inline-block;
        width:15%;
    }
    .vbcheading{
        display:inline-block;
        width:100%;
        font-weight: bold;
       background:#0000ff;
       color:white;
        padding:0;
        
    }
    .pixelplug{display:none;}
    .vbcheading div{
    } 
    .vbcheading div .vbexcludelistitempath{
        padding-left: 10px;
        margin:0;
    } 
    .vbcheading div .vbexcludelistitemline{
        margin:0;
    } 
    .vbcheading div .vbexcludelistitemremove{
        margin:0;
    } 
    .botvalue{
        font-weight: bold;
        margin-right:20px;
    }
    .botname{
        font-weight: bold;
    }
</style>

        <div class="wrap">
        <div>
            <h3>Visits:</h3>
            <span class="botname">SEO : </span><span class="botvalue"><?php echo($seobotcount)?></span>
            <span class="botname">Yahoo : </span><span class="botvalue"><?php echo($yahoobotcount)?></span>
            <span class="botname">Bing : </span><span class="botvalue"><?php echo($bingbotcount)?></span>
            
        </div>
        <h2>Vanilla Bean search engine visitor register settings</h2>
        <form method="post" action="options.php">

    <?php settings_fields( 'vbean-seoalert-settings' ); ?>
    <?php do_settings_sections( 'vbean-seoalert-settings' ); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Recipients</th>
                        <td><textarea cols="60" rows="3" name="vbean_seoalert_recipients" id="vbean_seoalert_recipients"><?php echo \VanillaBeans\vbean_setting('vbean_seoalert_recipients','you@yourdomain.com')?></textarea>
                            <div class="description">Comma separated list of email addresses that you would like error messages sent to.</div>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">Subject Line</th>
                        <td><input type="text" name="vbean_seoalert_subject" id="vbean_seoalert_subject" value="<?php echo \VanillaBeans\vbean_setting('vbean_seoalert_subject','{bot} visit')?>" style="width:600px;max-width:90%;">
                            <div class="description">The email subject line for your alerts. You can use these placeholders: <span style="color:darkslateblue">{bot}</span> - The bot that visited.  <span style="color:darkslateblue">{blogname}</span> - The Wordpress site name.  </div>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">Message</th>
                        <td><textarea cols="60" rows="5" name="vbean_seoalert_message" id="vbean_seoalert_message"><?php echo \VanillaBeans\vbean_setting('vbean_seoalert_message','{bot} came by and took a look at {uri} on {blogname}\n\n{uas}')?></textarea>
                            <div class="description">The email subject line for your alerts. You can use these placeholders:   <span style="color:darkslateblue">{bot}</span> - The bot that visited. <span style="color:darkslateblue">{blogname}</span> - The Wordpress site name.    <span style="color:darkslateblue">{uri}</span>  - The requested URI. <span style="color:darkslateblue">{uas}</span> - The full user agent string</div>
                        </td>
                    </tr>


                    <tr valign="top">
                        <th scope="row">Alerts for</th>
                        <td> <input type="checkbox" class="checkbox" name="vbean_seoalert_googlebot"  id="vbean_seoalert_googlebot" value="1" <?php echo checked(1, get_option('vbean_seoalert_googlebot'), false)   ?>/>&nbsp;Google,
                &nbsp;&nbsp;&nbsp;<input type="checkbox" class="checkbox" name="vbean_seoalert_yahoobot"  id="vbean_seoalert_yahoobot" value="1" <?php echo checked(1, get_option('vbean_seoalert_yahoobot'), false)   ?>/>&nbsp;Yahoo,
                &nbsp;&nbsp;&nbsp;<input type="checkbox" class="checkbox" name="vbean_seoalert_bingbot"  id="vbean_seoalert_bingbot" value="1" <?php echo checked(1, get_option('vbean_seoalert_bingbot'), false)   ?>/>&nbsp;Bing<!--,
                &nbsp;&nbsp;&nbsp;<input type="checkbox" class="checkbox" name="vbean_seoalert_othersearch"  id="vbean_seoalert_othersearch" value="1" <?php echo checked(1, get_option('vbean_seoalert_othersearch'), false)   ?>/>&nbsp;Other known search engines-->
                            <div class="description">Check the types of Web crawl visits you would like to be alerted about.</div>
                        </td>
                    </tr>

                </table>



                

            <?php submit_button(); ?>
            </form>
        </div>    
        <span class="pixelplug"><img src="https://stage.velvary.com.au/wpi/img/vanilla-bean-seo-alert.png" width="1" height="1"></span>
<?php
}



