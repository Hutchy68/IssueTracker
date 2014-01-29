<?php
/** @see IssueTrackerAction **/
require_once dirname(__FILE__) . '/IssueTrackerAction.php';

/**
 * IssueTrackerActionUnArchive class.
 *
 * @category    Extensions
 * @package     IssueTracker
 * @author      Tom Hutchison
 * @copyright   Copyright (c) 2014 Tom Hutchison
 * @license     GNU General Public Licence 2.0 or later
 */
class IssueTrackerActionUnArchive extends IssueTrackerAction
{
	/**
	 * Initialize class.
	 *
	 * @return bool
	 */
	public function init()
	{
		return $this->isLoggedIn();
	}

	/**
	 * Executes the action.
	 *
	 * @return void
	 */
	public function unarchiveAction()
	{
		global $wgUser, $wgScript, $wgRequest;

		$listUrl = $wgScript . '?title=' . $this->getNamespace('dbKey') . '&bt_action=list';

		$userId = $wgUser->getID();
		$userName = $wgUser->getName();

		$issueId = $wgRequest->getText('bt_issueid');
		$this->getModel('default')->unarchiveIssue($issueId);

		header('Location: ' . $listUrl);
	}
}
?>