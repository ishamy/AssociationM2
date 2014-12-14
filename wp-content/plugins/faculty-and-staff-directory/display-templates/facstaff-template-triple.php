<?php
	the_post();

	$sortdirection = 'ASC';
	$sortorder = 'title';
	if(get_option('fsdirectory_sortstyle')=='Sort Order'){
		$sortorder='menu_order';
		$sortdirection = 'ASC';
	}
	if(get_option('fsdirectory_sortstyle'=='Alphabetical')){
		$sortorder='title';
		$sortdirection = 'ASC';
	}
	
	$facstaff_posts = get_posts( array(
		'post_type' => 'facstaff',
		'posts_per_page' => -1, // Unlimited posts
		'orderby'=>$sortorder,
		'order'=>$sortdirection
	) );
	
	if ( $facstaff_posts ){
		wp_enqueue_style( 'facstaff-style', plugins_url('../css/faculty-staff-styles.css', __FILE__) );
		wp_enqueue_style( 'font-awesome-style', plugins_url('../assets/font-awesome/css/font-awesome.min.css', __FILE__) );

		function fs_size_scripts() {
			wp_enqueue_script( 'script-name', plugins_url('../js/jQuery.equalHeights.js'));
		}
		add_action( 'wp_enqueue_scripts', 'fs_size_scripts' );
				
				echo "<section class='facstaff'>";
				$i = 0;
				$len = count($facstaff_posts);
				foreach ( $facstaff_posts as $facstaff_posts ) {
					$post_thumbnail_id = get_post_thumbnail_id($facstaff_posts->ID, array(100,100));
					$thumb_src = wp_get_attachment_url( $post_thumbnail_id );
					setup_postdata($facstaff_posts);
					
					echo "<div class='fsentry fstriple'>";
									
					if($i != $len -1){
					}
					else {
					}
				
					if (get_option('fsdirectory_stylethumbnail') == 'Yes'){	//Yes style thumb				
						if (get_option('fsdirectory_hidethumbnail') =='No'){ //Don't hide
							if ( $thumb_src != ''){ //Does thumb exist?
								echo "<div class='fspic' style='float:none; text-align: center;'><img src='" . $thumb_src . "' class='fsimg-circle' width='100' height='100'>";
							}
							else { //If thumb is blank...
								echo "<div class='fspic' style='float:none; text-align: center;'><img src='" . plugins_url('../images/profile-placeholder.png', __FILE__)  . "' class='fsimg-circle' width='100' height='100'>";
							}//End thumb output						
						} //End hide/show thumb
						else{
							echo "<div class='fspic' style='text-align: left;'>"; //If no pic just open div
						}
					} // End Style thumb block
					
					else{ //Don't style thumb block
						if (get_option('fsdirectory_hidethumbnail') =='No'){ //Don't hide
							if ( $thumb_src != ''){  //Thumbnail exists?
								echo "<div class='fspic' style='float:none; text-align: center;'><img src='" . $thumb_src . "' id='noimgstyle'>";
							}
							else { //If thumbnail is blank
								echo "<div class='fspic' style='float:none; text-align: center;'><img src='" . plugins_url('../images/profile-placeholder.png', __FILE__)  . "' id='noimgstyle'>";
							} // End thumb output
						}	// End hide/show thumb
						else{
							echo "<div class='fspic' style='text-align: left;'>"; //If no pic just open div
						}					
					} //End Don't style thumb block							
					?>
		<br/>

		<?php 
		if ( $phone = get_post_meta($facstaff_posts->ID, 'facstaffphone',true) && (get_post_meta($facstaff_posts->ID, 'facstaffphone',true) != '123-345-4532')){
			echo "<a href='tel:" . get_post_meta($facstaff_posts->ID, 'facstaffphone',true) ."'><i class='fa fa-phone-square'></i></a>";
		}
		
		if ( $web = get_post_meta($facstaff_posts->ID, 'facstaffemail',true) && (get_post_meta($facstaff_posts->ID, 'facstaffemail',true)!='user@domain.com')){
			echo "<a href='mailto:" . get_post_meta($facstaff_posts->ID, 'facstaffemail',true) ."'><i class='fa fa-envelope-square'></i></a>";
		}
		
		if ( $web = get_post_meta($facstaff_posts->ID, 'facstaffwebsite',true) && (get_post_meta($facstaff_posts->ID, 'facstaffwebsite',true)!='www.example.org')){
			echo "<a href='http://" . get_post_meta($facstaff_posts->ID, 'facstaffwebsite',true) . "'><i class='fa fa-globe'></i></a>";
		}		
		
		if ( $twitter = get_post_meta($facstaff_posts->ID, 'facstafftwitter',true) && (get_post_meta($facstaff_posts->ID, 'facstafftwitter',true)!="twitterusername")){
			echo "<a href='http://twitter.com/" . get_post_meta($facstaff_posts->ID, 'facstafftwitter',true) . "'><i class='fa fa-twitter-square'></i></a>";
		}
		
		if ( $linkedin = get_post_meta($facstaff_posts->ID, 'facstafflinkedin',true) && (get_post_meta($facstaff_posts->ID, 'facstafflinkedin',true)!='linkedinusername')){
			echo "<a href='http://www.linkedin.com/in/" . get_post_meta($facstaff_posts->ID, 'facstafflinkedin',true) . "'><i class='fa fa-linkedin-square'></i></a>";
		}
				
		echo '</div><h4><a href="'.get_permalink($facstaff_posts->ID).'" style="text-decoration:none">'.get_the_title( $facstaff_posts->ID ).'</a>'. "</h4>";
		
		echo get_post_meta($facstaff_posts->ID, 'facstafftitle',true) . "<br>";
		echo get_post_meta($facstaff_posts->ID,'facstaffofficelocation',true) . "<br><br>";
		echo get_post_meta($facstaff_posts->ID,'facstaffnotes',true) . "<br/><br/>"; 
		echo the_content(); 

	$i++;
	echo "</div>";
	}; //For each end 
echo "</section>";
}; //Have posts end
?>
<script>
jQuery.noConflict();
jQuery(document).ready(function () {    
        var $sameHeightDivs = jQuery('.fsentry');
        var maxHeight = 0;
        
        $sameHeightDivs.each(function() {

            maxHeight = Math.max(maxHeight, jQuery(this).outerHeight());

        });

        $sameHeightDivs.css({ height: maxHeight + 'px' });
});
</script>
