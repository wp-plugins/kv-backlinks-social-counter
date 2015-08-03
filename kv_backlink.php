<?php
/*
Plugin Name: KV Google BackLink Checker Dashbaord
Plugin URI: http://kvcodes.com
Description: A simple wordpress plugin to get your Wordpres CMS Backlink and page rank.  its light weight and simple.  <a href="http://www.kvcodes.com" target="_blank" > Read more </a> 
Version: 1.1
Author: kvvaradha
Author URI: http://profiles.wordpress.org/kvvaradha
*/


define('KV_BACKLINK_URL', plugin_dir_url( __FILE__ ));


if(!function_exists('kv_admin_menu')) {
	function kv_admin_menu() { 		
		add_menu_page('Kvcodes', 'Kvcodes', 'manage_options', 'kvcodes' , 'kv_codes_plugins', KV_BACKLINK_URL.'/images/kv_logo.png', 66);	
		add_submenu_page( 'kvcodes', 'KV Google Backlink  Checker', 'KV Google Backlink  Checker', 'manage_options', 'kv_backlink', 'kv_google_backlink_fn_widget' );
	}
add_action('admin_menu', 'kv_admin_menu');

function kv_backlink_lib() {
	require_once("lib/kv_social_class.php");
	require_once("lib/kv_google_pagerank.php");
}
add_action('admin_init', 'kv_backlink_lib');

function kv_codes_plugins() {

?>
 <div class="wrap">
    <div class="icon32" id="icon-tools"><br/></div>
    <h2><?php _e('KvCodes', 'kvcodes') ?></h2>		
	<div class="welcome-panel">
		Thank you for using Kvcodes Plugins . Here is my few Plugins work .MY plugins are very light weight and Simple.  <p>
		<a href="http://www.kvcodes.com/" target="_blank" ><h3> Visit My Blog</h3></a></p> 
	</div> 
	
	<div id="poststuff" > 
		<div id="post-body" class="metabox-holder columns-2" >
			<div id="post-body-content" > 
				<div class="meta-box-sortables"> 
					<div id="dashboard_right_now" class="postbox">
						<div class="handlediv" > <br> </div>
						<h3 class="hndle"  ><img src="<?php echo KV_BACKLINK_URL.'/images/kv_logo.png'; ?>" >  My plugins </h3> 
						<div class="inside" style="padding: 10px; "> 								
							<?php $kv_wp =  kv_get_web_page('http://profiles.wordpress.org/kvvaradha'); 
									
									 $kv_first_pos = strpos($kv_wp['content'], '<div id="content-plugins" class="info-group plugin-theme main-plugins inactive">');
									
									$kv_first_trim = substr($kv_wp['content'] , $kv_first_pos ); 
										
									$kv_sec_pos = strpos($kv_first_trim, '</div>');
									
									$kv_sec_trim = substr($kv_first_trim ,0, $kv_sec_pos );  
									
									echo $kv_sec_trim; 	?> 
						</div>
					</div>
				</div>							
			</div>
		</div>
	</div> 			
	<div id="postbox-container-1" class="postbox-container" > 
		<div class="meta-box-sortables"> 
			<div id="postbox-container-2" class="postbox-container" >
				<div id="dashboard_right_now" class="postbox">
					<div class="handlediv" > <br> </div>
					<h3 class="hndle" ><img src="<?php echo KV_BACKLINK_URL.'/images/kv_logo.png'; ?>" >  Donate </h3> 
					<div class="inside" style="padding: 10px; " > 
						<b>If i helped you, you can buy me a coffee, just press the donation button :)</b> 
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
							<input type="hidden" name="cmd" value="_donations" />
							<input type="hidden" name="business" value="<?php echo 'kvvaradha@gmail.com'; ?>" />
							<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
							<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
						</form>
					</div> 
				</div> 
			</div>
			<div id="postbox-container-2" class="postbox-container" > 
				<div id="dashboard_quick_press" class="postbox">
					<div class="handlediv" > <br> </div>
					<h3 class="hndle" ><img src="<?php echo KV_BACKLINK_URL.'/images/kv_logo.png'; ?>" >  Support me from Facebook </h3> 
					<div class="inside" style="padding: 10px; "> 
						<p><iframe allowtransparency="true" frameborder="0" scrolling="no" src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fkvcodes&amp;width=180&amp;height=300&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;show_border=false&amp;header=false&amp;appId=117935585037426" style="border:none; overflow:hidden; width:250px; height:300px;"></iframe></p>
					</div> 
				</div> 
			</div>
		</div>
	</div> 				
</div> <!-- /wrap -->
<?php

}

function kv_get_web_page( $url )
{
	$options = array(
		CURLOPT_RETURNTRANSFER => true,     // return web page
		CURLOPT_HEADER         => false,    // don't return headers
		CURLOPT_FOLLOWLOCATION => true,     // follow redirects
		CURLOPT_ENCODING       => "",       // handle compressed
		CURLOPT_USERAGENT      => "spider", // who am i
		CURLOPT_AUTOREFERER    => true,     // set referer on redirect
		CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
		CURLOPT_TIMEOUT        => 120,      // timeout on response
		CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
	);

	$ch      = curl_init( $url );
	curl_setopt_array( $ch, $options );
	$content = curl_exec( $ch );
	$err     = curl_errno( $ch );
	$errmsg  = curl_error( $ch );
	$header  = curl_getinfo( $ch );
	curl_close( $ch );

	$header['errno']   = $err;
	$header['errmsg']  = $errmsg;
	$header['content'] = $content;
	return $header;
}

add_action( 'admin_print_styles', 'kv_admin_css' );
function kv_admin_css() {
	 wp_enqueue_style("kvcodes_admin", KV_BACKLINK_URL."/kv_admi_style.css", false, "1.0", "all");
}

} else {
	function kv_admin_submenu_kv_backlink_page() { 		
		add_submenu_page( 'kvcodes', 'KV Google Backlink  Checker', 'KV Google Backlink  Checker', 'manage_options', 'kv_backlink', 'kv_google_backlink_fn_widget' );
	}
add_action('admin_menu', 'kv_admin_submenu_kv_backlink_page');
	
}

function kv_google_backlink_fn($kv_domain) {
	$kv_site = $_SERVER['SERVER_NAME'] ; 
	if (preg_match('/localhost/',$kv_site)) {
		$kv_site = 'kvcodes.com' ; 
	}
	$url="http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=site:".$kv_site."&filter=0"; 
	$ch=curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	
	curl_setopt ($ch, CURLOPT_HEADER, 0); 
	curl_setopt ($ch, CURLOPT_NOBODY, 0); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
	$kv_json = curl_exec($ch); 
	curl_close($ch); 
	$results=json_decode($kv_json,true);  
	
	if($results['responseStatus']==200) { 
		return  $results['responseData']['cursor']['resultCount']; 
	} else { 
		return ' Sorry No reults ! ' ; 
	} 
}

function kv_google_backlink_fn_widget() {

?>
	
 <div class="wrap">
        <div class="icon32" id="icon-tools"><br/></div>
        <h2><?php _e('Kv Backlinks', 'kvcodes') ?></h2>

		<div id="dashboard-widget-wrap" >
			<div id="dashboard-widgets" class="metabox-holder columns-2" >
				<div id="postbox-container-1" class="postbox-container" > 
					<div class="meta-box-sortables"> 
						<div id="dashboard_right_now" class="postbox">
							<div class="handlediv" > <br> </div>
							<h3 class="hndle" >KV Backlinks </h3> 
							<div class="inside" style="padding: 10px; " > <?php kv_print_backlink_result(); ?> 
							</div> 
						</div> 
					</div>
				</div> 
			</div>
		</div> 
</div> <!-- /wrap -->
<?php	
}

function kv_alexa_rank($kv_site) { 
	$xml = simplexml_load_file('http://data.alexa.com/data?cli=10&dat=snbamz&url='.$kv_site);
	return isset($xml->SD[1]->POPULARITY)?$xml->SD[1]->POPULARITY->attributes()->TEXT:0; 
}
function kv_alexa_local_rank($kv_site) { 
	$xml = simplexml_load_file('http://data.alexa.com/data?cli=10&dat=snbamz&url='.$kv_site);
	$kv_local_rank =  isset($xml->SD[1]->COUNTRY)?$xml->SD[1]->COUNTRY->attributes()->NAME:0 .'   ' . isset($xml->SD[1]->COUNTRY)?$xml->SD[1]->COUNTRY->attributes()->RANK:0; 
	return $kv_local_rank; 
}
function kv_alexa_backlinks($kv_site) { 
	$xml = simplexml_load_file('http://data.alexa.com/data?cli=10&dat=snbamz&url='.$kv_site);
	return isset($xml->SD[0]->LINKSIN)?$xml->SD[0]->LINKSIN->attributes()->NUM:0; 
}
function kv_alexa_reach($kv_site) { 
	$xml = simplexml_load_file('http://data.alexa.com/data?cli=10&dat=snbamz&url='.$kv_site);
	return isset($xml->SD[1]->REACH)?$xml->SD[1]->REACH->attributes()->RANK:0; 
}


function kv_yahoo_indexed_pages($kv_site) {	
	$kv_site = strtolower(trim($kv_site));
	$yahoo_url = 'http://siteexplorer.search.yahoo.com/search?p=http%3A%2F%2F'.$kv_site;
	$yahoo_url_contents = file_get_contents($yahoo_url);
	if(preg_match('/Pages \(([0-9,]{1,})\)/im', $yahoo_url_contents, $regs)){
		$indexed_pages = trim($regs[1]);
		return $indexed_pages;
	}else{
		return ' Not Indexed @ Yahoo.com!';
	}
}



function kv_dashboard_widgets() {
	wp_add_dashboard_widget('dashboard_widget', 'Your SEO Status', 'kv_print_backlink_result');
}


add_action('wp_dashboard_setup', 'kv_dashboard_widgets' );


function kv_print_backlink_result() {

$kv_domain = $_SERVER['SERVER_NAME']; 
if (preg_match('/localhost/',$kv_domain)) {
	$kv_domain = 'kvcodes.com' ; 
}

$kv_social=new KvshareCount('http://'.$kv_domain);
 ?>
<table width="100%" > 								
								<tr> <td> Google Backlink Count : </td> <td>  <?php echo kv_google_backlink_fn($kv_domain) ; ?> </td> </tr> 
								<tr> <td> Google Page Rank : </td> <td><?php $rankObject = new KvPR();echo $pageRank = $rankObject->get_google_pagerank('http://'.$kv_domain.'/'); ?> </td> </tr>
								<tr> <td> Alexa Rank : </td> <td> <?php echo kv_alexa_rank($kv_domain); ?>( Global) <br> <?php echo kv_alexa_local_rank($kv_domain); ?> (Local) </td> </tr>
								<tr> <td> Alexa Backlinks : </td> <td> <?php echo kv_alexa_backlinks($kv_domain); ?> </td> </tr>
								<tr> <td> Alexa Reach : </td> <td> <?php echo kv_alexa_reach($kv_domain); ?> </td> </tr>
							<!--	<tr> <td> Yahoo indexed Pages: </td> <td> <?php //echo kv_yahoo_indexed_pages($kv_domain); ?> </td> </tr> -->
								<tr> <td colspan="2" ><h3>  Social Counts </h3> </td> </tr> 
								<tr> <td> Twitter : </td> <td> <?php echo $kv_social->get_tweets(); ?> </td> </tr> 
								<tr> <td> Facebook : </td> <td> <?php echo $kv_social->get_fb(); ?> </td> </tr> 
								<tr> <td> LinkedIn : </td> <td> <?php echo $kv_social->get_linkedin(); ?> </td> </tr> 
								<tr> <td> Google Plus : </td> <td> <?php echo $kv_social->get_plusones(); ?> </td> </tr> 
								<tr> <td> Delicious : </td> <td> <?php echo $kv_social->get_delicious(); ?> </td> </tr> 
								<tr> <td> StumbleUpon : </td> <td> <?php echo $kv_social->get_stumble(); ?> </td> </tr> 
								<tr> <td> Pinterest  : </td> <td> <?php echo $kv_social->get_pinterest(); ?> </td> </tr> 
							</table> 
							
							<?php } 
?>