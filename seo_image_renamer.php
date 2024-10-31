<?php
/*
Plugin Name: SEO Image Renamer 
Plugin URI: http://www.akm3.de/
Description: The SEO image renamer scans your database for images which are attached to posts and pages. It then renames the image regarding SEO-guidelines and removes it Meta-Information fron the vendor
Version: 1.2.1
Author: Andre Alpar, AKM3
Contributors: AKM3
Requires at least: 3.0
License: Proprietary
*/


$seo_imr_version = "1.2.1";

$seo_imr_plugin_page = "seo_image_renamer_options_page";




/**
  * Install section
  */
  
  


if(!function_exists('seo_image_renamer_install')) {
  function seo_image_renamer_install() {
  
     global $wpdb, $seo_imr_version;
     
     
     ini_set('display_errors', 0);
     
     $image = new Imagick();
  
    
  
  }
  
}



register_activation_hook(__FILE__,'seo_image_renamer_install');



/**
  * Pages
  */
  
  
  
  
  

add_action('admin_menu', 'seo_image_renamer_admin'); //will load the plugin when the menu loads





if(!function_exists('seo_image_renamer_admin')) {
  function seo_image_renamer_admin() {
    global $seo_imr_version;
    global $seo_imr_plugin_page;
  
  	add_options_page('SEO Image Renamer '. $seo_imr_version, 'SEO IMR', 'edit_pages', $seo_imr_plugin_page, 'seo_image_renamer_options');
  }
}


if(!function_exists('seo_image_renamer_options')) {
  function seo_image_renamer_options() {
  	if (!current_user_can('edit_pages'))  {
  		wp_die( __('You do not have sufficient permissions to access this page.') );
  	}
  	
    wp_enqueue_script('thickbox',null,array('jquery'));
    wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css', null, '1.0');
 
  	
  	global $wpdb;
  	global $seo_imr_plugin_page;
  	
  	/**
  	  * The suspicous images array contains all strings that are matched against
  	    Since Wordpress tables are always utf8-ci we do not need strtolower
  	  */
  	$suspicious_imagename_parts = array( 
  	   'stock',
  	   'fotolia',
  	   'corbisimages', 
  	   'gettyimages', 
  	   'dreamstime', 
  	   'shutterstock', 
  	   'bigstockphoto', 
  	   'sxc'
  	   
  	);
  	
  	/*
  	 
  	 
  	 if(!empty($_GET['delete_id']) && is_numeric($_GET['delete_id']) ) {
  	   $wpdb->query('DELETE FROM ' . $cookie_switch_prefs_table . ' WHERE id = ' .$_GET['delete_id']);
  	   $wpdb->query('DELETE FROM ' . $cookie_switch_tracking_table . ' WHERE pref_id = ' . $_GET['delete_id']);
  	 }
  	 
  	 $wpdb->show_errors();
  	
  	
    		
		if(!empty($_POST['save_new']) && !empty($_POST['tracking_code']) && !empty($_POST['trigger_code']) && !empty($_POST['redirect_target']) && !empty($_POST['name'])) {
     
     
     $wpdb->insert( 
           $cookie_switch_prefs_table, 
           array( 
             'created' => current_time('mysql'), 
             'trigger_code' => ($_POST['trigger_code']), 
             'redirect_target' => ($_POST['redirect_target']), 
             'tracking_code' => ($_POST['tracking_code']),
             'name' => ($_POST['name'])
          ) 
        ); 


    
    }*/
    		
    		?>
      
      
  	
  	<style>
  	  table td, table, table tr{
  	    font-size: 10px;
  	    vertical-align: top;
  	    border-style: solid;
  	    border-color: #ccc;
  	    border-width: 1px;
  	    padding: 5px;
  	    border-spacing: 0;
  	    border-collapse: collapse;   
  	  }
  	
  	</style>
  	
  	<script>
  	   jQuery(document).ready(function() {
         
         //handler function for saving options
         jQuery('#seo_imr_delete_image, #seo_imr_replace_alt').live('click', function(el){
           
           if(jQuery(this).is(':checked')) {
             //save status ON via AJAX
             jQuery.ajax({
              url: "/wp-admin/admin-ajax.php",
              type: "POST",
              data: {"action": "SEOIMRSaveOption", "option_value" : 1, 'option_name' : jQuery(this).attr('id')},
              success: function(response){
                if(response != "" && response != 0) alert(response)  //since we do not return HTTP 500 this is used for error display
              },
              error: function(jqXHR, textStatus) {
                alert("An error occured: " + textStatus)
              } 
            })
           }
           else {
             //save status OFF via AJAX
             jQuery.ajax({
              url: "/wp-admin/admin-ajax.php",
              type: "POST",
              data: {"action": "SEOIMRSaveOption", "option_value" : 0, 'option_name' : jQuery(this).attr('id')},
              success: function(response){
                if(response != "" && response != 0) alert(response)  //since we do not return HTTP 500 this is used for error display
              },
              error: function(jqXHR, textStatus) {
                alert("An error occured: " + textStatus)
              } 
            })
           }
         });
         
         
         
         jQuery('button.image_edit_take').live('click', function(e){
           e.preventDefault();
           
           
           var data = getData(jQuery(this), true);
           
           if(data === false )
             return; 
           
           var thisObject = jQuery(this);
           
           
           jQuery.ajax({
              url: "/wp-admin/admin-ajax.php",
              type: "POST",
              data: data,
              success: function(response){
                if(response != "" && response != 0){
                 alert(response)  //since we do not return HTTP 500 this is used for error display
                } else {
                   thisObject.parents('tr').remove();
                }
              },
              error: function(jqXHR, textStatus) {
                alert("An error occured: " + textStatus)
              } 
            });
         });
         
      
         
         
         
         jQuery('button.image_edit_manually').live('click', function(e){
           e.preventDefault();
           
           var data = getData(jQuery(this),false);
           
           if(data === false )
             return; 
           
          
           var thisObject = jQuery(this);
           
            jQuery.ajax({
              url: "/wp-admin/admin-ajax.php",
              type: "POST",
              data: data,
              success: function(response){
                if(response != "" && response != 0){
                 alert(response)  //since we do not return HTTP 500 this is used for error display
                } else {
                   thisObject.parents('tr').remove();
                }
              },
              error: function(jqXHR, textStatus) {
                alert("An error occured: " + textStatus)
              } 
            });

           
           
           
         });
    
         
         function getData(o, isSelect) {
         
           var data = {"image_name" : "", "image_post_id" : 0};
         
           if(isSelect)
             data.image_name = o.prev('select').find('option:selected').val();
           else 
              data.image_name = o.prev('input').val();

           if(data.image_name == undefined || data.image_name == "" || data.image_name == null) {
             alert("You have to enter a valid image name!");
             return false;
           }
           
           data.image_post_id = o.attr('id').substr(o.attr('class').length + 1);
           
           if(data.image_post_id == undefined || data.image_post_id == "" || data.image_post_id == null) {
             alert("Image information could not be extraced from DOM!");
             return false;
           }
           
           
           data.action = 'SEOIMRProcessImageData';
           
           return data;
           
         }
       });
  	  
  	</script>
  	
  	
  	<div class="wrap">
  	  <h2>Welcome to SEO Image Renamer</h2>	  
  	  

    	  <div style="float:left;background-color:white;padding: 10px 10px 10px 10px;margin-right:15px;border: 1px solid #ddd;">
    		<div style="width:900px">
    			<h4>Suspicous Images</h4>
    			<p>
    			  Here you can see all all images that do have suspicious names in your database.
    			</p>
    			
    			<?php
    			  if(!isset($_GET['seoir_showall'])) {
    			    echo '<p><b>Note</b>: We flag an image as suspicous if it contains critical EXIF-Data or if following nameparts appear in it: <b>Stock</b>, <b>Fotolia</b>, <b>corbisimages</b>, <b>gettyimages</b>, <b>dreamstime</b>, <b>sxc</b>!</p>';
    			    echo '<p>Reload with all images shown: <a href="/wp-admin/options-general.php?page='.$seo_imr_plugin_page.'&seoir_showall">Show all Images</a></p>';
    			  } else
    			    echo '<p>Show only suspicious images: <a href="/wp-admin/options-general.php?page='.$seo_imr_plugin_page.'">Show suspicious Images</a></p>';
    			?>
    			<p>
    			  <h2>Options</h2>
    			  
    			  <?php
    			    //we get the options from the database
    			    
    			    
    			    $delete_image_status = ($wpdb->get_var("SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'seo_imr_delete_image'" )) ? 'checked="checked"' : '';
    			    $replace_alt_status = ($wpdb->get_var("SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'seo_imr_replace_alt'" )) ? 'checked="checked"' : '';
    			    
    			  ?>
    			  <p>
    			    <input type="checkbox" name="seo_imr_delete_image" id="seo_imr_delete_image" value="1" <?php echo $delete_image_status; ?>/>
    			    <label for="seo_imr_delete_image">Delete original image from filesystem if last occurence has been renamed.</label>
    			    
    			  </p>
    			  <p>
    			    <input type="checkbox" name="seo_imr_replace_alt" id="seo_imr_replace_alt" value="1" <?php echo $replace_alt_status; ?>/>
    			    <label for="seo_imr_replace_alt">Also replace ALT-Tags and TITLE-Tags in HTML upon renaming the image.</label>    			    
    			  </p>
    			</p>
    			
    			<table id="reg_track_pair_table">
    			  <tr>
    			    <td>Image</td>
    			    <td>Filename</td>
    			    <td>Type</td>
    			    <td>Kritische EXIF-Daten</td>
    			    <td>Volle EXIF-Daten</td>
    			    <td>Suggested Name</td> 			    
    			  </tr>
    			  <hr>
    			  <?php
    			  
    			  $wpdb->show_errors();
    			  
    			  $sql = sprintf(
      			      'SELECT a.ID as image_post_id, a.post_name as image_post_name, a.post_mime_type as image_mime_type, b.post_content as parent_post_content, c.meta_value as image_path'.
      			      ' FROM %sposts as a  ' .
      			      ' LEFT JOIN %sposts as b ON a.post_parent = b.ID '. 
      			      ' LEFT JOIN %spostmeta as c ON a.ID = c.post_id AND c.meta_key = "_wp_attached_file" '. 
      			      ' WHERE a.post_mime_type LIKE "image%%"'
      			     ,$wpdb->prefix
      			     ,$wpdb->prefix
      			     ,$wpdb->prefix);
      			     
      		
    			  
      		  
    			  $results = $wpdb->get_results($sql,'ARRAY_A');
    			  
    			   
    			  $uploaddir = wp_upload_dir();
    			  
    			  $regex = sprintf('#(%s)#Uui', implode('|', $suspicious_imagename_parts));
    			  
    			  foreach($results as $result) {
    			  
    			    //filter out images that do look suspicious if necessarry
    			    $exif = @read_exif_data($uploaddir['basedir'].'/'.$result['image_path']);
    			    
    			    $exif_data = empty($exif['COMPUTED']['Copyright']) ? empty($exif['Copyright']) ? $exif['Artist'] : $exif['Copyright'] : $exif['COMPUTED']['Copyright'];    
    			  
    			    
    			    if(!isset($_GET['seoir_showall'])) {  
    			      
    			      if(empty($exif_data) && !preg_match($regex, $result['image_path']))
    			        continue;
    			  
    			    }
    			    preg_match_all('#<(h2|strong)>(.*)<\/(h2|strong)>#Ui', $result['parent_post_content'], $matches);
    			    
    			    
    			    $keyword_occurence = array_flip(array_count_values($matches[2]));
    			    array_walk($keyword_occurence, create_function('&$v,$k', '$v = preg_replace(array("#[^\w-]#"), array(""), $v);'));

    			    //$sorted_keyword_occurence = sort($keyword_occurence);
    			    
    			    $suggested_name = array_pop($keyword_occurence);
    			    
    			    //$img = new Imagick($uploaddir['basedir'].'/'.$result['meta_value']);  
    			    
    			     
    			    if(strstr($result['image_mime_type'], '/jp') === false)
    			      $exif_info_string = 'Imagetype does not support EXIF';
    			    else 
    			      $exif_info_string = '<a href="#TB_inline?height=600&width=800&inlineId=full_exif_'.htmlspecialchars($result['image_post_id']).'" class="thickbox" title="Show full EXIF">Show</a>';
    			       			
    			    
    			    
    			    printf(
    			      '
    			      <tr>
    			        <td><a href="%s#TB_iframe" class="thickbox"><img src="%s" height="100" width="100" alt=""></a></td>
    			        <td>%s</td>
    			        <td>%s</td>
    			        <td>%s</td>
    			        <td>%s</td>    		
    			        <td>
    			          <select>
    			            <option>%s</option>
    			            <option>%s</option>
    			          </select>
    			          <button id="image_edit_take_%d" class="image_edit_take">
    			            Take!
    			          </button>
    			          <br />
    			          <input name="different_suggest" value=""/>
    			          <button id="image_edit_manually_%d" class="image_edit_manually">
    			            Manually Rename!
    			          </button>    			          
    			       </td>   		        
    			      </tr>
    			      <div id="full_exif_%d" style="display:none;"><pre>%s</pre></div>
    			      ',
    			      $uploaddir['baseurl'].'/'.$result['image_path'],
    			      $uploaddir['baseurl'].'/'.$result['image_path'],
    			      htmlspecialchars($result['image_path']),
    			      htmlspecialchars($result['image_mime_type']),
    			      $exif_data,
    			      $exif_info_string,    		
    			      $suggested_name,
    			      implode('</option><option>', $keyword_occurence),
    			      htmlspecialchars($result['image_post_id']),
    			      htmlspecialchars($result['image_post_id']),
    			      $result['image_post_id'],
    			      htmlspecialchars(print_r($exif, true))
    			        			    
    			       
    			   );
    			  }
    			  
    			  
    			  ?>
    			</table>
    			
    			</div>
    		</div>
    		
    		
    		
    		
    		
    		<div style="clear:both; padding-top: 20px;"></div>
    	
    	
    		
    		
    		
  	  
  	  
  	  
  	  
  	  
  	</div> 
  	<?php
  }
}


//AJAX Functions

add_action('wp_ajax_SEOIMRProcessImageData', 'SEOIMRProcessImageData');

function SEOIMRProcessImageData() {
  
  global $wpdb;
  
  if(empty($_POST['image_post_id']) || empty($_POST['image_name']))
    die('Missing image_post_id or image_name');
  
  $image_post_id = $_POST['image_post_id'];
  
  $image_name = htmlspecialchars($_POST['image_name']);
  
  $image_fs_name = preg_replace(array("#ß#","#ä#","#ü#","#ö#","#Ä#","#Ü#", "#Ö#","#\s#", "#[^\w-]#"), array("ss","ae","ue","oe","Ae","Ue","Oe","-", ""), $image_name);


  
  $wpdb->show_errors();
  
  $sql = sprintf(
      			      'SELECT a.post_name as image_post_name, a.post_mime_type as image_mime_type, c.meta_id as image_id, c.meta_value as old_image_path '.
      			      ' FROM %sposts as a  ' .
      			      ' LEFT JOIN %spostmeta as c ON a.ID = c.post_id AND c.meta_key = "_wp_attached_file" '. 
      			      ' WHERE a.ID = %d'
      			     ,$wpdb->prefix
      			     ,$wpdb->prefix      			     
      			     ,$image_post_id);
      			     
    			    
  $result = $wpdb->get_row($sql,'ARRAY_A');
    			  
    			   
  $uploaddir = wp_upload_dir();
  
  $image_parts = pathinfo($result['old_image_path']);
  
  $new_image_name  = $image_fs_name . '.' . $image_parts['extension'];  
  
  $new_image_path = $image_parts['dirname'] . '/'. $new_image_name;
  
  $old_p = $result['old_image_path'];
  
  
  
  
  $extension_length = strlen($image_parts['extension']) + 1 ; //+1 cause we need to include the dot
  
  $replacement_path_old = substr($result['old_image_path'], 0, -$extension_length); //will result in the path without extension: 2010/01/MyOldImageName  
  
  $replacement_path_new = $image_parts['dirname'] . '/'. $image_fs_name; ////will result in the path without extension: 2010/01/MyNewImageName
  
  
  
    /**
    * How Wordpress saves images:
    *
    * Wordpress images are always saved as an entry in wp_posts. The post_type is set to "attachment"
    *
    * For each usage in a post a new entry in wp_postmeta is generated.
    * 
    * The entry for "_wp_attachment_image_alt" in wp_postmeta is only valid for the MediaLibrary and has no effect on the actually used image. It only has effect on newly inserted images
    *
    * What later is used as the title is the post_title from wp_posts
    *
    * So what we have to do is the following:
    *
    * Scan if filesystem contains new image name or if meta_value with new image name exists
    *
    * Fork a new image from the old one
    * Replace post_name from the image with the new image name
    * Replace the src attribute from the post that contains the image
    * Replace the _wp_attached_file meta_value entry of the post. This is the actual file information of the image
    * Replace all sizes in the wp_postmeta of the image so all sizes are replaced correctly
    * 
    * If wanted, replace the ALT tag in post_content and as _wp_attachment_image_alt of the image
    * If wanted, replace the TITLE tag in post_content and as post_title of the image
    *
    * 
  */
  
  
  
#  (alt=".*(?<!a)")
  
  
  //get options from the DB
  $delete_image_status = ($wpdb->get_var("SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'seo_imr_delete_image'" )) ? 'checked="checked"' : '';
  $replace_alt_status = ($wpdb->get_var("SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'seo_imr_replace_alt'" )) ? 'checked="checked"' : '';
    	
  
  
  //STEP 1: Check if image is available in filesystem
  
  $matched_files_in_fs = glob($uploaddir['basedir'].'/'.$new_image_path);
  $wpdb->query(
    sprintf(
      'SELECT * FROM %spostmeta WHERE meta_key = "_wp_attached_file" AND meta_value LIKE "%%%s"',
      $wpdb->prefix,
      $new_image_path
    )
  );

  if($wpdb->num_rows !== 0 || !empty($matched_files_in_fs))
    die('Imagename already present in filesystem or database! Please choose other name.');
      
 
  
  
  
  
  #alt="Die e-Zigarette im Case." //LATER
  
  if($replace_alt_status) {
  
      //replace the title in DB for MediaLibary
      $wpdb->query(
        sprintf(
          'UPDATE %sposts SET post_title = "%s" WHERE ID = %d ', 
          $wpdb->prefix,
          $image_name,
          $image_post_id
          
        )
      );
        
      //replace the alt-TAG in DB for MediaLibary
      $wpdb->query(
        sprintf(
          'UPDATE %spostmeta SET meta_value = "%s"  WHERE post_id = %d AND meta_key = "_wp_attachment_image_alt" ', 
          $wpdb->prefix,
          $image_name,
          $image_post_id
        )
      );
      
      
      //replace the alt-TAG and title in the content
      $posts = $wpdb->get_results(sprintf('SELECT * FROM %sposts WHERE post_content LIKE "%%%s%%"',$wpdb->prefix, $replacement_path_old),'ARRAY_A');
  
      
      $img_tag_pattern = '#<img.*'.preg_quote($replacement_path_old).'.*>#Uui';
            
      foreach($posts as $post) {
      
      
        preg_match($img_tag_pattern, $post['post_content'], $matched_image_tag); //matches the whole image tag
        
        $matched_image_tag[0] = preg_replace('#alt="[^"]*"#', 'alt="'.$image_name.'"', $matched_image_tag[0]);
        $matched_image_tag[0] = preg_replace('#title="[^"]*"#', 'title="'.$image_name.'"', $matched_image_tag[0]);
        
        
        $post['post_content'] = preg_replace($img_tag_pattern, $matched_image_tag[0], $post['post_content']);
        
        //now we refill to the database
        
        $wpdb->update( 
        	$wpdb->prefix.'posts', 
        	array( 
        		'post_content' => $post['post_content'],	
        	), 
        	array( 'ID' => $post['ID'] ) 
        ); 
    
      
      
      
      }
     
  }
  


  




  //now replace the image post
  $ok = $wpdb->query(
    sprintf('UPDATE %sposts SET post_name = "%s", guid = replace(guid, \'%s\',\'%s\')  WHERE ID = %d ', 
    $wpdb->prefix,
    $image_fs_name,
    $image_parts['filename'],
    $image_fs_name,
    $image_post_id
    
    )
  );
  
  if($ok === FALSE) {
    echo "Tried to update the post_name and guid.";
    echo "Replacement was: " . $image_fs_name. " for " .$image_parts['filename'];
    #die(); 
  }

  
  
  //now we replace the meta filename of the image 
  $ok = $wpdb->query(
    sprintf('UPDATE %spostmeta SET meta_value = replace(meta_value, \'%s\',\'%s\')  WHERE post_id = %d AND meta_key = "_wp_attached_file" ', 
    $wpdb->prefix,
    $image_parts['filename'],
    $image_fs_name,
    $image_post_id
    )
  );
  
  if($ok === FALSE) {
    echo "Tried to update the postmeta and set meta_value.";
    echo "Replacement was: " . $image_fs_name. " for " .$image_parts['filename'];
    #die(); 
  }
  
  //now we rebuild the meta array, which contains all spun-off sizes
  $sql = sprintf(
      			      'SELECT meta_value '.
      			      ' FROM %spostmeta  ' .
      			      ' WHERE meta_key = "_wp_attachment_metadata" AND post_id = %d'
      			     ,$wpdb->prefix      			     
      			     ,$image_post_id);
      			     
    			    
  $result = $wpdb->get_row($sql,'ARRAY_A');
  
  if(is_null($result)) {
    echo "Could not find metadata for image.";
    echo "Did you upload the image in the medialibrary correctly?";
   die();
  }
  
  
 
 
  #now we iterate over the thumbnails array. 
  #This array must be functional, otherwise Alternate replacemant is used
  
  $meta_broken = false;
  $meta_array = unserialize($result['meta_value']);
  
  if(!empty($meta_array) && !empty($meta_array['file']) && !empty($meta_array['sizes']) && is_array($meta_array['sizes'])) { //we walk the meta array to replace all modified images
  
    $dir_parts = pathinfo($meta_array['file']);
  
  
    //first we process the original file
    $meta_array['file'] = $new_image_path;
    
    renameFileInPosts($old_p, $new_image_path);
    
    foreach($meta_array['sizes'] as $key => $thumbnail) {
    
      $meta_array['sizes'][$key]['file'] = sprintf('%s-%sx%s.%s',$image_fs_name, $thumbnail['width'], $thumbnail['height'], $image_parts['extension']);
    
      renameFileInPosts($thumbnail['file'], $meta_array['sizes'][$key]['file']);
         
      deEXIFyImage($uploaddir['basedir'].'/'.$dir_parts['dirname'] . '/' .$thumbnail['file'], $uploaddir['basedir'].'/'.$dir_parts['dirname'] . '/' .$meta_array['sizes'][$key]['file'], true);
      
      if($delete_image_status) @unlink($uploaddir['basedir'].'/'.$dir_parts['dirname'] . '/' .$thumbnail['file']);
  
    }
    
   $meta_array['image_meta'] = array(); //kill any metadata
      
  
   $ok = $wpdb->update(
      $wpdb->prefix.'postmeta',
      array(
        'meta_value' => serialize($meta_array)
      ),
      array(
        'post_id' => intval($image_post_id),
        'meta_key' => '_wp_attachment_metadata'
      )
    ); 
  
    if($ok === FALSE) {
      echo "There was an error while setting _wp_attachment_metadata";
      echo "Tried to set: ". serialize($meta_array);
    }

  
  } else {
    $meta_broken = true;
  }
  
  if($meta_broken) { //apply forced replacing. This may lead to a broken image, but is the best we can do
    echo "The Wordpress-Media-Library contained broken data. The image HAS been processed, but may not be resizeable anymore!";
  
    renameFileInPosts($replacement_path_old, $replacement_path_new);
  }
  
  
  
  #last_step, the original image
  deEXIFyImage($uploaddir['basedir'].'/'.$old_p, $uploaddir['basedir'].'/'.$new_image_path, true); //will CLONE not REPLACE the image
  
  if($delete_image_status) @unlink($uploaddir['basedir'].'/'.$old_p);
  


  
  
      
  

}



add_action('wp_ajax_SEOIMRSaveOption', 'SEOIMRSaveOption');

function SEOIMRSaveOption() {
  
  global $wpdb;
  
  $allowed_options = array('seo_imr_replace_alt', 'seo_imr_delete_image');
  
 
  
  if(empty($_POST['option_name']) || !isset($_POST['option_value']) || !in_array($_POST['option_name'], $allowed_options))
    die('Invalid option supplied!');
    
  //first we check if the option is already set
  
      //now we create the necessary tabs in the plugin   
      			  
  $wpdb->show_errors();
  
    
  $updated = $wpdb->update( 
  	$wpdb->prefix.'options', 
  	array( 
  		'option_value' => (int) $_POST['option_value'],	
  	), 
  	array( 'option_name' => $_POST['option_name'] ) 
  ); 

  
  if($updated <= 1) {
    $wpdb->insert( 
    	$wpdb->prefix.'options', 
      	array( 
      		'option_name' => $_POST['option_name'],
      		'option_value' => (int) $_POST['option_value'], 
      		'autoload' => 'yes' 
      	)
      );
  }
  
}


//HELPER FUNCTIONS FOR AJAX CALLS

function deEXIFyImage($old_p, $new_p, $allow_empty = false) {
  if($allow_empty && !file_exists($old_p)) return; #alright no file no job. This can happen, cause wordpress saves the images sometsimes doubletime.
  try
    {   
        $img = new Imagick($old_p);
        $img->stripImage();     
        $img->writeImage($new_p);
        $img->clear();
        $img->destroy();
        #@unlink($old_p); // cause images can be multiple

  } catch(Exception $e) {
    echo 'Exception caught: ',  $e->getMessage(), "\n";
    throw new Exception('DONE');
  }
}


function renameFileInPosts($old_name, $new_name){
  
  global $wpdb;
  
  //replace the image name in ALL posts
  $ok = $wpdb->query(
      sprintf('UPDATE %sposts SET post_content = replace(post_content, \'%s\',\'%s\')', 
      $wpdb->prefix,
      $old_name,
      $new_name
      )
  );
    
  if($ok === FALSE) {
    echo "Tried to update the post_name and guid.";
    echo "Replacement was: " . $new_name. " for " .$new_name;
    #die(); 
  }
}
  

