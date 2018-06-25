// root / root /   grantjr7@gmail.com
// asdf / asdf /   glanham2015@gmail.com
// CHANGE ID FOR INSERT STATEMENTS UPON REVIEW
$dbhost = 'localhost';  // Most likely will not need to be changed
$dbname = '';   // Needs to be changed to your designated table database name
$dbuser = '';   // Needs to be changed to reflect your LAMP server credentials
$dbpass = ''; // Needs to be changed to reflect your LAMP server credentials




CREATE DATABASE bms;

CREATE TABLE users (
       user_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
       user_fname  varchar(60) NOT NULL,
       user_lname varchar(60) NOT NULL,
       user_email varchar(60) NOT NULL,
       user_uname varchar(60) NOT NULL,
       user_pwd varchar(60) NOT NULL
);


CREATE TABLE building(
    building_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    building_name varchar(60) NOT NULL,
    user_id int(11) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE floor(
    floor_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    floor_name varchar(60),
    building_id int(11) NOT NULL,
    floor_num int(11) NOT NULL,    
    FOREIGN KEY (building_id) REFERENCES building(building_id)
);

CREATE TABLE room (
    room_id int(11)  NOT NULL AUTO_INCREMENT PRIMARY KEY,
    room_name varchar(70),
    room_num int(11),
    floor_id int(11) NOT NULL,
    FOREIGN KEY (floor_id) REFERENCES floor(floor_id)    
);

//smoke, occupany, motion
CREATE TABLE sensor (
    sensor_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    sensor_type varchar(60) NOT NULL,
    room_id int(11) NOT NULL,
    sensor_name VARCHAR(30) NOT NULL,
    FOREIGN KEY (room_id) REFERENCES room (room_id)
);

CREATE TABLE reading (
    sensor_id int(11) NOT NULL,
    reading_date date NOT NULL,
    reading_time time NOT NULL,
    reading_value int(11) NOT NULL,
    FOREIGN KEY(sensor_id) REFERENCES sensor (sensor_id)
);

//change user_id
INSERT INTO building(building_name, user_id) VALUES ('NURSING HOME', 1);
INSERT INTO building(building_name, user_id) VALUES ('SCHOOL', 2);
INSERT INTO building(building_name, user_id) VALUES ('HOME', 2);

//change building id
INSERT INTO floor(floor_name, building_id, floor_num) VALUES ('LIVING QUARTERS', 1, 1);
INSERT INTO floor(floor_name, building_id, floor_num) VALUES ('LIVING QUARTERS', 2, 1);
INSERT INTO floor(floor_name, building_id, floor_num) VALUES ('SUPPLIES', 3, 1);
INSERT INTO floor(building_id, floor_num) VALUES (4, 2);

INSERT INTO room(room_name, floor_id, room_num) VALUES ('ROOM A', 11, 101);
INSERT INTO room(room_name, floor_id, room_num) VALUES ('ROOM B', 11, 120);

INSERT INTO room(room_name, floor_id, room_num) VALUES ('ROOM A', 2, 183);
INSERT INTO room(room_name, floor_id, room_num) VALUES ('ROOM B', 2, 123);
INSERT INTO room(room_name, floor_id, room_num) VALUES ('ROOM A', 3, 146);
INSERT INTO room(room_name, floor_id, room_num) VALUES ('ROOM B', 3, 199);
INSERT INTO room(room_name, floor_id, room_num) VALUES ('ROOM A', 4, 202);
INSERT INTO room(room_name, floor_id, room_num) VALUES ('ROOM B', 4, 212);

INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('CAPACITY', 25, 101);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('MOTION', 25, 102);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('SMOKE', 25, 103);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('CAPACITY', 26, 104);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('MOTION', 26, 105);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('SMOKE', 26, 106);

INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('CAPACITY', 3, 107);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('MOTION', 3, 108);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('SMOKE', 3, 109);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('CAPACITY', 4, 110);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('MOTION', 4, 111);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('SMOKE', 4, 112);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('CAPACITY', 5, 113);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('MOTION', 5, 114);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('SMOKE', 5, 115);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('CAPACITY', 6, 116);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('MOTION', 6, 117);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('SMOKE', 6, 118);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('CAPACITY', 7, 119);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('MOTION', 7, 120);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('SMOKE', 7, 121);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('CAPACITY', 8, 122);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('MOTION', 8, 123);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('SMOKE', 8, 124);

INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (49, '2017/01/08', '8:44:23', 3);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (49, '2017/01/08', '11:41:53', 4);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (50, '2017/01/08', '8:44:23', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (50, '2017/01/08', '11:41:53', 0);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (51, '2017/01/08', '8:44:23', 0);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (51, '2017/01/08', '11:41:53', 0);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (52, '2017/01/08', '8:44:23', 2);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (52, '2017/01/08', '11:41:53', 7);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (53, '2017/01/08', '8:44:23', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (53, '2017/01/08', '11:41:53', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (54, '2017/01/08', '8:44:23', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (54, '2017/01/08', '11:41:53', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (7, '2017/01/08', '8:44:23', 2);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (7, '2017/01/08', '11:41:53', 2);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (8, '2017/01/08', '8:44:23', 0);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (8, '2017/01/08', '11:41:53', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (9, '2017/01/08', '8:44:23', 3);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (9, '2017/01/08', '11:41:53', 4);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (10, '2017/01/08', '8:44:23', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (10, '2017/01/08', '11:41:53', 0);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (11, '2017/01/08', '8:44:23', 0);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (11, '2017/01/08', '11:41:53', 0);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (12, '2017/01/08', '8:44:23', 2);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (12, '2017/01/08', '11:41:53', 7);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (13, '2017/01/08', '8:44:23', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (13, '2017/01/08', '11:41:53', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (14, '2017/01/08', '8:44:23', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (14, '2017/01/08', '11:41:53', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (15, '2017/01/08', '8:44:23', 2);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (15, '2017/01/08', '11:41:53', 2);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (15, '2017/01/08', '8:44:23', 0);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (15, '2017/01/08', '11:41:53', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (16, '2017/01/08', '8:44:23', 3);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (16, '2017/01/08', '11:41:53', 4);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (17, '2017/01/08', '8:44:23', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (17, '2017/01/08', '11:41:53', 0);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (18, '2017/01/08', '8:44:23', 0);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (18, '2017/01/08', '11:41:53', 0);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (18, '2017/01/08', '8:44:23', 2);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (18, '2017/01/08', '11:41:53', 7);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (19, '2017/01/08', '8:44:23', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (19, '2017/01/08', '11:41:53', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (20, '2017/01/08', '8:44:23', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (20, '2017/01/08', '11:41:53', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (21, '2017/01/08', '8:44:23', 2);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (21, '2017/01/08', '11:41:53', 2);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (22, '2017/01/08', '8:44:23', 0);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (22, '2017/01/08', '11:41:53', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (23, '2017/01/08', '8:45:22', 2);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (23, '2017/01/08', '8:74:23', 0);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (24, '2017/01/08', '8:46:23', 3);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (24, '2017/01/08', '8:43:24', 0);



//CLEAR TABLES
DROP TABLE building;
DROP TABLE reading;
DROP TABLE room;
DROP TABLE sensor;
DROP TABLE users;
