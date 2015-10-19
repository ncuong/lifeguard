SELECT * FROM `application` WHERE user_id = 4 AND manager_ok = 1 AND hrm_ok = 1 AND YEAR(application.`from_date`) = 2015 AND reason = 13
SELECT SUM(hours_off) AS hours FROM `application` WHERE user_id = 4 AND manager_ok = 1 AND hrm_ok = 1 AND YEAR(application.`from_date`) = 2015 AND reason = 13
SELECT *, entitlement - (SELECT SUM(hours_off) AS hours FROM `application` WHERE user_id = 4 AND manager_ok = 1 AND hrm_ok = 1 AND reason = 13 AND YEAR(from_date) = user_date.`year`) AS abc FROM user_date WHERE user_id = 4



SELECT application.`user_id`, `reason_application`.`name` FROM application, reason_application WHERE reason = reason_application.`id` GROUP BY application.user_id, reason_application.`name`

SELECT user_info.`full_name`, 
	(SELECT SUM(application.`hours_off`) FROM application WHERE manager_ok =1 AND hrm_ok =1 AND reason = 2 AND application.`user_id` = user_info.`user_id`)AS nghi_phep2,
	(SELECT SUM(application.`hours_off`) FROM application WHERE manager_ok =1 AND hrm_ok =1 AND reason = 3 AND application.`user_id` = user_info.`user_id`)AS nghi_phep3,
	(SELECT SUM(application.`hours_off`) FROM application WHERE manager_ok =1 AND hrm_ok =1 AND reason = 4 AND application.`user_id` = user_info.`user_id`)AS nghi_phep4,
	(SELECT SUM(application.`hours_off`) FROM application WHERE manager_ok =1 AND hrm_ok =1 AND reason = 5 AND application.`user_id` = user_info.`user_id`)AS nghi_phep5,
	(SELECT SUM(application.`hours_off`) FROM application WHERE manager_ok =1 AND hrm_ok =1 AND reason = 6 AND application.`user_id` = user_info.`user_id`)AS nghi_phep6,
	(SELECT SUM(application.`hours_off`) FROM application WHERE manager_ok =1 AND hrm_ok =1 AND reason = 7 AND application.`user_id` = user_info.`user_id`)AS nghi_phep7,
	(SELECT SUM(application.`hours_off`) FROM application WHERE manager_ok =1 AND hrm_ok =1 AND reason = 8 AND application.`user_id` = user_info.`user_id`)AS nghi_phep8,
	(SELECT SUM(application.`hours_off`) FROM application WHERE manager_ok =1 AND hrm_ok =1 AND reason = 9 AND application.`user_id` = user_info.`user_id`)AS nghi_phep9,
	(SELECT SUM(application.`hours_off`) FROM application WHERE manager_ok =1 AND hrm_ok =1 AND reason = 10 AND application.`user_id` = user_info.`user_id`)AS nghi_phep10,
	(SELECT SUM(application.`hours_off`) FROM application WHERE manager_ok =1 AND hrm_ok =1 AND reason = 11 AND application.`user_id` = user_info.`user_id`)AS nghi_phep11,
	(SELECT SUM(application.`hours_off`) FROM application WHERE manager_ok =1 AND hrm_ok =1 AND reason = 12 AND application.`user_id` = user_info.`user_id`)AS nghi_phep12,
	(SELECT SUM(application.`hours_off`) FROM application WHERE manager_ok =1 AND hrm_ok =1 AND reason = 13 AND application.`user_id` = user_info.`user_id`)AS nghi_phep13
	
FROM user_info
HAVING nghi_phep2 != '' OR nghi_phep3 != ''