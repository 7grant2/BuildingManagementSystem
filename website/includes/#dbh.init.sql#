
CREATE DATABASE bms;

USE bms;


DELETE * FROM DATABASE glanham2015
USE glanham2015

CREATE TABLE users (
       user_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
       user_fname  varchar(60) NOT NULL,
       user_lname varchar(60) NOT NULL,
       user_email varchar(60) NOT NULL,
       user_uname varchar(60) NOT NULL,
       user_pwd varchar(60) NOT NULL,
       user_zip int(11) NOT NULL
);

CREATE TABLE building(
    building_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    building_name varchar(60) NOT NULL
);

CREATE TABLE users_building (
    user_id int(11) NOT NULL,
    building_id int(11) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (building_id) REFERENCES building(building_id) ON DELETE CASCADE,
    CONSTRAINT UNIQUE(user_id, building_id)
);

CREATE TABLE floor(
    floor_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    floor_name varchar(60),
    building_id int(11) NOT NULL,
    floor_num int(11) NOT NULL,    
    FOREIGN KEY (building_id) REFERENCES building(building_id) ON DELETE CASCADE
);

CREATE TABLE room (
    room_id int(11)  NOT NULL AUTO_INCREMENT PRIMARY KEY,
    room_name varchar(70),
    room_num int(11),
    floor_id int(11) NOT NULL,
    FOREIGN KEY (floor_id) REFERENCES floor(floor_id) ON DELETE CASCADE  
);

CREATE TABLE sensor (
    sensor_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    sensor_type varchar(60) NOT NULL,
    room_id int(11) NOT NULL,
    sensor_name VARCHAR(30) NOT NULL,
    FOREIGN KEY (room_id) REFERENCES room (room_id) ON DELETE CASCADE
);

CREATE TABLE reading (
    sensor_id int(11) NOT NULL,
    reading_date date NOT NULL,
    reading_time time NOT NULL,
    reading_value int(11) NOT NULL,
    FOREIGN KEY(sensor_id) REFERENCES sensor (sensor_id) ON DELETE CASCADE
);


CREATE TABLE permission (
    user_id int(11) NOT NULL UNIQUE,
    permission_sa boolean NOT NULL DEFAULT 0,
    permission_ems boolean NOT NULL DEFAULT 0,
    permission_admin boolean NOT NULL DEFAULT 0,
    FOREIGN KEY(user_id) REFERENCES users (user_id) ON DELETE CASCADE
);

CREATE TABLE address (
    building_id int(11) NOT NULL UNIQUE,
    address_street varchar(60) NOT NULL,
    address_city varchar(60) NOT NULL,
    address_state varchar(60) NOT NULL,
    address_zip int(11) NOT NULL,
    FOREIGN KEY (building_id) REFERENCES building (building_id) ON DELETE CASCADE
);


INSERT INTO users(user_fname, user_lname, user_email, user_uname, user_pwd) VALUES ('Super', 'Admin', 'glanham2015@fau.edu', 'root', '$2y$12$0O8t6HB4.1Fu9gxxbot20OIHlTHuMStUbsegzVbXjlQESIwk7y0nu');
INSERT INTO permission VALUES (1, 1, 0, 0);
INSERT INTO users(user_fname, user_lname, user_email, user_uname, user_pwd) VALUES ('John', 'Doe', 'grantjr7@gmail.com', 'bms', '$2y$12$H6Kc/aGMu3BEQKAph9gwRORUBtdwxEc5q70Hywourdms.bXZSoHnm');
INSERT INTO permission VALUES (2, 0, 0, 1);
INSERT INTO users(user_fname, user_lname, user_email, user_uname, user_pwd) VALUES ('bms', 'security', 'g@g.com', 'bmssec', '$2y$12$8f9iGqcbMkqEEhnx4sR/9ug0W3CI7RHMCaT0RNPplEBJgMjj.L8qy');
INSERT INTO permission VALUES (3, 0, 0, 0);
INSERT INTO users(user_fname, user_lname, user_email, user_uname, user_pwd) VALUES ('random', 'manager', 'g2@g.com', 'random', '$2y$12$5Q2tGIYIoHP/13qfxsI.x.cx0YdKS4eTsgQbf7u3ZVJ7aHUI2B6oY');
INSERT INTO permission VALUES (4, 0, 0, 1);
INSERT INTO users(user_fname, user_lname, user_email, user_uname, user_pwd) VALUES ('Fire', 'Department', 'g3@g.com', 'ems', '$2y$12$enB./K/Z5HiKUNfgqjWpwOZNSWCf9w4stQ0nDR0C.5oLWl0kxJSpq');
INSERT INTO permission VALUES (5, 0, 1, 0);

INSERT INTO building(building_name) VALUES ('FAU - EAST ENGINEERING');
INSERT INTO building(building_name) VALUES ('NURSING HOME');
INSERT INTO building(building_name) VALUES ('HOME');

INSERT INTO address VALUES (1, '777 Glades Road', 'Boca Raton', 'FL', '33431');
INSERT INTO address VALUES (2, '321 Fake Street', 'Boca Raton', 'FL', '33431');
INSERT INTO address VALUES (3, '3093 20th Drive', 'Boca Raton', 'FL', '33431');



INSERT INTO users_building(building_id, user_id) VALUES (1, 1);
INSERT INTO users_building(building_id, user_id) VALUES (2, 1);
INSERT INTO users_building(building_id, user_id) VALUES (3, 1);

INSERT INTO users_building(building_id, user_id) VALUES (2, 2);
INSERT INTO users_building(building_id, user_id) VALUES (2, 3);
INSERT INTO users_building(building_id, user_id) VALUES (1, 4);
INSERT INTO users_building(building_id, user_id) VALUES (3, 4);

INSERT INTO floor(floor_name, building_id, floor_num) VALUES ('FIRST FLOOR', 1, 1);
INSERT INTO floor(floor_name, building_id, floor_num) VALUES ('SECOND FLOOR', 1, 2);
INSERT INTO floor(floor_name, building_id, floor_num) VALUES ('THIRD FLOOR', 1, 3);
INSERT INTO floor(floor_name, building_id, floor_num) VALUES ('FOURTH FLOOR', 1, 4);
INSERT INTO floor(floor_name, building_id, floor_num) VALUES ('FIFTH FLOOR', 1, 5);
INSERT INTO floor(floor_name, building_id, floor_num) VALUES ('LIVING QUARTERS', 2, 1);
INSERT INTO floor(floor_name, building_id, floor_num) VALUES ('FIRST FLOOR', 3, 1);

INSERT INTO room(room_name, floor_id, room_num) VALUES ('CUBE 101', 1, 101);
INSERT INTO room(room_name, floor_id, room_num) VALUES ('CUBE 102', 1, 102);
INSERT INTO room(room_name, floor_id, room_num) VALUES ('CUBE', 1, 100);
INSERT INTO room(room_name, floor_id, room_num) VALUES ('EE 204', 2, 204);
INSERT INTO room(room_name, floor_id, room_num) VALUES ('EE 224', 2, 204);
INSERT INTO room(room_name, floor_id, room_num) VALUES ('ROOM 100', 6, 100);
INSERT INTO room(room_name, floor_id, room_num) VALUES ('ROOM 101', 6, 101);
INSERT INTO room(room_name, floor_id) VALUES ('LIVING ROOM', 7);

INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('CAPACITY', 1, 101);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('MOTION', 1, 102);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('SMOKE', 1, 103); 
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('CAPACITY', 2, 104);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('MOTION', 2, 105);
INSERT INTO sensor(sensor_type, room_id, sensor_name) VALUES ('SMOKE', 2, 106);
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

INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (1, '2017/01/08', '8:44:23', 3);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (1, '2017/01/08', '11:41:53', 4);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (2, '2017/01/08', '8:44:23', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (2, '2017/01/08', '11:41:53', 0);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (3, '2017/01/08', '8:44:23', 0);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (3, '2017/01/08', '11:41:53', 0);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (4, '2017/01/08', '8:44:23', 2);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (4, '2017/01/08', '11:41:53', 7);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (5, '2017/01/08', '8:44:23', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (5, '2017/01/08', '11:41:53', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (6, '2017/01/08', '8:44:23', 1);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (6, '2017/01/08', '11:41:53', 1);
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
