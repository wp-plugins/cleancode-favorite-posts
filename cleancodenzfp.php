<?php
/*
 Plugin Name: CleanCode NZ Favorite Posts Plugin
 Plugin URI: http://www.cleancode.co.nz/cleancodenz-favorite-posts-wordpress-plugin
 Description: A tool to report the post tracking using google analytics data
 Version: 1.0.0
 Author: Zhizhong Wang
 Author URI: http://www.cleancode.co.nz/about
 License: GPL2
 */

/*
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; version 2 of the License.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// if you change this, please make sure to save all your options again
define('cleancodenzkey','cleaclodecodekey') ;

require 'gapi.class.php';

$cleancodenzfp_ver='1.0.0';

/*
 * Add options meu
 * @author Zhizhong Wang
 *  */
function cleancodenzfp_option_menu()
{
  //create new top-level menu
  // add_menu_page('CleanCodeNZ Favorite Posts', 'CleanCodeNZFP', 'administrator', __FILE__, 'cleancodenzfp_options_page',plugins_url('/images/icon.png', __FILE__));

  //Create sub menu page
  add_submenu_page('options-general.php','CleanCodeNZ Favorite Posts','CleanCodeNZFP','administrator' , __FILE__, 'cleancodenzfp_options_page');

  //call register settings function
  add_action( 'admin_init', 'cleancodenzfp_register_settings' );

}

/*
 * Register settings
 * @author Zhizhong Wang
 * */

function cleancodenzfp_register_settings()
{
  //register our settings
  register_setting( 'cleancodenzf-settings-group', 'cleancodenzfp_language','');
  register_setting( 'cleancodenzf-settings-group', 'cleancodenzfp_ga_email','cleancodenzfp_options_encrypt');
  register_setting( 'cleancodenzf-settings-group', 'cleancodenzfp_ga_password','cleancodenzfp_options_encrypt');
  register_setting( 'cleancodenzf-settings-group', 'cleancodenzfp_ga_profile_id','cleancodenzfp_options_encrypt');
  register_setting( 'cleancodenzf-settings-group', 'cleancodenzfp_ga_startdate','');
  register_setting( 'cleancodenzf-settings-group', 'cleancodenzfp_maximum_posts','');
}

/*
 * encrypt the settings
 * @param  $input a string to be encrypted
 * @return $encrypted string encoded by base64
 * @author Zhizhong Wang
 * */
function cleancodenzfp_options_encrypt($input) {
  return  base64_encode(convert($input,cleancodenzkey));
}



/*
 * Generate options page
 * @author Zhizhong Wang
 */
function cleancodenzfp_options_page() {
  global $cleancodenzfp_ver;
?>
<div class="wrap">
<h2>CleanCodeNZ Favorite Posts Plugin ver <?php echo $cleancodenzfp_ver ?></h2>

<form method="post" action="options.php"><?php settings_fields('cleancodenzf-settings-group'); ?>

<table class="form-table">
	<tr valign="top">
		<th scope="row">Google Analytics Account(Email)</th>
		<td><input type="text" name="cleancodenzfp_ga_email"
			value="<?php echo convert(base64_decode(get_option('cleancodenzfp_ga_email')),cleancodenzkey)   ; ?>" /></td>
	</tr>

	<tr valign="top">
		<th scope="row">Google Analytics Account Password</th>
		<td><input type="password" name="cleancodenzfp_ga_password"
			value="<?php echo convert(base64_decode(get_option('cleancodenzfp_ga_password')),cleancodenzkey)  ; ?>" /></td>
	</tr>

	<tr valign="top">
		<th scope="row">Google Analytics Profile ID</th>
		<td><input type="text" name="cleancodenzfp_ga_profile_id"
			value="<?php echo convert(base64_decode(get_option('cleancodenzfp_ga_profile_id')),cleancodenzkey)  ; ?>" /></td>
	</tr>
	<tr valign="top">
		<th scope="row">Start Date of Report Period(YYYY-MM-DD)</th>
		<td><input type="text" name="cleancodenzfp_ga_startdate"
			value="<?php echo get_option('cleancodenzfp_ga_startdate') ; ?>" /></td>
	</tr>
	<tr valign="top">
		<th scope="row">Maximum Posts Returned(30)</th>
		<td><input type="text" name="cleancodenzfp_maximum_posts"
			value="<?php echo get_option('cleancodenzfp_maximum_posts') ; ?>" /></td>
	</tr>
</table>

<p class="submit"><input type="submit" class="button-primary"
	value="<?php _e('Save Changes') ?>" /></p>

</form>
</div>
<?php
}

/*
 * Html export of google analytics data
 * @author Zhizhong Wang
 */

function cleancodenzfp_create_favposts()
{
  $t_out = '';
  $t_out .= "\n\n<!-- START of CleanCodeNZ favorite posts output -->\n\n";

  $gaemail =  convert(base64_decode(get_option('cleancodenzfp_ga_email')),cleancodenzkey);
  $gapassword = convert(base64_decode(get_option('cleancodenzfp_ga_password')),cleancodenzkey);
  $gaprofile = convert(base64_decode(get_option('cleancodenzfp_ga_profile_id')),cleancodenzkey);

  $gastartdate =  get_option('cleancodenzfp_ga_startdate');
  
  if(!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $gastartdate)){
    $gastartdate = null;
  }
  
  
  $gamaximumposts =  get_option('cleancodenzfp_maximum_posts');

if(!preg_match('/^\d+$/', $gamaximumposts)){
    $gamaximumposts = 30;
  }
  
  try
  {
    $ga = new gapi($gaemail,$gapassword);

    $ga->requestReportData($gaprofile,
    array('pagePath','pageTitle'),
    array('pageviews','visits','timeOnPage'),
    array('-pageviews'),
    null,
    $gastartdate,
    null,
    1,
    $gamaximumposts);

    $t_out .='<div id="cleancodenzfp" style=" overflow: auto; padding-top:10px;">
    <table style="margin: 1em 0; border-collapse: collapse; width: 100%;table-layout:fixed;"><tr width="100%">
  <th width="70%" ALIGN="left" >Pages</th>
  <th width="10%" ALIGN="left">Page<br/>Views</th>
  <th width="10%" ALIGN="left">Visits</th>
  <th width="10%" ALIGN="left">AvgTime<br/>Seconds</th>
</tr>';

    foreach($ga->getResults() as $result)
    {

      $t_out .= '<tr width="100%">
      <td width="70%"><a href='.$result->getpagePath().'>'.$result->getpageTitle().'</a></td>
      <td width="10%">'.$result->getPageviews().'</td>
      <td width="10%">'.$result->getVisits().'</td>
      <td width="10%">'.round(($result->gettimeOnPage()/$result->getPageviews()),0).'</td>
      </tr>';

    }
    $t_out .='</table></div>';
    $t_out = str_replace("&amp;amp;", "&amp;", $t_out);
  }
  catch (Exception $e)
  {
    $t_out .=$e->getMessage();
  }
  return $t_out;

}

/*
 * Display favorite posts list if trigger is found
 * @author Zhizhong Wang 
 */
function cleancodenzfp_listen_favoriteposts($content) {
  if (strpos($content, "<!-- cleancodenzfavoritepostsgen -->") !== FALSE) {
    $content = str_replace('<!-- cleancodenzfavoritepostsgen -->', cleancodenzfp_create_favposts(), $content);
  }
  return $content;
}



// String EnCrypt + DeCrypt function
// Author: halojoy, July 2006
function convert($str,$ky=''){
  if($ky=='')return $str;
  $ky=str_replace(chr(32),'',$ky);
  if(strlen($ky)<8)exit('key error');
  $kl=strlen($ky)<32?strlen($ky):32;
  $k=array();for($i=0;$i<$kl;$i++){
    $k[$i]=ord($ky{$i})&0x1F;}
    $j=0;for($i=0;$i<strlen($str);$i++){
      $e=ord($str{$i});
      $str{$i}=$e&0xE0?chr($e^$k[$j]):chr($e);
      $j++;$j=$j==$kl?0:$j;}
      return $str;
}



add_filter('the_content', 'cleancodenzfp_listen_favoriteposts');

// add admin menu
add_action('admin_menu', 'cleancodenzfp_option_menu');
?>