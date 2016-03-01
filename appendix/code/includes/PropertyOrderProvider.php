<?php

namespace ArticlePlaceholder;

use ArticlePlaceholder\ArticlePlaceholderException;
use WikiPage;
use Title;
use TextContent;

/**
 * Provides a list of ordered Property numbers
 *
 * @license GNU GPL v2+
 * @author Lucie-Aimée Kaffee
 */
class PropertyOrderProvider {

	const PAGENAME = 'MediaWiki:Wikibase-SortedProperties';

	/**
	 * @return int[]
	 * Get order of properties in the form [PropertyId] -> [Ordinal number]
	 */
	public function getPropertyOrder() {
		$pageContent = $this->getSortedPropertiesPageContent();
		$parsedList = $this->parseList( $pageContent );
		return array_flip( $parsedList );
	}

	/**
	 * Get Content of MediaWiki:Wikibase-SortedProperties
	 * @return string|null
	 * @throws ArticlePlaceholderException
	 */
	private function getSortedPropertiesPageContent() {
		$title = Title::newFromText( self::PAGENAME );
		if ( !$title ) {
			throw new ArticlePlaceholderException( 'Not able to get a title' );
		}
		$wikiPage = WikiPage::factory( $title );
		if ( !$wikiPage ) {
			throw new ArticlePlaceholderException( 'Not able to get the Wikipage' );
		}
		$pageContent = $wikiPage->getContent();
		if ( !$pageContent ) {
			throw new ArticlePlaceholderException( 'Not able to get page content' );
		}
		if ( !( $pageContent instanceof TextContent ) ) {
			throw new ArticlePlaceholderException( 'The page content is not TextContent' );
		}

		return $pageContent->getNativeData();
	}

	/**
	 * @param string $pageContent
	 * @return string[]
	 */
	private function parseList( $pageContent ) {
		$orderedProperties = array();
		$orderedPropertiesMatches = array();

		$pageContent = preg_replace( '@<!--.*?-->@s', '', $pageContent );
		preg_match_all(
			'@^\*\s*([Pp]\d+)@m',
			$pageContent,
			$orderedPropertiesMatches,
			PREG_PATTERN_ORDER
		);
		$orderedProperties = array_map( 'strtoupper', $orderedPropertiesMatches[1] );

		return $orderedProperties;
	}

}
