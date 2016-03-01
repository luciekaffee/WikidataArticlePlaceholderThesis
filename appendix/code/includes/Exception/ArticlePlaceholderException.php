<?php

namespace ArticlePlaceholder;

use Exception;
use RunTimeException;

/**
 * @licence GNU GPL v2+
 * @author Lucie-Aimée Kaffee
 */
class ArticlePlaceholderException extends RuntimeException {

	public function __construct(
		$message = 'ArticlePlaceholder Exception',
		$code = 0, Exception $previous = null
	) {
		parent::__construct( $message, $code, $previous );
	}

}
