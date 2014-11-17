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
        global $wgScriptPath;


        $url = $wgScriptPath . '/api.php';
        $displayModule = 'advanced-table'; // Default display module


        // Create the JSON API object
        $json = array();

        // Provide default values and structure
        $json['query'] = array(
            'url' => $url,
            'dataType' => 'application/ask-query',
            'text' => $query
        );

        $json['display'] = array(
            'module' => $displayModule
        );

        $json['options'] = array();


        // Extend / overwrite options through given #plastic-ask arguments
        foreach ($arguments as $key => $value) {

            if ($key === 'display') {

                // Overwrite display module if given
                $json['display']['module'] = $value;

            } else if ($key === 'query-url') {

                // Overwrite query-url if given
                $json['query']['url'] = $value;

            } else if (substr($key, 0, 1) === "_") {

                // Add global options (prefixed with _)
                $json['options'][substr($key, 1)] = $value;

            } else {

                // Add display options
                $json['display'][$key] = $value;
            }
        }


        $html = '<div class="plastic-js" data-type="application/json" style="height: auto; width: 100%;"> ' . FormatJson::encode($json) . ' </div>';


        // tlog($html);

        return array(
            $html,
            'noparse' => true,
            'isHTML' => true,
            "markerType" => 'nowiki'
        );
    }

}


/**
 * Converts an array of values in form [0] => "name=value" into a real
 * associative array in form [name] => value
 *
 * @param array string $json
 * @return array $results
 */
function extractOptions( array $json ) {

    $results = array();

    foreach ( $json as $option ) {
        $pair = explode( '=', $option, 2 );
        if ( count( $pair ) == 2 ) {
            $name = trim( $pair[0] );
            $value = trim( $pair[1] );
            $results[$name] = htmlspecialchars($value);
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
