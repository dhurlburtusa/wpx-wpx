<?php

declare( strict_types = 1 );

require_once __DIR__ . '/../setup.php';

require_once __DIR__ . '/../../../src/WpConfig.php';

use PHPUnit\Framework\TestCase;

// use Wpx\Wpx\v0\WpConfig;

final class WpConfigTest extends TestCase {

	protected function setUp(): void {
	}

	public function test_WpConfig_has_configure_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpConfig', 'configure' ) );
	}

	public function test_WpConfig_has_configure_autop_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpConfig', 'configure_autop' ) );
	}

	public function test_WpConfig_has_configure_blog_feed_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpConfig', 'configure_blog_feed' ) );
	}

	public function test_WpConfig_has_configure_capital_p_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpConfig', 'configure_capital_p' ) );
	}

	public function test_WpConfig_has_configure_emojis_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpConfig', 'configure_emojis' ) );
	}

	public function test_WpConfig_has_configure_heartbeat_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpConfig', 'configure_heartbeat' ) );
	}

	public function test_WpConfig_has_configure_oembed_provider_support_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpConfig', 'configure_oembed_provider_support' ) );
	}

	public function test_WpConfig_has_configure_plugin_and_theme_editors_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpConfig', 'configure_plugin_and_theme_editors' ) );
	}

	public function test_WpConfig_has_configure_post_autosave_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpConfig', 'configure_post_autosave' ) );
	}

	public function test_WpConfig_has_configure_post_revisions_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpConfig', 'configure_post_revisions' ) );
	}

	public function test_WpConfig_has_configure_rest_api_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpConfig', 'configure_rest_api' ) );
	}

	public function test_WpConfig_has_configure_self_pinging_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpConfig', 'configure_self_pinging' ) );
	}

	public function test_WpConfig_has_configure_texturization_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpConfig', 'configure_texturization' ) );
	}

	public function test_WpConfig_has_configure_trash_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpConfig', 'configure_trash' ) );
	}

	public function test_WpConfig_has_configure_wp_cron_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpConfig', 'configure_wp_cron' ) );
	}

	public function test_WpConfig_has_configure_wp_db_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpConfig', 'configure_wp_db' ) );
	}

	public function test_WpConfig_has_configure_wp_http_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpConfig', 'configure_wp_http' ) );
	}

	public function test_WpConfig_has_configure_xmlrpc_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpConfig', 'configure_xmlrpc' ) );
	}

	public function test_WpConfig_has_enable_text_widget_shortcodes_method(): void {
		$this->assertEquals( true, \method_exists( 'Wpx\Wpx\v0\WpConfig', 'enable_text_widget_shortcodes' ) );
	}

}
