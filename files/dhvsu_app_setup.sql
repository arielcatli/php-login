DROP DATABASE dhvsu_app;
CREATE DATABASE dhvsu_app;

USE dhvsu_app;

-- DROP TABLE login_history, user;

CREATE TABLE IF NOT EXISTS user(
	id int(10) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(100) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    middle_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    address VARCHAR(200) NOT NULL,
    barangay VARCHAR(200) NOT NULL,
    city VARCHAR(100) NOT NULL,
    province VARCHAR(100) NOT NULL,
    zip VARCHAR(10) NOT NULL,
    gender VARCHAR(1) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    role VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS login_history(
	id int(10) AUTO_INCREMENT PRIMARY KEY,
    user_id int(10) NOT NULL,
    logged_in datetime NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id)
); 

CREATE TABLE IF NOT EXISTS course(
	id int(10) auto_increment PRIMARY KEY,
    code varchar(10) NOT NULL,
    name varchar(1000) NOT NULL,
    time_start TIME NOT NULL,
    time_end TIME NOT NULL
);

CREATE TABLE IF NOT EXISTS enrollment(
	id int(10) AUTO_INCREMENT PRIMARY KEY,
    user_id int(10) NOT NULL,
    course_id int(10) NOT NULL,
    enrolled_on DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (course_id) REFERENCES course(id)
);

-- SELECT dhvsu_app.course.id, dhvsu_app.course.name, dhvsu_app.course.time_start, dhvsu_app.course.time_end, dhvsu_app.course.code, dhvsu_app.enrollment.user_id
-- FROM dhvsu_app.enrollment INNER JOIN dhvsu_app.course ON dhvsu_app.course.id WHERE user_id = 1;

-- SELECT enrollment.course_id, course.name, course.code, course.time_start, course.time_end FROM enrollment INNER JOIN course ON enrollment.course_id = course.id WHERE user_id = '1';

-- DELETE FROM dhvsu_app.enrollment WHERE dhvsu_app.enrollment.course_id = '1' and dhvsu_app.enrollment.user_id = '1';



-- SELECT * FROM dhvsu_app.login_history;

INSERT into dhvsu_app.user (username, password, first_name, middle_name, last_name, address, barangay, city, province, zip, gender, phone, role)
values('administrator@gmail.com', 'administrator', 'Jerome', 'Maglaqui', 'Catli', '591 Purok 5', 'San Juan', 'San Luis', 'Pampanga', '2014', 'M', '+639397744774', 'administrator');


-- UPDATE dhvsu_app.user SET first_name = 'Neil', middle_name = 'Maglaqui', last_name = 'Catli', address = '900 Purok 9', barangay = 'San Juan', city = 'San Luis', province = 'Pampanga', zip = '2014', gender = 'M', phone = '' WHERE username = 'jeromecatli@gmail.com';