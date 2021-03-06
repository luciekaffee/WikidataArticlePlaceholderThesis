<?php

namespace ArticlePlaceholder\Tests;

use ArticlePlaceholder\PropertyOrderProvider;
use Title;
use WikiPage;
use WikitextContent;
use MediaWikiTestCase;

/**
 * @covers ArticlePlaceholder\PropertyOderProvider
 * @group ArticlePlaceholder
 * @group Database
 *
 * @licence GNU GPL v2+
 * @author Lucie-Aimée Kaffee
 */
class PropertyOrderProviderTest extends MediaWikiTestCase {

	public function provideGetPropertyOrder() {
		return array(
			'simple match' => array(
				"* P1 \n"
				. "*P133 \n"
				. "* p5", // Testing for lower case property IDs
				array( 'P1' => 0, 'P133' => 1, 'P5' => 2 )
			),
			'strip multiline comment' => array(
				"* P1 \n"
				. "<!-- * P133 \n"
				. "* P5 -->",
				array( 'P1' => 0 )
			),
			'muliple comments' => array(
				"* P1 \n"
				. "<!-- * P133 --> \n"
				. "* <!-- P5 -->",
				array( 'P1' => 0 )
			),
			'bullet point glibberish' => array(
				"* P1 \n"
				. "* P133 \n"
				. "* P5 Unicorns are all \n"
				. "*  very beautiful!"
				. "** This is a subheading",
				array( 'P1' => 0, 'P133' => 1, 'P5' => 2 )
			),
			'additional text' => array(
				"* P1 \n"
				. "* P133 \n"
				. "* P5 Unicorns are all \n"
				. "very beautiful!",
				array( 'P1' => 0, 'P133' => 1, 'P5' => 2 )
			),
		);
	}

	/**
	 * @dataProvider provideGetPropertyOrder
	 */
	public function testGetPropertyOrder( $text, $expected ) {
		$instance = new PropertyOrderProvider();
		$this->makeWikiPage( 'MediaWiki:Wikibase-SortedProperties', $text );
		$propertyOrder = $instance->getPropertyOrder();
		$this->assertEquals( $expected, $propertyOrder );
	}

	private function makeWikiPage( $name, $text ) {
		$title = Title::newFromText( $name );
		$wikiPage = WikiPage::factory( $title );
		$wikiPage->doEditContent( new WikitextContent( $text ), 'test' );
	}

}
