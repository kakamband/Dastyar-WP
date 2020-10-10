<?php

if(stripcslashes( get_option( 'mbwp_heartbeat' ) )=='1'){

	//Disable Heartbeat
	add_action( 'init', 'stop_heartbeat', 1 );
	function stop_heartbeat() {
		wp_deregister_script('heartbeat');
	}
}
if(stripcslashes( get_option( 'mbwp_shortlink' ) )=='1'){

	//delete shortlink
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
}
if(stripcslashes( get_option( 'mbwp_pingback' ) )=='1'){

	//Disable Self Pingback
	function disable_pingback( &$links ) {
		foreach ( $links as $l => $link )
			if ( 0 === strpos( $link, get_option( 'home' ) ) )
				unset($links[$l]);
	}
	add_action( 'pre_ping', 'disable_pingback' );
}
if(stripcslashes( get_option( 'mbwp_xml_rpc' ) )=='1'){

	//Disable XML-RPC
	add_filter('xmlrpc_enabled', '__return_false');

	
}
if(stripcslashes( get_option( 'mbwp_remove_qurey_string' ) )=='1'){

	//Remove Query Strings
	
	function remove_cssjs_ver( $src ) {
		if( strpos( $src, '?ver=' ) )
			$src = remove_query_arg( 'ver', $src );
			return $src;
		}
		add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
		add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );
	
	}
if(stripcslashes( get_option( 'mbwp_hide_wp' ) )=='1'){

	//Hide WordPress Version
	remove_action( 'wp_head', 'wp_generator' ) ;
}

if(stripcslashes( get_option( 'mbwp_dns_prefetch' ) )=='1'){

	//DNS Prefetch

	if( ! function_exists( 'wphelp_dns_prefetch' ) ) {
		function wphelp_dns_prefetch(){
			if ( is_singular() ) { 
					  echo '<link rel="prefetch" href="' .esc_url( home_url() ) . '">';               
					   echo '<link rel="prerender" href="' .esc_url( home_url() ) . '">';             
			}
		}
	}
	add_action('wp_head', 'wphelp_dns_prefetch');

}
if(stripcslashes( get_option( 'mbwp_contact_form' ) )=='1'){

	//Disable Contact Form 7 JS/CSS
	add_filter( 'wpcf7_load_js', '__return_false' );
	add_filter( 'wpcf7_load_css', '__return_false' );

}

if(stripcslashes( get_option( 'mbwp_mbeds' ) )=='1'){
	
	//Disable Embeds
	function disable_embed(){
	wp_dequeue_script( 'wp-embed' );
	}
	add_action( 'wp_footer', 'disable_embed' );

}

if(stripcslashes( get_option( 'mbwp_WLManifest' ) )=='1'){

	//Remove WLManifest Link
	remove_action( 'wp_head', 'wlwmanifest_link' ) ;

}
if(stripcslashes( get_option( 'mbwp_Remove_JQuery' ) )=='1'){

	//Remove JQuery Migrate
	function deregister_qjuery() { 
		if ( !is_admin() ) {
			wp_deregister_script('jquery');
		}
	} 
	add_action('wp_enqueue_scripts', 'deregister_qjuery');

}

if(stripcslashes( get_option( 'mbwp_dashicons' ) )=='1'){

	//Disable Dashicons on Front-end
	function wpdocs_dequeue_dashicon() {
			if (current_user_can( 'update_core' )) {
				return;
			}
			wp_deregister_style('dashicons');
	}
	add_action( 'wp_enqueue_scripts', 'wpdocs_dequeue_dashicon' );

}

if(stripcslashes( get_option( 'mbwp_remove_url_comment' ) )=='1'){

	//Remove URL field from your Comment Form

	function wphelp_disable_comment_url($fields) { 
		unset($fields['url']);
		return $fields;
	}
	add_filter('comment_form_default_fields','wphelp_disable_comment_url');

}

if(stripcslashes( get_option( 'mbwp_disable_acf' ) )=='1'){

	// disable acf css on front-end
	add_action( 'wp_enqueue_style', 'wphelp_deregister_styles', 100 );
	  
	function wphelp_deregister_styles() {
	 if( ! is_admin() ) {
	  wp_deregister_style( 'acf' );
	  wp_deregister_style( 'acf-field-group' );
	  wp_deregister_style( 'acf-global' );
	  wp_deregister_style( 'acf-input' );
	  wp_deregister_style( 'acf-datepicker' );
	 }
	}

}
if(stripcslashes( get_option( 'mbwp_search' ) )=='1'){

	//Disable WordPress Search

	function wphelp_filter_query( $query, $error = true ) {
	if ( is_search() ) {
	$query->is_search = false;
	$query->query_vars[s] = false;
	$query->query[s] = false;
	// to error
	if ( $error == true )
	$query->is_404 = true;
	}
	}
	add_action( 'parse_query', 'wphelp_filter_query' );
	add_filter( 'get_search_form', create_function( '$a', "return null;" ) );

}



if(stripcslashes(get_option('mbwp_preload_fonts'))){
	

		$fonts=explode("\n",stripcslashes(get_option('mbwp_preload_fonts')));
	
		$fonts = (array) apply_filters( 'rocket_preload_fonts', $fonts );
		$fonts = array_filter( $fonts );

		if ( empty( $fonts ) ) {
			return;
		}

		$base_url = ( home_url() );
		
		//$base_url = "{$base_url['scheme']}://{$base_url['host']}";

		foreach ( array_unique( $fonts ) as $font ) {
			
			printf(
				"\n<link rel=\"preload\" as=\"font\" href=\"%s\" crossorigin>",
				esc_url( ( $base_url . $font ) )

			);
		
		
	}
}



?>