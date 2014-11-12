<?php

/**
 * Hooks for PlasticMW extension
 *
 * @file
 * @ingroup Extensions
 */

class PlasticMWHooks {

    /**
     * Add plastic.js library to all pages
     */
    public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {

        // Add as ResourceLoader Module
        $out->addModules('ext.PlasticMW');
        return true;
    }

    /**
     * Register parser hooks
     * See also http://www.mediawiki.org/wiki/Manual:Parser_functions
     */
    public static function onParserFirstCallInit( &$parser ) {

        // <plastic> tag support
        $parser->setHook('plastic', 'PlasticMWHooks::parserTagPlastic');

        // {{#plastic }} function support
        // $parser->setFunctionHook('plastic', 'PlasticMWHooks::parserFunctionPlastic', SFH_OBJECT_ARGS);

        return true;
    }

    /**
     * Parser function handler for {{#plastic: .. | .. }}
     *
     * @todo : Easy replacement for #ask
     *
     * @param Parser $parser
     * @param string $arg
     *
     * @return string: HTML to insert in the page.
     */
    public static function parserFunctionPlastic( $parser, $value) {
        $args = array_slice( func_get_args(), 2 );
        $plastic = array(
            'value' => $value,
            'arguments' => $args,
        );

        return '<pre>plastic Function: ' . htmlspecialchars(FormatJson::encode($plastic)) . '</pre>';
    }

    /**
     * Parser hook handler for <plastic>
     *
     * @param string $data: The content of the tag.
     * @param array $params: The attributes of the tag.
     * @param Parser $parser: Parser instance available to render wikitext into html, or parser methods.
     * @param PPFrame $frame: Can be used to see what template arguments ({{{1}}}) this hook was used with.
     *
     * @return string: HTML to insert in the page.
     */
    public static function parserTagPlastic($data, $attribs, $parser, $frame ) {


        $tagAttributes = '';


        // If no HTML class was defined, add plastic-js so the element is recognized by plastic.js
        if (!array_key_exists('class' , $attribs)) {

            $tagAttributes .= ' class="plastic-js"';

        // If HTML Class is given, search if plastic-js is already defined. If not, append it.
        } else {
            if (strpos($attribs['class'], 'plastic-js') === false) {
                $attribs['class'] .= ' plastic-js';
            }
        }

        // Append all attributes
        foreach ($attribs as $key => $value) {
            $tagAttributes .= ' ' . $key . '="' . $value . '"';
        }


        // TODO: Include default options


        // Generate plastic.js tag
        $html = '<div class="plastic-js"' . $tagAttributes . '>' . $data . '</div>';

        return array($html, "markerType" => 'nowiki' );
    }


}
