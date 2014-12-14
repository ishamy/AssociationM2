<?php
function fsdirectory_register_settings() {
	add_option( 'fsdirectory_sortstyle', 'Creation Date');
	add_option( 'fsdirectory_displaystyle', 'One Column');
	add_option( 'fsdirectory_hidethumbnail', 'No');
	add_option( 'fsdirectory_stylethumbnail', 'Yes');
	register_setting( 'fssettings', 'fsdirectory_sortstyle' ); 
	register_setting( 'fssettings', 'fsdirectory_displaystyle' ); 
	register_setting( 'fssettings', 'fsdirectory_hidethumbnail');
	register_setting( 'fssettings', 'fsdirectory_stylethumbnail');
	register_setting( 'fssettings', 'fsdirectory_sortstyle' ); 
} 
add_action( 'admin_init', 'fsdirectory_register_settings' );

add_filter( 'plugin_action_links', 'fsdirectory_settings_plugin_link', 10, 2 );
function fsdirectory_settings_plugin_link( $links, $file ){
    $in = '<a href="options-general.php?page=fsdirectory-options">' . __('Settings','mtt') . '</a>';
    array_unshift($links, $in);
	return $links;
}
 
function fsdirectory_register_options_page() {
	add_options_page('Faculty and Staff Directory', 'FSDirectory', 'manage_options', 'fsdirectory-options', 'fsdirectory_options_page');
}
add_action('admin_menu', 'fsdirectory_register_options_page');
function fsdirectory_options_page() {
	?>
<div class="wrap">
	<?php screen_icon(); ?>
	<h2>Faculty/Staff Directory Settings</h2>
	<form method="post" action="options.php"> 
        <?php settings_fields('fssettings'); ?>
        <?php $options = get_option('fssettings'); ?>
		<h3>Directory Sorting and Display</h3>
			<p>Multiple sorting and display options are available. Please choose the ones you'd like to use.</p>
			<small><em>Note that one and two column display layouts work best with a full width page template (no sidebar).  The three column layout will look best when directory entries are of similar size.</em></small>
			<p><em><small>Profile photo preference is ignored if you're using the simple list template.</small></em></p>
			<?php $url = admin_url( 'export.php');?>
			<p><a href="<?php echo $url;?>">Download your profile entries as XML</a></p><br/>
			<small><em>Note that two and three column display layouts work best with a full width page template (no sidebar). Using either of these layouts with a sidebar in place may prevent one or more columns from displaying.</em></small>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="fsdirectory_displaystyle">Display Style:</label></th>
					<td>
						<select name="fsdirectory_displaystyle">
							<option value="One Column" <?php if(get_option('fsdirectory_displaystyle')=='One Column'){echo " selected='selected' ";}?>>One Column</option>
							<option value="Two Column" <?php if(get_option('fsdirectory_displaystyle')=='Two Column'){echo " selected='selected' ";}?>>Two Column</option>
							<option value="Three Column" <?php if(get_option('fsdirectory_displaystyle')=='Three Column'){echo " selected='selected' ";}?>>Three Column</option>
							<option value="Simple List" <?php if(get_option('fsdirectory_displaystyle')=='Simple List'){echo " selected='selected' ";}?>>Simple List</option>
							<option value="By Category" <?php if(get_option('fsdirectory_displaystyle')=='By Category'){echo " selected='selected' ";}?>>By Category</option>
							<!--<option value="hCard List" <?php if(get_option('fsdirectory_displaystyle')=='hCard List'){echo " selected='selected' ";}?>>hCard/vCard Compliant List</option>-->
						</select>
						
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="fssettings[fsdirectory_sortstyle]">Sort By:</label></th>
					<td>
						<select name="fsdirectory_sortstyle">
							<option value="Alphabetical" <?php if(get_option('fsdirectory_sortstyle')=='Alphabetical'){echo " selected='selected' ";}?>>Alphabetical</option>
							<option value="Sort Order" <?php if(get_option('fsdirectory_sortstyle')=='Sort Order'){echo " selected='selected' ";}?>>Sort Order</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="fssettings[fsdirectory_hidethumbnail]">Hide default profile image:</label>
					</th>
					<td>
						<select name="fsdirectory_hidethumbnail">
							<option value="No" <?php if(get_option('fsdirectory_hidethumbnail')=='No'){echo " selected='selected' ";}?>>No</option>
							<option value="Yes" <?php if(get_option('fsdirectory_hidethumbnail')=='Yes'){echo " selected='selected' ";}?>>Yes</option>
						</select>
					</td>
				</tr>	
				<tr valign="top">
					<th scope="row"><label for="fssettings[fsdirectory_stylethumbnail]">Apply CSS skin to thumbnails:</label>
					</th>
					<td>
						<select name="fsdirectory_stylethumbnail">
							<option value="No" <?php if(get_option('fsdirectory_stylethumbnail')=='No'){echo " selected='selected' ";}?>>No</option>
							<option value="Yes" <?php if(get_option('fsdirectory_stylethumbnail')=='Yes'){echo " selected='selected' ";}?>>Yes</option>
						</select>
					</td>
				</tr>								
			</table>
		<?php submit_button(); ?>
	</form>
</div>
<?php
}
?>