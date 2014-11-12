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

$wgExtensionCredits['other'][] = array(
   'path' => __FILE__,
   'name' => 'PlasticMW',
   'author' => array(
      'Simon Heimler',
   ),
   'version'  => '0.0.1',
   'url' => 'https://www.mediawiki.org/wiki/Extension:PlasticMW',
   'descriptionmsg' => 'PlasticMW-desc',
);

/* Setup */


// Initialize an easy to use shortcut:
$dir = dirname( __FILE__ );
$dirbasename = basename( $dir );

// Register i18n
$wgExtensionMessagesFiles['PlasticMWMagic'] = $dir . '/PlasticMW.i18n.magic.php';

// Register files
$wgAutoloadClasses['PlasticMWHooks'] = $dir . '/PlasticMW.hooks.php';


// Register hooks
$wgHooks['BeforePageDisplay'][] = 'PlasticMWHooks::onBeforePageDisplay';
$wgHooks['ParserFirstCallInit'][] = 'PlasticMWHooks::onParserFirstCallInit';



// Register modules
$wgResourceModules['ext.PlasticMW'] = array(
   'scripts' => array(
      'modules/plastic.js',
   ),
   'styles' => array(
      'modules/plastic.css',
   ),
   'messages' => array(
   ),
   'dependencies' => array(
   ),

   'localBasePath' => __DIR__,
   'remoteExtPath' => 'PlasticMW',
);


/* Configuration */

// Enable Foo
#$wgPlasticMWEnableFoo = true;
