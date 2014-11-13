<?php

/**
 * Hooks for PlasticMW extension
 *
 * @file
 * @ingroup Extensions
 */

class PlasticAsk extends SMWQueryProcessor  {


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
    public static function parserFunctionPlasticAsk(Parser &$parser) {

        // Get Parameters
        $params = func_get_args();
        array_shift( $params ); // We already know the $parser.
        $query = $params[0];
        $arguments = extractOptions($params);

        // Variables
        $url = '/' . 'mw' . '/api.php'; // TODO!
        $options = Array();
        $displayOptions = Array();
        $displayModule = 'advanced-table'; // TODO!


        $html = '<div class="plastic-js">';

        // Query Tag
        $html .= '<script class="plastic-query" type="application/ask-query" data-query-url="' . $url . '">';
        $html .= $query;
        $html .= '</script>';

        // Options Tag
        $html .= '<script class="plastic-options" type="application/json">';
        $html .= FormatJson::encode($options);
        $html .= '</script>';

        // Display Tag
        $html .= '<script class="plastic-display" type="application/json" data-display-module="' . $displayModule . '">';
        $html .= FormatJson::encode($arguments);
        $html .= '</script>';

        $html .= '</div>';

        $debug = array(
            // 'parser' => $parser,
            'query' => $query,
            'arguments' => $arguments,
            'html' => $html,
        );

        // tlog($html);
        // jlog($debug);

        return array($html, "markerType" => 'nowiki' );
    }

}


/**
 * Converts an array of values in form [0] => "name=value" into a real
 * associative array in form [name] => value
 *
 * @param array string $options
 * @return array $results
 */
function extractOptions( array $options ) {

    $results = array();

    foreach ( $options as $option ) {
        $pair = explode( '=', $option, 2 );
        if ( count( $pair ) == 2 ) {
            $name = trim( $pair[0] );
            $value = trim( $pair[1] );
            $results[$name] = $value;
        }
    }
    return $results;
}

/**
 * Helper Logging Function that outputs an object as pretty JSON and kills the PHP process
 *
 * @param  [type] $object [description]
 * @return [type]         [description]
 */
function jlog($object) {
    header('Content-Type: application/json');
    print(json_encode($object, JSON_PRETTY_PRINT));
    die();
}

/**
 * Helper Logging Function that outputs an object as pretty JSON and kills the PHP process
 *
 * @param  [type] $object [description]
 * @return [type]         [description]
 */
function tlog($object) {
    header('Content-Type: text/plain');
    print($object);
    die();
}
