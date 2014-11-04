<?php

// Take credit for your work.
$wgExtensionCredits['parserhook'][] = array(

   // The full path and filename of the file. This allows MediaWiki
   // to display the Subversion revision number on Special:Version.
   'path' => __FILE__,

   // The name of the extension, which will appear on Special:Version.
   'name' => 'Plastic MediaWiki Wrapper',

   // A description of the extension, which will appear on Special:Version.
   'description' => 'A MediaWiki Wrapper Extension for the plastic.js data display framework',

   // The version of the extension, which will appear on Special:Version.
   // This can be a number or a string.
   'version' => 1,

   // Your name, which will appear on Special:Version.
   'author' => 'Simon Heimler',

   // The URL to a wiki page/web page with information about the extension,
   // which will appear on Special:Version.
   'url' => 'http://www.plasticjs.org',

);

$wgResourceModules['ext.myExtension'] = array(
   // JavaScript and CSS styles. To combine multiple files, just list them as an array.
   'scripts' => array('lib/plastic.min.js'),
   'styles' => array( 'lib/plastic.min.css'),

   // When your module is loaded, these messages will be available through mw.msg().
   // E.g. in JavaScript you can access them with mw.message( 'myextension-hello-world' ).text()
   'messages' => array( 'myextension-hello-world', 'myextension-goodbye-world' ),

   // You need to declare the base path of the file paths in 'scripts' and 'styles'
   'localBasePath' => __DIR__,
   // ... and the base from the browser as well. For extensions this is made easy,
   // you can use the 'remoteExtPath' property to declare it relative to where the wiki
   // has $wgExtensionAssetsPath configured:
   'remoteExtPath' => 'PlasticExtension'
);

// Specify the function that will initialize the parser function.
$wgHooks['ParserFirstCallInit'][] = 'ExampleExtensionSetupParserFunction';

// Allow translation of the parser function name
$wgExtensionMessagesFiles['PlasticExtension'] = __DIR__ . '/PlasticExtension.i18n.php';

// Tell MediaWiki that the parser function exists.
function ExampleExtensionSetupParserFunction( &$parser ) {

   // Create a function hook associating the "example" magic word with the
   // ExampleExtensionRenderParserFunction() function. See: the section
   // 'setFunctionHook' below for details.
   $parser->setFunctionHook( 'example', 'ExampleExtensionRenderParserFunction' );

   // Return true so that MediaWiki continues to load extensions.
   return true;
}

// Render the output of the parser function.
function ExampleExtensionRenderParserFunction( $parser, $param1 = '', $param2 = '', $param3 = '' ) {

   // The input parameters are wikitext with templates expanded.
   // The output should be wikitext too.
   $output = "param1 is $param1 and param2 is $param2 and param3 is $param3";

   return $output;
}
