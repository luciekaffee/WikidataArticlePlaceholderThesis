<?php

namespace ArticlePlaceholder;

use ArticlePlaceholder\PropertyOrderProvider;

class ArticlePlaceholderServices {

	private static $instance = null;

	/**
	 * @return ArticlePlaceholderServices
	 */
	public static function getInstance() {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * @return PropertyOrderProvider
	 */
	public function getPropertyOrderProvider() {
		return new PropertyOrderProvider();
	}
}
