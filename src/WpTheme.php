<?php

namespace Wpx\Wpx\v0;

require_once __DIR__ . '/bootstrap.php';

if ( ! \class_exists( __NAMESPACE__ . '\WpTheme' ) ) {

	class WpTheme {

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

	} // eo class WpTheme

} // eo if ( class_exists )
