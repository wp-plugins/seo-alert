<?php

/* 

 */

namespace VanillaBeans\SEOAlert;

    if(!function_exists('\VanillaBeans\SEOAlert\Visit')){
    function Visit(){
        \VanillaBeans\SEOAlert\Visitor();
    }
        
}

if(!function_exists('\VanillaBeans\SEOAlert\Vareplace')){
    function Vareplace($in, $thisbot){
        $out = str_replace('{bot}', $thisbot, $in);
        $out = str_replace('{uri}', $_SERVER['REQUEST_URI'], $out);
        $out = str_replace('{uas}', $_SERVER['HTTP_USER_AGENT'], $out);
        $out = str_replace('{blogname}', get_option('blogname'), $out);
        return $out;
    }
}


if(!function_exists('\VanillaBeans\SEOAlert\vbean_botMail')){
    
    function vbean_botMail($subject, $string){
        try{
        $chunk = get_option('vbean_seoalert_recipients');
        $recips = explode (",", $chunk);
        $headers = "MIME-Version: 1.0\n" ."From: " . get_option('admin_email') . "\n"."Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\n";
        wp_mail( $recips, $subject, $string );
    } catch (Exception $ex) {
            return;
        }
    }        
}

add_action( 'wp_loaded', '\VanillaBeans\SEOAlert\Visit' );

if(!function_exists('\VanillaBeans\SEOAlert\testalerts')){
    
    function testalerts(){
        \VanillaBeans\SEOAlert\Visitor(true,true);
    }        
}




if(!function_exists('\VanillaBeans\SEOAlert\Visitor')){
    function Visitor($display=false,$senddemomail=false){
        $botcount = intval(get_option('vbean_seoalert_botcount'));
        $seobotcount = intval(get_option('vbean_seoalert_seobotcount'));
        $yahoobotcount = intval(get_option('vbean_seoalert_yahoobotcount'));
        $bingbotcount = intval(get_option('vbean_seoalert_bingbotcount'));
        $visitor = 'none';
        $seo=false;
        $bing = false;
        $yahoo = false;
        $ua = $_SERVER['HTTP_USER_AGENT'].'';
        $req = $_SERVER['REQUEST_URI'].'';
        $seobots = array('SEObot','SEObot-News','SEObot-Image','SEObot-Video','SEObot-Mobile','Mediapartners-SEO','Mediapartners
(SEObot)','AdsBot-SEO');
        $bingbots=array('Bingbot','MSNBot','MSNBot-Media','AdIdxBot','BingPreview');
        $yahoobots=array('Yahoo Slurp','Yahoo! Slurp');
        $otherbots=array();
        $ua = strtolower($ua);
        foreach ($seobots as $b){
            $c=  strtolower($b);
            if (strpos($ua,  $c) !== false) {
                    $visitor = $b;
                    $seo = true;
                    $seobotcount=$seobotcount+1;
                update_option( 'vbean_seoalert_seobotcount', $seobotcount );
            }
        }
        
        foreach ($yahoobots as $b){
            $c=  strtolower($b);
            if (strpos($ua,  $c) !== false) {
                $yahoo = true;
                $yahoobotcount = $yahoobotcount+1;
                update_option( 'vbean_seoalert_yahoobotcount', $yahoobotcount );
                    $visitor = $b;
            }
        }
        
        foreach ($bingbots as $b){
            $c=  strtolower($b);
            if (strpos($ua,  $c) !== false) {
                $bing = true;
                $bingbotcount=$bingbotcount+1;
                    $visitor = $b;
                update_option( 'vbean_seoalert_bingbotcount', $bingbotcount );
            }
        }
        
        
        if($visitor!='none'){
            $subject = get_option('vbean_seoalert_subject');
                $subj = \VanillaBeans\SEOAlert\Vareplace($subject, $visitor);
                $mssg = get_option('vbean_seoalert_message');
                $msg = \VanillaBeans\SEOAlert\Vareplace($mssg, $visitor);
                if($display){
                    echo($subj.'<br />&nbsp;<br />'.$msg);
                }
                if($senddemomail){
                    \VanillaBeans\SEOAlert\vbean_botMail($subj, $msg);
                }else{
                    if($seo && get_option('vbean_seoalert_seobot')){
                        // send seo email
                        \VanillaBeans\SEOAlert\vbean_botMail($subj, $msg);
                    }
                    if($yahoo && get_option('vbean_seoalert_yahoobot')){
                        \VanillaBeans\SEOAlert\vbean_botMail($subj, $msg);
                    }
                    if($bing && get_option('vbean_seoalert_bingbot')){
                        \VanillaBeans\SEOAlert\vbean_botMail($subj, $msg);
                    }
                }
            }else{
                if($display){
                    echo($subj.'<br />&nbsp;<br />'.$msg);
                }
                if($senddemomail){
                        \VanillaBeans\SEOAlert\vbean_botMail($subj, $msg);
                }
        }
        
        
    
        
        
        
    }
}

add_shortcode('testalert', '\VanillaBeans\SEOAlert\testalerts');
