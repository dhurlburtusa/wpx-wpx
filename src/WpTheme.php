<?php

namespace Wpx\Wpx\v0;

require_once __DIR__ . '/bootstrap.php';

if ( ! \class_exists( __NAMESPACE__ . '\WpTheme' ) ) {

	class WpTheme {

		/**
		* Sets up theme support.
		*
		* // TODO: Document parameter.
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function add_theme_support ( $theme_support ) {
			$final_theme_support = $theme_support;

			$feature = 'align-wide';
			if ( isset( $final_theme_support[$feature] ) ) {
				if ( $final_theme_support[$feature] === true ) {
					\add_theme_support( $feature );
				}
				else if ( $final_theme_support[$feature] === false ) {
					\remove_theme_support( $feature );
				}
			}

			$feature = 'automatic-feed-links';
			if ( isset( $final_theme_support[$feature] ) ) {
				if ( $final_theme_support[$feature] === true ) {
					\add_theme_support( $feature );
				}
				else if ( $final_theme_support[$feature] === false ) {
					\remove_theme_support( $feature );
				}
			}

			$feature = 'custom-background';
			if ( isset( $final_theme_support[$feature] ) ) {
				$support = $final_theme_support[$feature];
				if ( $support === true ) {
					\remove_theme_support( $feature );
					\add_theme_support( $feature );
				}
				else if ( $support === false ) {
					\remove_theme_support( $feature );
				}
				else if ( is_array( $support ) ) {
					\remove_theme_support( $feature );
					\add_theme_support( $feature, $support );
				}
			}

			$feature = 'custom-header';
			if ( isset( $final_theme_support[$feature] ) ) {
				$support = $final_theme_support[$feature];
				if ( $support === true ) {
					\remove_theme_support( $feature );
					\add_theme_support( $feature );
				}
				else if ( $support === false ) {
					\remove_theme_support( $feature );
				}
				else if ( is_array( $support ) ) {
					\remove_theme_support( $feature );
					\add_theme_support( $feature, $support );
				}
			}

			$feature = 'custom-logo';
			if ( isset( $final_theme_support[$feature] ) ) {
				$support = $final_theme_support[$feature];
				if ( $support === true ) {
					\remove_theme_support( $feature );
					\add_theme_support( $feature );
				}
				else if ( $support === false ) {
					\remove_theme_support( $feature );
				}
				else if ( is_array( $support ) ) {
					\remove_theme_support( $feature );
					\add_theme_support( $feature, $support );
				}
			}

			$feature = 'customize-selective-refresh-widgets';
			if ( isset( $final_theme_support[$feature] ) ) {
				if ( $final_theme_support[$feature] === true ) {
					\add_theme_support( $feature );
				}
				else if ( $final_theme_support[$feature] === false ) {
					\remove_theme_support( $feature );
				}
			}

			$feature = 'dark-editor-style';
			if ( isset( $final_theme_support[$feature] ) ) {
				if ( $final_theme_support[$feature] === true ) {
					\add_theme_support( $feature );
				}
				else if ( $final_theme_support[$feature] === false ) {
					\remove_theme_support( $feature );
				}
			}

			$feature = 'disable-custom-colors';
			if ( isset( $final_theme_support[$feature] ) ) {
				if ( $final_theme_support[$feature] === true ) {
					\add_theme_support( $feature );
				}
				else if ( $final_theme_support[$feature] === false ) {
					\remove_theme_support( $feature );
				}
			}

			$feature = 'disable-custom-font-sizes';
			if ( isset( $final_theme_support[$feature] ) ) {
				if ( $final_theme_support[$feature] === true ) {
					\add_theme_support( $feature );
				}
				else if ( $final_theme_support[$feature] === false ) {
					\remove_theme_support( $feature );
				}
			}

			$feature = 'editor-color-palette';
			if ( isset( $final_theme_support[$feature] ) ) {
				if ( is_array( $final_theme_support[$feature] ) ) {
					\remove_theme_support( $feature );
					\add_theme_support( $feature, $final_theme_support[$feature] );
				}
				else if ( $final_theme_support[$feature] === false ) {
					\remove_theme_support( $feature );
				}
			}

			$feature = 'editor-font-sizes';
			if ( isset( $final_theme_support[$feature] ) ) {
				if ( is_array( $final_theme_support[$feature] ) ) {
					\remove_theme_support( $feature );
					\add_theme_support( $feature, $final_theme_support[$feature] );
				}
				else if ( $final_theme_support[$feature] === false ) {
					\remove_theme_support( $feature );
				}
			}

			$feature = 'editor-styles';
			if ( isset( $final_theme_support[$feature] ) ) {
				if ( $final_theme_support[$feature] === true ) {
					\add_theme_support( $feature );
				}
				else if ( $final_theme_support[$feature] === false ) {
					\remove_theme_support( $feature );
				}
			}

			$feature = 'html5';
			if ( isset( $final_theme_support[$feature] ) ) {
				if ( is_array( $final_theme_support[$feature] ) ) {
					\remove_theme_support( $feature );
					\add_theme_support( $feature, $final_theme_support[$feature] );
				}
				else if ( $final_theme_support[$feature] === false ) {
					\remove_theme_support( $feature );
				}
			}

			$feature = 'menus';
			if ( isset( $final_theme_support[$feature] ) ) {
				if ( is_array( $final_theme_support[$feature] ) ) {
					\remove_theme_support( $feature );
					\register_nav_menus( $final_theme_support[$feature] );
				}
				else if ( $final_theme_support[$feature] === false ) {
					\remove_theme_support( $feature );
				}
			}

			$feature = 'post-formats';
			if ( isset( $final_theme_support[$feature] ) ) {
				$support = $final_theme_support[$feature];
				if ( $support === true ) {
					\add_theme_support( $feature );
				}
				else if ( $support === false ) {
					\remove_theme_support( $feature );
				}
				else if ( is_array( $support ) ) {
					\add_theme_support( $feature, $support );
				}
			}

			$feature = 'post-thumbnails';
			if ( isset( $final_theme_support[$feature] ) ) {
				$support = $final_theme_support[$feature];
				if ( $support === true ) {
					\add_theme_support( $feature );
				}
				else if ( $support === false ) {
					\remove_theme_support( $feature );
				}
				else if ( is_array( $support ) ) {
					// Removing any previously set post type support in order to set the support,
					// not just add additional post type support.
					\remove_theme_support( $feature );
					\add_theme_support( $feature, $support );
				}
			}

			$feature = 'responsive-embeds';
			if ( isset( $final_theme_support[$feature] ) ) {
				if ( $final_theme_support[$feature] === true ) {
					\add_theme_support( $feature );
				}
				else if ( $final_theme_support[$feature] === false ) {
					\remove_theme_support( $feature );
				}
			}

			$feature = 'starter-content';
			if ( isset( $final_theme_support[$feature] ) ) {
				if ( is_array( $final_theme_support[$feature] ) ) {
					\remove_theme_support( $feature );
					\add_theme_support( $feature, $final_theme_support[$feature] );
				}
				else if ( $final_theme_support[$feature] === false ) {
					\remove_theme_support( $feature );
				}
			}

			$feature = 'title-tag';
			if ( isset( $final_theme_support[$feature] ) ) {
				if ( $final_theme_support[$feature] === true ) {
					\add_theme_support( $feature );
				}
				else if ( $final_theme_support[$feature] === false ) {
					\remove_theme_support( $feature );
				}
			}

			$feature = 'wp-block-styles';
			if ( isset( $final_theme_support[$feature] ) ) {
				if ( $final_theme_support[$feature] === true ) {
					\add_theme_support( $feature );
				}
				else if ( $final_theme_support[$feature] === false ) {
					\remove_theme_support( $feature );
				}
			}

			$feature = 'widgets';
			if ( isset( $final_theme_support[$feature] ) ) {
				if ( is_array( $final_theme_support[$feature] ) ) {
					\add_action( 'widgets_init', function () use ( $feature, $final_theme_support ) {
						\remove_theme_support( $feature );
						foreach ( $final_theme_support[$feature] as $widget ) {
							\register_sidebar($widget);
						}
					} );
				}
				else if ( $final_theme_support[$feature] === false ) {
					\remove_theme_support( $feature );
				}
			}
		}

		/**
		* Sets up theme defaults and registers support for various WordPress features.
		*
		* Note that this function is hooked into the after_setup_theme hook, which
		* runs before the init hook. The init hook is too late for some features, such
		* as indicating support for post thumbnails.
		*
		* @see https://codex.wordpress.org/Theme_Features
		*
		* // TODO: Document parameter.
		*/
		public static function configure ( $config = array() ) {

			// $content_width = $config['content_width'];
			// $GLOBALS['content_width'] = apply_filters( 'wpx_wpx_v0__content_width', $content_width );

			// $editor_style = $config['editor_style'];


			add_action( 'after_setup_theme', function () use ( $config ) {
				if ( \is_array( $config['styles'] ) ) {
					foreach ( $config['styles'] as $style ) {
						$handle = $style['handle'];
						$src = $style['src'];
						$deps = \is_array( $style['deps'] ) ? $style['deps'] : array();
						$ver = isset( $style['ver'] ) ? $style['ver'] : false;
						$media = isset( $style['media'] ) ? $style['media'] : 'all';
						\wp_register_style( $handle, $src, $deps, $ver, $media );
					}
				}

				if ( \is_array( $config['scripts'] ) ) {
					foreach ( $config['scripts'] as $script ) {
						$handle = $script['handle'];
						$src = $script['src'];
						$data = \is_array( $script['data'] ) ? $script['data'] : array();
						$deps = \is_array( $script['deps'] ) ? $script['deps'] : array();
						$in_head = isset( $script['in_head'] ) ? $script['in_head'] : false;
						$ver = isset( $script['ver'] ) ? $script['ver'] : false;
						\wp_register_script( $handle, $src, $deps, $ver, ! $in_head );

						foreach ( $data as $key => $value ) {
							\wp_script_add_data( $handle, $key, $value );
						}
					}
				}

				if ( \is_array( $config['textdomain'] ) && isset( $config['textdomain']['domain'] ) ) {
					$textdomain_path = false;
					if ( isset( $config['textdomain']['path'] ) ) {
						$textdomain_path = $config['textdomain']['path'];
					}
					\load_theme_textdomain( $config['textdomain']['domain'], $textdomain_path );
				}

				if ( \is_array( $config['supports'] ) ) {
					$theme_supports = $config['supports'];

					$feature = 'align-wide';
					if ( isset( $theme_supports[$feature] ) ) {
						if ( $theme_supports[$feature] === true ) {
							\add_theme_support( $feature );
						}
						else if ( $theme_supports[$feature] === false ) {
							\remove_theme_support( $feature );
						}
					}

					$feature = 'automatic-feed-links';
					if ( isset( $theme_supports[$feature] ) ) {
						if ( $theme_supports[$feature] === true ) {
							\add_theme_support( $feature );
						}
						else if ( $theme_supports[$feature] === false ) {
							\remove_theme_support( $feature );
						}
					}

					$feature = 'custom-background';
					if ( isset( $theme_supports[$feature] ) ) {
						$support = $theme_supports[$feature];
						if ( $support === true ) {
							\remove_theme_support( $feature );
							\add_theme_support( $feature );
						}
						else if ( $support === false ) {
							\remove_theme_support( $feature );
						}
						else if ( is_array( $support ) ) {
							\remove_theme_support( $feature );
							\add_theme_support( $feature, $support );
						}
					}

					$feature = 'custom-header';
					if ( isset( $theme_supports[$feature] ) ) {
						$support = $theme_supports[$feature];
						if ( $support === true ) {
							\remove_theme_support( $feature );
							\add_theme_support( $feature );
						}
						else if ( $support === false ) {
							\remove_theme_support( $feature );
						}
						else if ( is_array( $support ) ) {
							\remove_theme_support( $feature );
							\add_theme_support( $feature, $support );
						}
					}

					$feature = 'custom-logo';
					if ( isset( $theme_supports[$feature] ) ) {
						$support = $theme_supports[$feature];
						if ( $support === true ) {
							\remove_theme_support( $feature );
							\add_theme_support( $feature );
						}
						else if ( $support === false ) {
							\remove_theme_support( $feature );
						}
						else if ( is_array( $support ) ) {
							\remove_theme_support( $feature );
							\add_theme_support( $feature, $support );
						}
					}

					$feature = 'customize-selective-refresh-widgets';
					if ( isset( $theme_supports[$feature] ) ) {
						if ( $theme_supports[$feature] === true ) {
							\add_theme_support( $feature );
						}
						else if ( $theme_supports[$feature] === false ) {
							\remove_theme_support( $feature );
						}
					}

					$feature = 'dark-editor-style';
					if ( isset( $theme_supports[$feature] ) ) {
						if ( $theme_supports[$feature] === true ) {
							\add_theme_support( $feature );
						}
						else if ( $theme_supports[$feature] === false ) {
							\remove_theme_support( $feature );
						}
					}

					$feature = 'disable-custom-colors';
					if ( isset( $theme_supports[$feature] ) ) {
						if ( $theme_supports[$feature] === true ) {
							\add_theme_support( $feature );
						}
						else if ( $theme_supports[$feature] === false ) {
							\remove_theme_support( $feature );
						}
					}

					$feature = 'disable-custom-font-sizes';
					if ( isset( $theme_supports[$feature] ) ) {
						if ( $theme_supports[$feature] === true ) {
							\add_theme_support( $feature );
						}
						else if ( $theme_supports[$feature] === false ) {
							\remove_theme_support( $feature );
						}
					}

					$feature = 'editor-color-palette';
					if ( isset( $theme_supports[$feature] ) ) {
						if ( is_array( $theme_supports[$feature] ) ) {
							\remove_theme_support( $feature );
							\add_theme_support( $feature, $theme_supports[$feature] );
						}
						else if ( $theme_supports[$feature] === false ) {
							\remove_theme_support( $feature );
						}
					}

					$feature = 'editor-font-sizes';
					if ( isset( $theme_supports[$feature] ) ) {
						if ( is_array( $theme_supports[$feature] ) ) {
							\remove_theme_support( $feature );
							\add_theme_support( $feature, $theme_supports[$feature] );
						}
						else if ( $theme_supports[$feature] === false ) {
							\remove_theme_support( $feature );
						}
					}

					$feature = 'editor-styles';
					if ( isset( $theme_supports[$feature] ) ) {
						if ( $theme_supports[$feature] === true ) {
							\add_theme_support( $feature );
						}
						else if ( $theme_supports[$feature] === false ) {
							\remove_theme_support( $feature );
						}
					}

					$feature = 'html5';
					if ( isset( $theme_supports[$feature] ) ) {
						if ( is_array( $theme_supports[$feature] ) ) {
							\remove_theme_support( $feature );
							\add_theme_support( $feature, $theme_supports[$feature] );
						}
						else if ( $theme_supports[$feature] === false ) {
							\remove_theme_support( $feature );
						}
					}

					$feature = 'menus';
					if ( isset( $theme_supports[$feature] ) ) {
						if ( is_array( $theme_supports[$feature] ) ) {
							\remove_theme_support( $feature );
							\register_nav_menus( $theme_supports[$feature] );
						}
						else if ( $theme_supports[$feature] === false ) {
							\remove_theme_support( $feature );
						}
					}

					$feature = 'post-formats';
					if ( isset( $theme_supports[$feature] ) ) {
						$support = $theme_supports[$feature];
						if ( $support === true ) {
							\add_theme_support( $feature );
						}
						else if ( $support === false ) {
							\remove_theme_support( $feature );
						}
						else if ( is_array( $support ) ) {
							\add_theme_support( $feature, $support );
						}
					}

					$feature = 'post-thumbnails';
					if ( isset( $theme_supports[$feature] ) ) {
						$support = $theme_supports[$feature];
						if ( $support === true ) {
							\add_theme_support( $feature );
						}
						else if ( $support === false ) {
							\remove_theme_support( $feature );
						}
						else if ( is_array( $support ) ) {
							// Removing any previously set post type support in order to set the support,
							// not just add additional post type support.
							\remove_theme_support( $feature );
							\add_theme_support( $feature, $support );
						}
					}

					$feature = 'responsive-embeds';
					if ( isset( $theme_supports[$feature] ) ) {
						if ( $theme_supports[$feature] === true ) {
							\add_theme_support( $feature );
						}
						else if ( $theme_supports[$feature] === false ) {
							\remove_theme_support( $feature );
						}
					}

					$feature = 'starter-content';
					if ( isset( $theme_supports[$feature] ) ) {
						if ( is_array( $theme_supports[$feature] ) ) {
							\remove_theme_support( $feature );
							\add_theme_support( $feature, $theme_supports[$feature] );
						}
						else if ( $theme_supports[$feature] === false ) {
							\remove_theme_support( $feature );
						}
					}

					$feature = 'title-tag';
					if ( isset( $theme_supports[$feature] ) ) {
						if ( $theme_supports[$feature] === true ) {
							\add_theme_support( $feature );
						}
						else if ( $theme_supports[$feature] === false ) {
							\remove_theme_support( $feature );
						}
					}

					$feature = 'wp-block-styles';
					if ( isset( $theme_supports[$feature] ) ) {
						if ( $theme_supports[$feature] === true ) {
							\add_theme_support( $feature );
						}
						else if ( $theme_supports[$feature] === false ) {
							\remove_theme_support( $feature );
						}
					}

					$feature = 'widgets';
					if ( isset( $theme_supports[$feature] ) ) {
						if ( is_array( $theme_supports[$feature] ) ) {
							\add_action( 'widgets_init', function () use ( $feature, $theme_supports ) {
								\remove_theme_support( $feature );
								foreach ( $theme_supports[$feature] as $widget ) {
									\register_sidebar($widget);
								}
							} );
						}
						else if ( $theme_supports[$feature] === false ) {
							\remove_theme_support( $feature );
						}
					}
				}
			} );
		}

		// phpcs:disable Generic.Files.LineLength.MaxExceeded
		/**
		* Determines the response template candidates based on the request.
		*
		* This will return the same list of templates that the WordPress template
		* hierarchy (WTH) would examine if it didn't shortcut on the first found template.
		*
		* The list is ordered with the first template being the first template the WTH
		* would examine.
		*
		* Note: Must be called during or after the `template_redirect` action. Otherwise,
		* the main WP query is not ready.
		*
		* The following is a list of possible return values. Note that all will contain
		* `'index.php'` as the last item.
		*
		* - [ 'front-page.php',             'singular.php', 'index.php' ]
		* - [ 'front-page.php', 'home.php', 'singular.php', 'index.php' ]
		* - [                   'home.php', 'singular.php', 'index.php' ]
		* - [ '{$mimetype}-{$subtype}.php', '{$subtype}.php', '{$mimetype}.php', 'attachment.php', 'singular.php', 'index.php' ]
		* - [                                                 '{$mimetype}.php', 'attachment.php', 'singular.php', 'index.php' ]
		* - [                                                                    'attachment.php', 'singular.php', 'index.php' ]
		* - [ '{page-template}.php', 'single-{$post_type}-{$name_decoded}.php', 'single-{$post_type}-{$post_name}.php', 'single-{$post_type}.php', 'single.php', 'singular.php', 'index.php' ]
		* - [                        'single-{$post_type}-{$name_decoded}.php', 'single-{$post_type}-{$post_name}.php', 'single-{$post_type}.php', 'single.php', 'singular.php', 'index.php' ]
		* - [                                                                   'single-{$post_type}-{$post_name}.php', 'single-{$post_type}.php', 'single.php', 'singular.php', 'index.php' ]
		* - [                                                                                                                                      'single.php', 'singular.php', 'index.php' ]
		* - [ '{page-template}.php', 'page-{$pagename_decoded}.php', 'page-{$pagename}.php', 'page-{$id}.php', 'page.php', 'singular.php', 'index.php' ]
		* - [                        'page-{$pagename_decoded}.php', 'page-{$pagename}.php', 'page-{$id}.php', 'page.php', 'singular.php', 'index.php' ]
		* - [                                                        'page-{$pagename}.php', 'page-{$id}.php', 'page.php', 'singular.php', 'index.php' ]
		* - [                                                                                'page-{$id}.php', 'page.php', 'singular.php', 'index.php' ]
		* - [                                                                                                  'page.php', 'singular.php', 'index.php' ]
		* - [ 'archive-{$post_type}.php', 'archive.php', 'index.php' ]
		* - [ 'taxonomy-{$taxonomy}-{$slug_decoded}.php', 'taxonomy-{$taxonomy}-{$term_slug}.php', 'taxonomy-{$taxonomy}.php', 'taxonomy.php', 'archive.php', 'index.php' ]
		* - [                                             'taxonomy-{$taxonomy}-{$term_slug}.php', 'taxonomy-{$taxonomy}.php', 'taxonomy.php', 'archive.php', 'index.php' ]
		* - [                                                                                                                  'taxonomy.php', 'archive.php', 'index.php' ]
		* - [ 'category-{$slug_decoded}.php', 'category-{$slug}.php', 'category-{$category->term_id}.php', 'category.php', 'archive.php', 'index.php' ]
		* - [                                 'category-{$slug}.php', 'category-{$category->term_id}.php', 'category.php', 'archive.php', 'index.php' ]
		* - [                                                                                              'category.php', 'archive.php', 'index.php' ]
		* - [ 'tag-{$slug_decoded}.php', 'tag-{slug}.php', 'tag-{$tag->term_id}.php', 'tag.php', 'archive.php', 'index.php' ]
		* - [                            'tag-{slug}.php', 'tag-{$tag->term_id}.php', 'tag.php', 'archive.php', 'index.php' ]
		* - [                                                                         'tag.php', 'archive.php', 'index.php' ]
		* - [ 'author-{$author->user_nicename}.php', 'author-{$author->ID}.php', 'author.php', 'archive.php', 'index.php' ]
		* - [                                                                    'author.php', 'archive.php', 'index.php' ]
		* - [ 'date.php', 'archive.php', 'index.php' ]
		* - [ 'search.php', 'index.php' ]
		* - [ 'privacy-policy.php', 'index.php' ]
		* - [ 'embed-{$post_type}-{$post_format}.php', 'embed-{$post_type}.php', 'embed.php', 'index.php' ]
		* - [ '404.php', 'index.php' ]
		*
		* @return string[]
		*/
		// phpcs:enable Generic.Files.LineLength.MaxExceeded
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function determine_template_candidates () {
			static $template_candidates = null;

			if ( \is_null( $template_candidates ) ) {
				$template_candidates = array();
				if ( \is_singular() ) {
					if ( \is_front_page() ) {
						$template_candidates[] = 'front-page.php';

						if ( \is_home() ) {
							$template_candidates[] = 'home.php';
						}
					}
					elseif ( \is_home() ) {
						$template_candidates[] = 'home.php';
					}
					elseif ( \is_attachment() ) {
						$attachment = \get_queried_object();

						if ( $attachment ) {
							if ( false !== \strpos( $attachment->post_mime_type, '/' ) ) {
								list( $mimetype, $subtype ) = \explode( '/', $attachment->post_mime_type );
							} else {
								list( $mimetype, $subtype ) = array( $attachment->post_mime_type, '' );
							}

							if ( ! empty( $subtype ) ) {
								$template_candidates[] = "{$mimetype}-{$subtype}.php";
								$template_candidates[] = "{$subtype}.php";
							}
							$template_candidates[] = "{$mimetype}.php";
						}

						$template_candidates[] = 'attachment.php';
					}
					elseif ( \is_single() ) {
						$object = \get_queried_object();

						$post_type = $object->post_type;

						if ( ! empty( $post_type ) ) {
							$template = \get_page_template_slug( $object );

							if ( $template && 0 === \validate_file( $template ) ) {
								$template_candidates[] = $template;
							}

							$post_name = $object->post_name;
							$name_decoded = \urldecode( $post_name );
							if ( $name_decoded !== $post_name ) {
								$template_candidates[] = "single-{$post_type}-{$name_decoded}.php";
							}

							$template_candidates[] = "single-{$post_type}-{$post_name}.php";
							$template_candidates[] = "single-{$post_type}.php";
						}

						$template_candidates[] = 'single.php';
					}
					elseif ( \is_page() ) {
						$id = \get_queried_object_id();
						$pagename = \get_query_var( 'pagename' );

						if ( ! $pagename && $id ) {
							// If a static page is set as the front page, $pagename will not be set. Retrieve it from the queried object.
							$post = \get_queried_object();
							if ( $post ) {
								$pagename = $post->post_name;
							}
						}

						$template = \get_page_template_slug();

						if ( $template && 0 === \validate_file( $template ) ) {
							$template_candidates[] = $template;
						}

						if ( $pagename ) {
							$pagename_decoded = \urldecode( $pagename );
							if ( $pagename_decoded !== $pagename ) {
								$template_candidates[] = "page-{$pagename_decoded}.php";
							}
							$template_candidates[] = "page-{$pagename}.php";
						}

						if ( $id ) {
							$template_candidates[] = "page-{$id}.php";
						}

						$template_candidates[] = 'page.php';
					}
					$template_candidates[] = 'singular.php';

					$template_candidates[] = 'index.php';

					return $template_candidates;
				}
				else if ( \is_archive() ) {
					$is_post_type_archive = \is_post_type_archive();
					$post_type = null;

					if ( $is_post_type_archive ) {
						$post_type = \get_query_var( 'post_type' );
						if ( \is_array( $post_type ) ) {
							$post_type = \reset( $post_type );
						}
						// I don't think the following 4 lines of code are necessary. It has already been done
						// when `is_post_type_archive` was called.
						$obj = \get_post_type_object( $post_type );
						if ( ! ( $obj instanceof \WP_Post_Type ) || ! $obj->has_archive ) {
							$post_type = null;
						}
					}

					if ( $is_post_type_archive && $post_type ) {
						$template_candidates[] = "archive-{$post_type}.php";
					}
					elseif ( \is_tax() ) {
						$term = \get_queried_object();

						$term_slug = $term->slug;

						if ( ! empty( $term_slug ) ) {
							$taxonomy = $term->taxonomy;

							$slug_decoded = \urldecode( $term_slug );
							if ( $slug_decoded !== $term_slug ) {
								$template_candidates[] = "taxonomy-{$taxonomy}-{$slug_decoded}.php";
							}

							$template_candidates[] = "taxonomy-{$taxonomy}-{$term_slug}.php";
							$template_candidates[] = "taxonomy-{$taxonomy}.php";
						}

						$template_candidates[] = 'taxonomy.php';
					}
					elseif ( \is_category() ) {
						$category = \get_queried_object();

						$slug = $category->slug;

						if ( ! empty( $slug ) ) {
							$slug_decoded = \urldecode( $slug );
							if ( $slug_decoded !== $slug ) {
								$template_candidates[] = "category-{$slug_decoded}.php";
							}

							$template_candidates[] = "category-{$slug}.php";
							$template_candidates[] = "category-{$category->term_id}.php";
						}

						$template_candidates[] = 'category.php';
					}
					elseif ( \is_tag() ) {
						$tag = \get_queried_object();

						$slug = $tag->slug;

						if ( ! empty( $slug ) ) {
							$slug_decoded = \urldecode( $slug );
							if ( $slug_decoded !== $slug ) {
								$template_candidates[] = "tag-{$slug_decoded}.php";
							}

							$template_candidates[] = 'tag-{slug}.php';
							$template_candidates[] = 'tag-{$tag->term_id}.php';
						}

						$template_candidates[] = 'tag.php';
					}
					elseif ( \is_author() ) {
						$author = \get_queried_object();

						if ( $author instanceof \WP_User ) {
							$template_candidates[] = "author-{$author->user_nicename}.php";
							$template_candidates[] = "author-{$author->ID}.php";
						}

						$template_candidates[] = 'author.php';
					}
					elseif ( \is_date() ) {
						$template_candidates[] = 'date.php';
					}
					$template_candidates[] = 'archive.php';
				}
				elseif ( \is_search() ) {
					$template_candidates[] = 'search.php';
				}
				elseif ( \is_privacy_policy() ) {
					$template_candidates[] = 'privacy-policy.php';
				}
				elseif ( \is_embed() ) {
					$object = get_queried_object();

					$post_type = $object->post_type;

					if ( ! empty( $post_type ) ) {
						$post_format = \get_post_format( $object );
						if ( $post_format ) {
							$template_candidates[] = "embed-{$post_type}-{$post_format}.php";
						}
						$template_candidates[] = "embed-{$post_type}.php";
					}

					$template_candidates[] = 'embed.php';
				}
				// The following commented `elseif` statements are not related to themes.
				// elseif ( is_robots() ) {
				// 	$template_candidates = 'robots.php';
				// }
				// elseif ( is_feed() ) {
				// 	$template_candidates = 'feed.php';
				// }
				// elseif ( is_trackback() ) {
				// 	$template_candidates = 'trackback.php';
				// }
				elseif ( \is_404() ) {
					$template_candidates[] = '404.php';
				}

				$template_candidates[] = 'index.php';
			}

			return $template_candidates;
		}

		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		protected static function get_template_types () {
			static $template_types = null;

			if ( $template_types === null ) {
				$template_types = array(
					'404',
					'archive',
					'attachment',
					'author',
					'category',
					'date',
					'embed',
					'frontpage',
					'home',
					'index',
					'page',
					'paged',
					'privacypolicy',
					'search',
					'single',
					'singular',
					'tag',
					'taxonomy',
				);
			}

			return $template_types;
		}

		/**
		* Causes WordPress to skip running the template hierarchy algorithm.
		*
		* The ideal place to call this function is in the callback to the `wp` action.
		* This would usually be done in the theme's `functions.php` file.
		*
		*     // functions.php
		*
		*     use \Wpx\Wpx\v0\WpTheme;
		*
		*     add_action( 'wp', function () {
		*     	WpTheme::skip_template_hierarchy();
		*     } );
		*
		*     // Or more succinctly:
		*     add_action( 'wp', 'Wpx\Wpx\v0\WpTheme::skip_template_hierarchy' );
		*
		* Note: The `wp_loaded` action can be used too but the WP_Query has not been run
		* at that point.
		*
		* Currently, the `template_redirect` action hook is the last place where this
		* function can be called and have any effect. However, that hook should only be
		* used when an actual redirect is intended.
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function skip_template_hierarchy () {
			// There are at least 3 ways to implement this behavior. All appear to perform
			// at about the same speed. However, option 3 is the easiest to maintain.

			// Option 1:
			// ---------
			//
			// This option won't work if `wp()` has not been called yet because the conditional
			// tags used by this option are not ready to be used. Therefore, even the
			// `wp_loaded` action hook is too late.

			// if ( is_embed() ) {
			// 	\add_filter( 'embed_template_hierarchy', '__return_empty_array' );
			// 	\add_filter( 'embed_template', '__return_true' );
			// }
			// elseif ( is_404() ) {
			// 	\add_filter( '404_template_hierarchy', '__return_empty_array' );
			// 	\add_filter( '404_template', '__return_true' );
			// }
			// elseif ( is_search() ) {
			// 	\add_filter( 'search_template_hierarchy', '__return_empty_array' );
			// 	\add_filter( 'search_template', '__return_true' );
			// }
			// elseif ( is_front_page() ) {
			// 	\add_filter( 'frontpage_template_hierarchy', '__return_empty_array' );
			// 	\add_filter( 'frontpage_template', '__return_true' );
			// }
			// elseif ( is_home() ) {
			// 	\add_filter( 'home_template_hierarchy', '__return_empty_array' );
			// 	\add_filter( 'home_template', '__return_true' );
			// }
			// elseif ( is_privacy_policy() ) {
			// 	\add_filter( 'privacypolicy_template_hierarchy', '__return_empty_array' );
			// 	\add_filter( 'privacypolicy_template', '__return_true' );
			// }
			// elseif ( is_post_type_archive() ) {
			// 	\add_filter( 'archive_template_hierarchy', '__return_empty_array' );
			// 	\add_filter( 'archive_template', '__return_true' );
			// }
			// elseif ( is_tax() ) {
			// 	\add_filter( 'taxonomy_template_hierarchy', '__return_empty_array' );
			// 	\add_filter( 'taxonomy_template', '__return_true' );
			// }
			// elseif ( is_attachment() ) {
			// 	\add_filter( 'attachment_template_hierarchy', '__return_empty_array' );
			// 	\add_filter( 'attachment_template', '__return_true' );
			// }
			// elseif ( is_single() ) {
			// 	\add_filter( 'single_template_hierarchy', '__return_empty_array' );
			// 	\add_filter( 'single_template', '__return_true' );
			// }
			// elseif ( is_page() ) {
			// 	\add_filter( 'page_template_hierarchy', '__return_empty_array' );
			// 	\add_filter( 'page_template', '__return_true' );
			// }
			// elseif ( is_singular() ) {
			// 	\add_filter( 'singular_template_hierarchy', '__return_empty_array' );
			// 	\add_filter( 'singular_template', '__return_true' );
			// }
			// elseif ( is_category() ) {
			// 	\add_filter( 'category_template_hierarchy', '__return_empty_array' );
			// 	\add_filter( 'category_template', '__return_true' );
			// }
			// elseif ( is_tag() ) {
			// 	\add_filter( 'tag_template_hierarchy', '__return_empty_array' );
			// 	\add_filter( 'tag_template', '__return_true' );
			// }
			// elseif ( is_author() ) {
			// 	\add_filter( 'author_template_hierarchy', '__return_empty_array' );
			// 	\add_filter( 'author_template', '__return_true' );
			// }
			// elseif ( is_date() ) {
			// 	\add_filter( 'date_template_hierarchy', '__return_empty_array' );
			// 	\add_filter( 'date_template', '__return_true' );
			// }
			// elseif ( is_archive() ) {
			// 	\add_filter( 'archive_template_hierarchy', '__return_empty_array' );
			// 	\add_filter( 'archive_template', '__return_true' );
			// }
			// else {
			// 	\add_filter( 'index_template_hierarchy', '__return_empty_array' );
			// 	\add_filter( 'index_template', '__return_true' );
			// }

			// Option 2:
			// ---------

			// \add_filter( '404_template_hierarchy', '__return_empty_array' );
			// \add_filter( 'archive_template_hierarchy', '__return_empty_array' );
			// \add_filter( 'attachment_template_hierarchy', '__return_empty_array' );
			// \add_filter( 'author_template_hierarchy', '__return_empty_array' );
			// \add_filter( 'category_template_hierarchy', '__return_empty_array' );
			// \add_filter( 'date_template_hierarchy', '__return_empty_array' );
			// \add_filter( 'embed_template_hierarchy', '__return_empty_array' );
			// \add_filter( 'frontpage_template_hierarchy', '__return_empty_array' );
			// \add_filter( 'home_template_hierarchy', '__return_empty_array' );
			// \add_filter( 'page_template_hierarchy', '__return_empty_array' );
			// \add_filter( 'paged_template_hierarchy', '__return_empty_array' );
			// \add_filter( 'privacypolicy_template_hierarchy', '__return_empty_array' );
			// \add_filter( 'search_template_hierarchy', '__return_empty_array' );
			// \add_filter( 'single_template_hierarchy', '__return_empty_array' );
			// \add_filter( 'singular_template_hierarchy', '__return_empty_array' );
			// \add_filter( 'tag_template_hierarchy', '__return_empty_array' );
			// \add_filter( 'taxonomy_template_hierarchy', '__return_empty_array' );

			// \add_filter( '404_template', '__return_true' );
			// \add_filter( 'archive_template', '__return_true' );
			// \add_filter( 'attachment_template', '__return_true' );
			// \add_filter( 'author_template', '__return_true' );
			// \add_filter( 'category_template', '__return_true' );
			// \add_filter( 'date_template', '__return_true' );
			// \add_filter( 'embed_template', '__return_true' );
			// \add_filter( 'frontpage_template', '__return_true' );
			// \add_filter( 'home_template', '__return_true' );
			// \add_filter( 'page_template', '__return_true' );
			// \add_filter( 'paged_template', '__return_true' );
			// \add_filter( 'privacypolicy_template', '__return_true' );
			// \add_filter( 'search_template', '__return_true' );
			// \add_filter( 'single_template', '__return_true' );
			// \add_filter( 'singular_template', '__return_true' );
			// \add_filter( 'tag_template', '__return_true' );
			// \add_filter( 'taxonomy_template', '__return_true' );

			// Option 3:
			// ---------

			$template_types = self::get_template_types();
			foreach ( $template_types as $template_type ) {
				\add_filter( "{$template_type}_template_hierarchy", '__return_empty_array' );
				\add_filter( "{$template_type}_template", '__return_true' );
			}

			// Option 4:
			// ---------
			// This option requires that core add the `skip_template_hierarchy` filter.

			// \add_filter( 'skip_template_hierarchy', '__return_true' );
		}

	} // eo class WpTheme

} // eo if ( class_exists )
