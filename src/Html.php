<?php

declare( strict_types = 1 );

namespace Wpx\Wpx\v0;

require_once __DIR__ . '/bootstrap.php';

if ( ! \class_exists( __NAMESPACE__ . '\Html' ) ) {

	class Html {

		/**
		* Converts an attributes array to an HTML string. Use PHP booleans (aka bools)
		* for boolean attributes. A null attribute will be ignored. Otherwise, all other
		* attributes will be converted to a string.
		*
		*     use Wpx\Wpx\v0\Html;
		*
		*     $attrs = [
		*     	'class' => 'foo',
		*     	'checked' => true,
		*     	'ignored' => null,
		*     ];
		*     $html = Html::attrs( $attrs );
		*
		*     echo '<tag' . $html . '>...</tag>';
		*
		* Echos
		*
		*     <tag class="foo" checked>...</tag>
		*
		* Beware: Some attributes, e.g., `contenteditable`, are not boolean attributes.
		* They are an enumerated attribute. Therefore, its values must be strings even
		* though `'true'` and `'false'` may be among the accepted values. That is, using a
		* PHP boolean is not correct for `contenteditable`.
		*
		* Note: In order to keep the implementation simple, the logic is not aware of
		* special attributes such as `contenteditable`. The logic is based off of the
		* data type of the attribute's value.
		*
		* @param array $attrs {
		* 	The attributes.
		*
		* 	@type bool|string $attr[i] Optional. An attribute.
		* }
		*
		* @return string The attributes array converted to a single line of HTML.
		*
		* @see https://html.spec.whatwg.org/multipage/common-microsyntaxes.html#boolean-attributes
		* @see https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/contenteditable
		*/
		public static function attrs ( $attrs = array() ) {
			$html = array();

			foreach ( $attrs as $name => $value ) {
				if ( is_bool( $value) && $value ) {
					$html[] = $name;
				}
				elseif ( $value !== null ) {
					$html[] = $name . '="' . \esc_attr( $value ) . '"';
				}
			}

			if ( count( $html ) > 0 ) {
				$html = ' ' . implode( ' ', $html );
			}
			else {
				$html = '';
			}
			return $html;
		}

	} // eo class Html

} // eo if ( class_exists )
