CREATE USER IF NOT EXISTS 'vuotodb'@'%' IDENTIFIED BY 'kyberlinna';
GRANT ALL PRIVILEGES ON *.* TO 'vuotodb'@'%' WITH GRANT OPTION;

GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;

FLUSH PRIVILEGES;

CREATE TABLE IF NOT EXISTS users(  
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    create_time DATETIME COMMENT 'Create Time',
    username VARCHAR(255) NOT NULL COMMENT 'Username',
    password VARCHAR(255) NOT NULL COMMENT 'Password'
) COMMENT 'Intranet users';

CREATE TABLE IF NOT EXISTS meter_readings (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for the meter reading',
    customer_id VARCHAR(255) NOT NULL COMMENT 'Identifier for the customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp for when the meter reading was created',
    reading INT NOT NULL COMMENT 'The meter reading value'
) COMMENT 'Meter readings for customers';


INSERT INTO meter_readings (customer_id, reading) VALUES ('KLV-000001', 2000), ('KLV-000002', 3000), ('KLV-000003', 4000);

INSERT INTO users (username, password) VALUES ('admin', 'kyberlinna');