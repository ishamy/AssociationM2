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
wp_enqueue_style( 'facstaff-style', plugins_url('../css/faculty-staff-style-override.css', __FILE__) );
wp_enqueue_style( 'facstaff-style', plugins_url('../css/faculty-staff-styles.css', __FILE__) );
wp_enqueue_style( 'font-awesome-style', plugins_url('../assets/font-awesome/css/font-awesome.min.css', __FILE__) );

echo "<ul id='fsprofile_list'>";

foreach ( $facstaff_posts as $facstaff_posts ) {
$post_thumbnail_id = get_post_thumbnail_id($facstaff_posts->ID, array(100,100));
$thumb_src = wp_get_attachment_url( $post_thumbnail_id );
setup_postdata($facstaff_posts);
?>	
<li id="fsprofilecontainer">
	<strong><span id="fsname"><?php 
	echo '<a href="'.get_permalink($facstaff_posts->ID).'">'.get_the_title($facstaff_posts->ID).'</a><br>';?>
	
	<?php if ( $phone = get_post_meta($facstaff_posts->ID, 'facstaffphone',true) && (get_post_meta($facstaff_posts->ID, 'facstaffphone',true) != "123-345-4532")){ ?>
	<a id="fsphone" href="tel:<?php echo get_post_meta($facstaff_posts->ID, 'facstaffphone',true); ?>"><i class="fa fa-phone-square"></i></a>
	<?php }?>
	<?php if ( $web = get_post_meta($facstaff_posts->ID, 'facstaffemail',true) && (get_post_meta($facstaff_posts->ID, 'facstaffemail',true)!="user@domain.com")){ ?>
	<a id="fsemail"href="mailto:<?php echo get_post_meta($facstaff_posts->ID, 'facstaffemail',true); ?>"><i class="fa fa-envelope-square"></i></a>
	<?php } ?>
	<?php if ( $web = get_post_meta($facstaff_posts->ID, 'facstaffwebsite',true) && (get_post_meta($facstaff_posts->ID, 'facstaffwebsite',true)!="www.example.org")){ ?>
	<a id="fswebsite" href="http://<?php echo get_post_meta($facstaff_posts->ID, 'facstaffwebsite',true); ?>"><i class="fa fa-globe"></i></a>
	<?php }			
	if ( $twitter = get_post_meta($facstaff_posts->ID, 'facstafftwitter',true) && (get_post_meta($facstaff_posts->ID, 'facstafftwitter',true)!="twitterusername")){ ?>
	<a id="fstwitter" href="http://twitter.com/<?php echo get_post_meta($facstaff_posts->ID, 'facstafftwitter',true); ?>"><i class="fa fa-twitter-square"></i></a>
	<?php }
	if ( $linkedin = get_post_meta($facstaff_posts->ID, 'facstafflinkedin',true) && (get_post_meta($facstaff_posts->ID, 'facstafflinkedin',true)!="linkedinusername")){ ?>
	<a id="fslinkedin" href="http://www.linkedin.com/in/<?php echo get_post_meta($facstaff_posts->ID, 'facstafflinkedin',true); ?>"><i class="fa fa-linkedin-square"></i></a><br/>
	<?php 
	}?>	
	<br>	
	<?php if ( $officelocation = get_post_meta($facstaff_posts->ID, 'facstaffofficelocation',true) && (get_post_meta($facstaff_posts->ID,'facstaffofficelocation',true) != 'Ex: Smith Hall 302')){ ?>
	<?php echo "<span id='fsofficelocation'>" . get_post_meta($facstaff_posts->ID,'facstaffofficelocation',true) . "</span><br><br>"; }?>
	<?php echo the_content();?>
	<?php if ($facstaffnotes = get_post_meta($facstaff_posts->ID, 'facstaffnotes',true) && (get_post_meta($facstaff_posts->ID,'facstaffnotes',true) != '')){ ?>
	<?php echo "<span id='fsnotes'>" . get_post_meta($facstaff_posts->ID,'facstaffnotes',true) . "</span>"; }?>
</li>
<hr>
<?php 
}; 
}; 
?>
</ul>
