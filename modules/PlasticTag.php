<?php

/**
 * Hooks for PlasticMW extension
 *
 * @file
 * @ingroup Extensions
 */

class PlasticTag {

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
        $html = '<div class="plastic-js"' . $tagAttributes . '>' . (string)$data . '</div>';

        return array($html, "markerType" => 'nowiki' );
    }

}
