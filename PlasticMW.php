<?php
/**
 * plastic.js MediaWiki Wrapper
 *
 * For more info see http://mediawiki.org/wiki/Extension:PlasticMW
 *
 * @file
 * @ingroup Extensions
 * @author Simon Heimler, 2014
 * @license GNU General Public Licence 2.0 or later
 */


//////////////////////////////////////////
// VARIABLES                            //
//////////////////////////////////////////

$dir         = dirname( __FILE__ );
$dirbasename = basename( $dir );


//////////////////////////////////////////
// CREDITS                              //
//////////////////////////////////////////

$wgExtensionCredits['other'][] = array(
   'path'           => __FILE__,
   'name'           => 'PlasticMW',
   'author'         => array('Simon Heimler'),
   'version'        => '0.0.1',
   'url'            => 'https://www.mediawiki.org/wiki/Extension:PlasticMW',
   'descriptionmsg' => 'PlasticMW-desc',
);


//////////////////////////////////////////
// RESOURCE LOADER                      //
//////////////////////////////////////////

$wgResourceModules['ext.PlasticMW'] = array(
   'scripts' => array(
      'lib/plastic.js',
   ),
   'styles' => array(
      'lib/plastic.css',
   )
   ,'messages' => array(
   ),
   'dependencies' => array(
   ),
   'localBasePath' => __DIR__,
   'remoteExtPath' => 'PlasticMW',
);


//////////////////////////////////////////
// LOAD FILES                           //
//////////////////////////////////////////

// Register i18n
$wgExtensionMessagesFiles['PlasticMWMagic'] = $dir . '/PlasticMW.i18n.magic.php';

// Register files
$wgAutoloadClasses['PlasticTag'] = $dir . '/modules/PlasticTag.php';
$wgAutoloadClasses['PlasticAsk'] = $dir . '/modules/PlasticAsk.php';

// Register hooks
$wgHooks['BeforePageDisplay'][] = 'onBeforePageDisplay';
$wgHooks['ParserFirstCallInit'][] = 'onParserFirstCallInit';


//////////////////////////////////////////
// CONFIGURATION                        //
//////////////////////////////////////////


//////////////////////////////////////////
// HOOK CALLBACKS                       //
//////////////////////////////////////////

/**
* Add plastic.js library to all pages
*/
function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {

  // Add as ResourceLoader Module
  $out->addModules('ext.PlasticMW');

  return true;
}

/**
* Register parser hooks
*
* See also http://www.mediawiki.org/wiki/Manual:Parser_functions
*/
function onParserFirstCallInit( &$parser ) {

  // Register <plastic> tag
  $parser->setHook('plastic', 'PlasticTag::parserTagPlastic');

  // Register {{#plastic-ask }} parser function
  // $parser->setFunctionHook('plastic-ask', 'PlasticAsk::parserFunctionPlasticAsk');

  return true;
}

