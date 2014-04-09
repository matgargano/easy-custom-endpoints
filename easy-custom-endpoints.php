<?php

/*
Plugin Name: Easy custom endpoints
Plugin URI: http://matgargano.com
Description: Let's make some simple endpoints
Author: Mat Gargano
Version: 0.1
Author URI: http://matgargano.com
*/

class Custom_Endpoint {
	protected $custom_endpoint;
	protected $template; 
	protected $query_variables;

	public function __construct( $custom_endpoint ){
		$this->custom_endpoint = $custom_endpoint;
		add_filter( 'query_vars', array( $this, 'query_vars' ) );
		add_action( 'init', array( $this, 'add_rewrite_rule' ) );
		add_action( 'pre_get_posts', array( $this, 'query_variables' ) );
		add_action( 'template_redirect', array( $this, 'template_redirect' ) );
	}

	public function query_vars( $vars ){
		$vars[] = $this->custom_endpoint;
		return $vars; 
	}

	public function set_template( $location ){
		$this->template = $location;

	}

	public function add_rewrite_rule(){
		add_rewrite_rule('(' . $this->custom_endpoint . ')$', 'index.php?' . $this->custom_endpoint . '=true', 'top');
	}

	public function set_query_variables( $array ){
		if ( is_array( $array ) ) {
			$this->query_variables = $array;
		}

	}

	public function query_variables( $query ){
		if ( ! is_array( $this->query_variables ) ) {
			return;
		}
		foreach( $this->query_variables as $key => $val ){
			$query->set( $key, $val );
		}
		return $query;
	}

	public function template_redirect(){
		$this->template = apply_filters( 'ce-' . $this->custom_endpoint . '-template', $this->template );
		if ( ! $this->template ) {
			return;
		}
		$custom_page = get_query_var( $this->custom_endpoint );
		$custom_page_value = filter_var($custom_page, FILTER_VALIDATE_BOOLEAN);
		if ( $custom_page_value == 'true' ){
			include($this->template);
			die;
		}
	}
}

