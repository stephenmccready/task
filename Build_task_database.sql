CREATE DATABASE task;

CREATE TABLE  `tbl_task` (
 `task_id` INT NOT NULL AUTO_INCREMENT ,
 `task_ud` VARCHAR( 128 ) NOT NULL ,
 `task_nm` VARCHAR( 256 ) ,
 `task_desc` VARCHAR( 512 ) ,
 `importance_id` INT NOT NULL ,
 `urgency_id` INT NOT NULL ,
 `status_id` INT NOT NULL ,
 `dept_id` INT,
 `section_id` INT,
 `deadline_date` DATETIME,
 `date_started` DATETIME,
 `date_completed` DATETIME,
 `requested_by_id` INT NOT NULL ,
 `task_type_id` INT NOT NULL ,
 `estimated_hours` INT,
 `estimated_date_start` DATETIME,
 `estimated_date_complete` DATETIME,
 `user_def01` VARCHAR( 64 ) ,
 `user_def02` VARCHAR( 64 ) ,
 `user_def03` VARCHAR( 64 ) ,
 `user_def04` VARCHAR( 64 ) ,
 `user_def05` VARCHAR( 64 ) ,
 `date_created` DATETIME NOT NULL ,
 `created_by` VARCHAR( 64 ) NOT NULL ,
 `date_modified` DATETIME,
 `modified_by` VARCHAR( 64 ) ,
 `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (  `task_id` )
) TYPE = MYISAM ;

CREATE TABLE  `tbl_task_assign` (
 `task_assign_id` INT NOT NULL AUTO_INCREMENT ,
 `task_id` INT NOT NULL ,
 `assigned to_id` INT NOT NULL ,
 `date_assigned` DATETIME NOT NULL,
 `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (  `task_assign_id` )
) TYPE = MYISAM ;

CREATE TABLE  `tbl_task_hours` (
 `task_hours_id` INT NOT NULL AUTO_INCREMENT ,
 `task_assign_id` INT NOT NULL ,
 `date` DATETIME NOT NULL,
 `hours` INT NOT NULL,
 `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (  `task_hours_id` )
) TYPE = MYISAM ;

CREATE TABLE  `tbl_status_history` (
 `status_history_id` INT NOT NULL AUTO_INCREMENT ,
 `task_id` INT NOT NULL ,
 `old_status_id` INT NOT NULL ,
 `new_status_id` INT NOT NULL ,
 `date_created` DATETIME NOT NULL ,
 `created_by` VARCHAR( 64 ) NOT NULL ,
 `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (  `status_history_id` )
) TYPE = MYISAM ;

	
CREATE TABLE  `tbl_user` (
 `user_id` INT NOT NULL AUTO_INCREMENT ,
 `user_nm` VarChar(64) NOT NULL ,
 `user_email` VarChar(128) NOT NULL ,
 `user_pwd` VarChar(255) NOT NULL ,
 `super_user` TINYINT NOT NULL ,
 `active` TINYINT NOT NULL ,
 `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (  `user_id` )
) TYPE = MYISAM 

	INSERT INTO  `tbl_user` (  `user_nm`,  `user_email`,  `user_pwd`,  `super_user` ,  `active` ,  `timestamp` ) 
	VALUES 
	('Finn White',  'finn@mydomain.com', sha('password'), 1, 1, NOW( )), 
	('Holly White',  'holly@mydomain.com', sha('password'), 1, 1, NOW( )), 
	('Walter White',  'walter@mydomain.com', sha('password'), 1, 1, NOW( )),
	('Gus Fring',  'gus@mydomain.com', sha('password'), 1, 1, NOW( )),
	('Jesse Pinkman',  'jesse@mydomain.com', sha('password'), 1, 1, NOW( )),
	('Skylar White',  'skylar@mydomain.com', sha('password'), 1, 1, NOW( ));


CREATE TABLE  `tbl_requested_by` (
 `requested_by_id` INT NOT NULL AUTO_INCREMENT ,
 `user_id` INT NOT NULL ,
 `active` TINYINT NOT NULL ,
 `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (  `requested_by_id` )
) TYPE = MYISAM 

	INSERT INTO  `tbl_requested_by` (  `user_id`, `active` ,  `timestamp` ) 
	VALUES 
	(1,  1, NOW( )), 
	(2,  1, NOW( )), 
	(3,  1, NOW( ));


CREATE TABLE  `tbl_assigned_to` (
 `assigned_to_id` INT NOT NULL AUTO_INCREMENT ,
 `user_id` INT NOT NULL ,
 `active` TINYINT NOT NULL ,
 `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (  `assigned_to_id` )
) TYPE = MYISAM 

	INSERT INTO  `tbl_assigned_to` (  `user_id`, `active` ,  `timestamp` ) 
	VALUES 
	(4,  1, NOW( )), 
	(5,  1, NOW( )), 
	(6,  1, NOW( ));
	
	
CREATE TABLE  `tbl_importance` (
 `importance_id` INT NOT NULL ,
 `importance_ud` VARCHAR( 32 ) NOT NULL ,
 `sort_order` INT NOT NULL ,
 `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (  `importance_id` )
) TYPE = MYISAM ;

	INSERT INTO  `tbl_importance` (  `importance_id` ,  `importance_ud` ,  `sort_order` ,  `timestamp` ) 
	VALUES 
	('1',  'Not Important',  '500', NOW( )), 
	('2',  'Slightly Important',  '400', NOW( )), 
	('3',  'Important',  '300', NOW( )), 
	('4',  'Fairly Important',  '200', NOW( )), 
	('5',  'Very Important',  '100', NOW( ));

CREATE TABLE  `tbl_urgency` (
 `urgency_id` INT NOT NULL ,
 `urgency_ud` VARCHAR( 32 ) NOT NULL ,
 `sort_order` INT NOT NULL ,
 `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (  `urgency_id` )
) TYPE = MYISAM ;

	INSERT INTO  `tbl_urgency` (  `urgency_id` ,  `urgency_ud` ,  `sort_order` ,  `timestamp` ) 
	VALUES 
	('1',  'Not Urgent',  '500', NOW( )), 
	('2',  'Slightly Urgent',  '400', NOW( )), 
	('3',  'Urgent',  '300', NOW( )), 
	('4',  'Fairly Urgent',  '200', NOW( )), 
	('5',  'Very Urgent',  '100', NOW( ));

CREATE TABLE  `tbl_status` (
 `status_id` INT NOT NULL ,
 `status_ud` VARCHAR( 32 ) NOT NULL ,
 `sort_order` INT NOT NULL ,
 `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (  `status_id` )
) TYPE = MYISAM ;

	INSERT INTO  `tbl_status` (  `status_id` ,  `status_ud` ,  `sort_order` ,  `timestamp` ) 
	VALUES 
	('1',  'Entered',  '100', NOW( )), 
	('2',  'Scheduled',  '200', NOW( )), 
	('3',  'In Queue',  '300', NOW( )), 
	('4',  'In Progress',  '400', NOW( )), 
	('5',  'On Hold',  '500', NOW( )), 
	('6',  'Abandoned',  '600', NOW( )), 
	('7',  'Completed',  '700', NOW( ));

CREATE TABLE  `tbl_dept` (
 `dept_id` INT NOT NULL ,
 `dept_ud` VARCHAR( 64 ) NOT NULL ,
 `sort_order` INT NOT NULL ,
 `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (  `dept_id` )
) TYPE = MYISAM ;

	INSERT INTO  `tbl_dept` (  `dept_id` ,  `dept_ud` ,  `sort_order` ,  `timestamp` ) 
	VALUES 
	('1',  'Customer Service',  '100', NOW( )), 
	('2',  'Finance',  '200', NOW( )), 
	('3',  'Human Resources',  '300', NOW( )), 
	('4',  'IT',  '400', NOW( )), 
	('5',  'Marketing',  '500', NOW( )), 
	('6',  'Sales',  '600', NOW( ));

CREATE TABLE  `tbl_section` (
 `section_id` INT NOT NULL ,
 `section_ud` VARCHAR( 64 ) NOT NULL ,
 `sort_order` INT NOT NULL ,
 `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (  `section_id` )
) TYPE = MYISAM ;

	INSERT INTO  `tbl_section` (  `section_id` ,  `section_ud` ,  `sort_order` ,  `timestamp` ) 
	VALUES 
	('1',  'Accounting',  '100', NOW( )), 
	('2',  'Budgeting',  '200', NOW( )), 
	('3',  'Desktop Support',  '300', NOW( )), 
	('4',  'Application Development',  '400', NOW( ));

CREATE TABLE  `tbl_task_type` (
 `task_type_id` INT NOT NULL ,
 `task_type_ud` VARCHAR( 64 ) NOT NULL ,
 `sort_order` INT NOT NULL ,
 `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
PRIMARY KEY (  `task_type_id` )
) TYPE = MYISAM ;

	INSERT INTO  `tbl_task_type` (  `task_type_id` ,  `task_type_ud` ,  `sort_order` ,  `timestamp` ) 
	VALUES 
	('1',  'Bug fix',  '100', NOW( )), 
	('2',  'Enhancement',  '200', NOW( )), 
	('3',  'New Application',  '300', NOW( )), 
	('4',  'New Feature',  '400', NOW( ));
