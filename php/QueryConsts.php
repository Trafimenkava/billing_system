<?php
interface QueryConsts {
	/* SELECT QUERIES */
	const GET_USER_BY_EMAIL_QUERY = "SELECT * FROM users WHERE email = '?'";
	const GET_SERVICES_QUERY = "SELECT * FROM services";
	const GET_SERVICE_BY_SERVICE_ID_QUERY = "SELECT * FROM services WHERE service_id = ?";
	const GET_ACCOUNT_BY_SERVICE_ID_QUERY = "SELECT * FROM accounts WHERE service_id = ?";
	const GET_SERVICES_BY_CLIENT_ID_QUERY = "SELECT * FROM clients INNER JOIN services ON clients.client_id = services.client_id WHERE clients.client_id = ?";
	const GET_TARIFF_PLAN_GROUPS_QUERY = "SELECT * FROM tariff_plans_groups";
	const GET_TARIFF_PLAN_GROUP_BY_TITLE_QUERY = "SELECT * FROM tariff_plans_groups WHERE title LIKE '%?%'";
	const GET_TARIFF_PLAN_GROUP_BY_TARIFF_PLAN_GROUP_ID_QUERY = "SELECT * FROM tariff_plans_groups WHERE tariff_plan_group_id = ?";
	const GET_TARIFF_PLANS_QUERY = "SELECT * FROM tariff_plans";
	const GET_ACTIVE_TARIFF_PLANS_QUERY = "SELECT * FROM tariff_plans WHERE state = 'Действующий'";
	const GET_TARIFF_PLAN_BY_TARIFF_PLAN_GROUP_ID_QUERY = "SELECT * FROM tariff_plans WHERE tariff_plan_group_id = ?";
	const GET_TARIFF_PLAN_BY_TARIFF_PLAN_TITLE_QUERY = "SELECT * FROM tariff_plans WHERE title LIKE '?'";
	const GET_TARIFF_PLAN_BY_TARIFF_PLAN_ID_QUERY = "SELECT *, tariff_plans.title AS tariff_plan_title, tariff_plans_groups.title AS tariff_plan_group_title, tariff_plans.description AS tariff_plan_description FROM tariff_plans INNER JOIN tariff_plans_groups USING (tariff_plan_group_id) WHERE tariff_plan_id = ?";
	const GET_TARIFF_PLANS_FOR_RECOMMENDATION_QUERY = "SELECT * FROM tariff_plans WHERE ? IS NOT NULL AND subscription_fee BETWEEN ? AND ? AND state = 'Действующий'";
	const ADDITIONAL_CHECK_FOR_AMOUNT_OF_FAVORITE_NUMBERS = " AND favorite_numbers_amount = ?";
	const ADDITIONAL_CHECK_FOR_PRESENCE_OF_INTERNATIONAL_CALLS = " AND international_calls_traffic_min IS NOT NULL";
	const ADDITIONAL_CHECK1_FOR_INTERNET_TRAFFIC = " AND internet_traffic_mb BETWEEN ? AND ? and internet_traffic_mb not in ('БЕЗЛИМИТ')";
	const ADDITIONAL_CHECK2_FOR_INTERNET_TRAFFIC = " AND (internet_traffic_mb > ? OR internet_traffic_mb in ('БЕЗЛИМИТ'))";		
	const GET_ALL_CLIENTS_QUERY = "SELECT * FROM users LEFT JOIN clients ON users.user_id = clients.client_id ORDER BY surname ASC";
	const GET_CLIENTS_QUERY = "SELECT * FROM users LEFT JOIN clients ON users.user_id = clients.client_id ORDER BY surname ASC LIMIT 10 OFFSET ?";
	const GET_CLIENT_BY_ID_QUERY = "SELECT * FROM users LEFT JOIN clients ON users.user_id = clients.client_id WHERE users.user_id = ?";
	const GET_CLIENT_BY_FIO_QUERY = "SELECT * FROM users LEFT JOIN clients ON users.user_id = clients.client_id WHERE CONCAT(surname, ' ', name, ' ', lastname) like '%?%'";
	const GET_MIN_AND_MAX_SUBSCRIPTION_FEE_QUERY = "SELECT MIN(subscription_fee) as min_subscription_fee, MAX(subscription_fee) as max_subscription_fee FROM tariff_plans";
	const GET_NOTIFICATION_BY_NOTIFICATION_ID_QUERY = "SELECT * FROM notifications WHERE notification_id = '?'";
	const GET_NOTIFICATION_BY_TRIGGER_TYPE_QUERY = "SELECT * FROM notifications WHERE trigger_type LIKE '?'";
	const GET_NOTIFICATIONS_QUERY = "SELECT * FROM notifications";
	const GET_POPULAR_TARIFF_PLANS_QUERY = "SELECT title, COUNT(tariff_plans.tariff_plan_id) as amount FROM services INNER JOIN tariff_plans ON services.tariff_plan_id = tariff_plans.tariff_plan_id GROUP BY tariff_plans.tariff_plan_id ORDER BY amount DESC LIMIT 10";
	const GET_DISTRIBUTION_OF_TARIFF_PLANS_QUERY = "SELECT tariff_plans_groups.title, COUNT(tariff_plans.tariff_plan_id) as amount FROM tariff_plans INNER JOIN tariff_plans_groups ON tariff_plans.tariff_plan_group_id = tariff_plans_groups.tariff_plan_group_id GROUP BY tariff_plans.tariff_plan_group_id ORDER BY amount DESC LIMIT 10";
	const GET_MONTHLY_SERVICES_QUERY = "SELECT connection_date, COUNT(service_id) AS amount FROM services WHERE MONTH(connection_date) = MONTH(DATE_ADD(NOW(), INTERVAL -1 MONTH)) AND YEAR(connection_date) = YEAR(NOW()) GROUP BY connection_date";
	
	/* INSERT QUERIES */
	const ADD_TARIFF_PLAN_QUERY = "INSERT INTO tariff_plans(title, description, tariff_plan_group_id, internet_traffic_mb, phone_traffic_within_network_min, phone_traffic_all_networks_min, international_calls_traffic_min, sms_within_network, sms_all_networks, mms_within_network, mms_all_networks, favorite_numbers_amount, state, subscription_fee) values('?', '?', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '?', ?)";
	const ADD_TARIFF_PLAN_GROUP_QUERY = "INSERT INTO tariff_plans_groups(title, description) VALUES('?', '?')";
	const ADD_USER_QUERY = "INSERT INTO users(name, surname, lastname, email, password, registration_date, is_admin) VALUES('?', '?', '?', '?', '?', '?', ?)";
	const ADD_CLIENT_ID_QUERY = "INSERT INTO clients(client_id) VALUES(?)";
	const ADD_SERVICE_QUERY = "INSERT INTO services(client_id, tariff_plan_id, telephone_number, status) VALUES(?, ?, '?', '?')";
	const ADD_ACCOUNT_QUERY = "INSERT INTO accounts(service_id) VALUES(?)";
	const ADD_NOTIFICATION_QUERY = "INSERT INTO notifications (send_to, send_from, subject, content, trigger_type) VALUES ('?', '?', '?', '?', '?')";
	
	/* UPDATE QUERIES */
	const UPDATE_TARIFF_PLAN_QUERY = "UPDATE tariff_plans SET title = '?', description = '?', tariff_plan_group_id = ?, internet_traffic_mb = ?, phone_traffic_within_network_min = ?, phone_traffic_all_networks_min = ?, international_calls_traffic_min = ?, sms_within_network = ?, sms_all_networks = ?, mms_within_network = ?, mms_all_networks = ?, favorite_numbers_amount = ?, state = '?', subscription_fee = ? WHERE tariff_plan_id = ?";
	const UPDATE_TARIFF_PLAN_GROUP_QUERY = "UPDATE tariff_plans_groups SET title = '?', description = '?' WHERE tariff_plan_group_id = ?";
	const UPDATE_USER_QUERY = "UPDATE users SET name = '?', surname = '?', lastname = '?', email = '?', is_admin = ? WHERE user_id = ?";
	const UPDATE_USER_IMAGE_QUERY = "UPDATE users SET image = '?' WHERE user_id = ?";
	const UPDATE_CLIENT_QUERY = "UPDATE clients SET passport_number = '?', birthday_date = '?', address = '?', card_number = '?' WHERE client_id = ?";
	const UPDATE_NOTIFICATION_QUERY = "UPDATE notifications SET send_to = '?', send_from = '?', subject = '?', content = '?', trigger_type = '?' WHERE notification_id = ?";
	
	/* DELETE QUERIES */
	const DELETE_USER_BY_USER_ID_QUERY = "DELETE FROM users WHERE user_id = ?";
	const DELETE_CLIENT_BY_CLIENT_ID_QUERY = "DELETE FROM clients WHERE client_id = ?";
	const DELETE_TARIFF_PLAN_BY_TARIFF_PLAN_ID_QUERY = "DELETE FROM tariff_plans WHERE tariff_plan_id = ?";
	const DELETE_TARIFF_PLAN_GROUP_BY_TARIFF_PLAN_GROUP_ID_QUERY= "DELETE FROM tariff_plans_groups WHERE tariff_plan_group_id = ?";
	const DELETE_NOTIFICATION_BY_NOTIFICATION_ID_QUERY = "DELETE FROM notifications WHERE notification_id = ?";
}
?>