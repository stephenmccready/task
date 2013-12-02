task
====

Task manager: Keeps track of tasks, status, hours, people


Task_DB.pdf (and Task_DB.docx) 
- Contains the database layout and a brief description of some of the tables.
- The table names are pretty much self-explanatory

Build_task_database.sql 
- Contains the SQL code used to build the task database and initially populate some of the tables.
- These tables contain insert statements with dummy data. You should DEFINATLEY change the contents of the insert statements:
		tbl_requested_by
		tbl_assigned_to
- You should review and change the generic values in the insert statements for the following tables to fit your needs:
		tbl_importance
		tbl_urgency
		tbl_status
		tbl_dept
		tbl_section
		tbl_task_type

