<?php
/**
 * Issue Tracking System
 * 
 * Setup and Hooks for the BugTracking extension
 *
 * @category    Extensions
 * @package     IssueTracker
 * @author      Federico Cargnelutti
 * @copyright   Copyright (c) 2008 Federico Cargnelutti
 * @license     GNU General Public Licence 2.0 or later
 */
if (! defined('MEDIAWIKI')) {
	echo 'This file is an extension to the MediaWiki software and cannot be used standalone.';
	die;
}

$wgIssueTrackerExtensionVersion = '1.0';

$wgExtensionCredits['parserhook'][]  = array(
	'name'          => 'IssueTracker',
	'author'        => 'Federico Cargnelutti',
	'email'         => 'federico@kewnode.com',
	'description'   => 'Issue Tracking System',
	'description'   => 'Adds &lt;issues /&gt; parser function for viewing and adding issues',
	'version'       => $wgIssueTrackerExtensionVersion
);
$wgExtensionCredits['specialpage'][] = array(
	'name'          => 'IssueTracker',
	'author'        => 'Federico Cargnelutti',
	'email'         => 'federico@kewnode.com',
	'description'   => 'Issue Tracking System',
	'description'   => 'Adds a special page for managing issues',
	'version'       => $wgIssueTrackerExtensionVersion
);

$dir = dirname(__FILE__) . '/';

// Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['IssueTracker'] = $dir . 'IssueTracker.i18n.php';

// Autoload the IssueTracker class
$wgAutoloadClasses['IssueTracker'] = $dir . 'IssueTracker.body.php'; 

// Let MediaWiki know about your new special page.
$wgSpecialPages['IssueTracker'] = 'IssueTracker';
$wgSpecialPageGroups['IssueTracker']= 'developer';

// Add Extension Functions
$wgExtensionFunctions[] = 'wfIssueTrackerSetParserHook';

// Add any aliases for the special page
$wgHooks['LanguageGetSpecialPageAliases'][] = 'wfIssueTrackerLocalizedTitle';
$wgHooks['ParserAfterTidy'][] = 'wfIssueTrackerDecodeOutput';

// Load SchemaUpdates
$wgHooks['LoadExtensionSchemaUpdates'][] = 'wfIssueTrackerCreateTable';

$wgAvailableRights[] = 'issuetracker-list';
$wgAvailableRights[] = 'issuetracker-view';
$wgAvailableRights[] = 'issuetracker-add';
$wgAvailableRights[] = 'issuetracker-edit';
$wgAvailableRights[] = 'issuetracker-archive';
$wgAvailableRights[] = 'issuetracker-unarchive';
$wgAvailableRights[] = 'issuetracker-delete';
$wgAvailableRights[] = 'issuetracker-undelete';
$wgAvailableRights[] = 'issuetracker-assign';
$wgAvailableRights[] = 'issuetracker-assignee';

$wgGroupPermissions['*']['issuetracker-list'] = true;
$wgGroupPermissions['*']['issuetracker-view'] = true;
$wgGroupPermissions['user']['issuetracker-add'] = true;
$wgGroupPermissions['user']['issuetracker-edit'] = true;
$wgGroupPermissions['sysop']['issuetracker-archive'] = true;
$wgGroupPermissions['sysop']['issuetracker-unarchive'] = true;
// Commenting out the following two lines
// Working out permissions delete/archive/undelete/unarchive
// $wgGroupPermissions['sysop']['issuetracker-delete'] = true;
// $wgGroupPermissions['sysop']['issuetracker-undelete'] = true;
$wgGroupPermissions['sysop']['issuetracker-assign'] = true;
$wgGroupPermissions['DocsContributor']['issuetracker-assignee'] = true;

function wfIssueTrackerAssignee()
{
	global $wgAssigneeGroup;
	$wgAssigneeGroup = 'DocsContributor';
	return $wgAssigneeGroup;
}

/**
 * A hook to register an alias for the special page
 * @return bool
 */
function wfIssueTrackerLocalizedTitle(&$specialPageArray, $code = 'en') 
{
	// The localized title of the special page is among the messages of the extension:
	  
	// Convert from title in text form to DBKey and put it into the alias array:
	$text = wfMessage('issuetracker')->inContentLanguage()->text();
	$title = Title::newFromText($text);
	$specialPageArray['IssueTracker'][] = $title->getDBKey();
	
	return true;
}

/**
 * Register parser hook
 * @return void
 */
function wfIssueTrackerSetParserHook() 
{
	global $wgParser;
	$wgParser->setHook('issues', array('IssueTracker', 'executeHook'));
}

/**
 * Processes HTML comments with encoded content.
 * 
 * @param OutputPage $out Handle to an OutputPage object presumably $wgOut (passed by reference).
 * @param String $text Output text (passed by reference)
 * @return Boolean Always true to give other hooking methods a chance to run.
 */
function wfIssueTrackerDecodeOutput(&$parser, &$text) 
{
    $text = preg_replace(
        '/@ENCODED@([0-9a-zA-Z\\+\\/]+=*)@ENCODED@/e',
        'base64_decode("$1")',
        $text
    );
    return true;
}


function wfIssueTrackerCreateTable( $updater = null ) {
	if ( $updater === null ) {
		global $wgExtNewTables;
		$wgExtNewTables[] = array(
				'issue_tracker',
				dirname( __FILE__ ) . '/issuetracker.sql'
		);
	} else {
		$updater->addExtensionUpdate( array( 'addTable', 'issue_tracker',
				dirname( __FILE__ ) . '/issuetracker.sql', true ) );
	}
	return true;
}
