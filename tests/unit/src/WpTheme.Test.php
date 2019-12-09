<?php

declare( strict_types = 1 );

require_once __DIR__ . '/../setup.php';

require_once __DIR__ . '/../../../src/WpTheme.php';

use PHPUnit\Framework\TestCase;

// use Wpx\Wpx\v0\WpTheme;

final class WpThemeTest extends TestCase {

	protected function setUp(): void {
	}

	public function test_WpTheme_has_determine_template_candidates_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpTheme', 'determine_template_candidates' ) );
	}

}
