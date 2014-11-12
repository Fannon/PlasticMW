<?php

/**
 * Hooks for PlasticMW extension
 *
 * @file
 * @ingroup Extensions
 */

class PlasticMWHooks {

    /**
     * Add welcome module to the load queue of all pages
     */
    public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {


        $out->addModules('ext.PlasticMW');

        // Always return true, indicating that parser initialization should
        // continue normally.
        return true;
    }

    /**
     * Register parser hooks
     * See also http://www.mediawiki.org/wiki/Manual:Parser_functions
     */
    public static function onParserFirstCallInit( &$parser ) {

        // Add the following to a wiki page to see how it works:

        //  {{#plastic: hello | hi | there }}
        $parser->setFunctionHook('plastic', 'PlasticMWHooks::parserFunctionPlasticTag');

        return true;
    }

    /**
     * Parser function handler for {{#plastic: .. | .. }}
     *
     * @param Parser $parser
     * @param string $arg
     *
     * @return string: HTML to insert in the page.
     */
    public static function parserFunctionPlasticTag( $parser, $value /* arg2, arg3, */ ) {
        $args = array_slice( func_get_args(), 2 );
        $plastic = array(
            'value' => $value,
            'arguments' => $args,
        );

        $output = '<pre>plastic Function: ' . htmlspecialchars( FormatJson::encode( $plastic, /*prettyPrint=*/true ) ) . '</pre>';

        return $output;
    }


}
