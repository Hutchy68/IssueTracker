BEGIN;

CREATE TABLE `issue_tracker` (
  `issue_id` int(10) NOT NULL auto_increment,
  `type` varchar(5) NOT NULL default 't_bug',
  `title` varchar(100) NOT NULL,
  `summary` text NOT NULL,
  `status` varchar(5) NOT NULL default 's_new',
  `assignee` varchar(40) NOT NULL,
  `user_name` varchar(40) NOT NULL,
  `user_id` int(10) NOT NULL,
  `project_name` varchar(100) NOT NULL,
  `deleted` int(1) NOT NULL default '0',
  `history` text NOT NULL,
  `priority_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`issue_id`),
  KEY `user_id` (`user_id`)
);

COMMIT;