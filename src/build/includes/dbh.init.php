// root / root /   grantjr7@gmail.com
// asdf / asdf /   glanham2015@gmail.com
// CHANGE ID FOR INSERT STATEMENTS UPON REVIEW


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
    FOREIGN KEY (building_id) REFERENCES building(building_id)
);

CREATE TABLE room (
    room_id int(11)  NOT NULL AUTO_INCREMENT PRIMARY KEY,
    room_name varchar(70),
    floor_id int(11) NOT NULL,
    FOREIGN KEY (floor_id) REFERENCES floor(floor_id)    
);

//smoke, occupany, motion
CREATE TABLE sensor (
    sensor_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    sensor_type varchar(60) NOT NULL,
    room_id int(11) NOT NULL,
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
INSERT INTO building(building_name, user_id) VALUES ("NURSING HOME", 24);
INSERT INTO building(building_name, user_id) VALUES ("SCHOOL", 25);
INSERT INTO building(building_name, user_id) VALUES ("HOME", 25);

//change building id
INSERT INTO floor(floor_name, building_id) VALUES ("LIVING QUARTERS", "3");
INSERT INTO floor(floor_name, building_id) VALUES ("LIVING QUARTERS", "4");
INSERT INTO floor(floor_name, building_id) VALUES ("SUPPLIES", "5");
INSERT INTO floor(building_id) VALUES ("5");

INSERT INTO room(room_name, floor_id) VALUES ("ROOM A", 2);
INSERT INTO room(room_name, floor_id) VALUES ("ROOM B", 2);
INSERT INTO room(room_name, floor_id) VALUES ("ROOM A", 3);
INSERT INTO room(room_name, floor_id) VALUES ("ROOM B", 3);
INSERT INTO room(room_name, floor_id) VALUES ("ROOM A", 4);
INSERT INTO room(room_name, floor_id) VALUES ("ROOM B", 4);
INSERT INTO room(room_name, floor_id) VALUES ("ROOM A", 5);
INSERT INTO room(room_name, floor_id) VALUES ("ROOM B", 5);

INSERT INTO sensor(sensor_type, room_id) VALUES ("OPTICAL", 1);
INSERT INTO sensor(sensor_type, room_id) VALUES ("MOTION", 1);
INSERT INTO sensor(sensor_type, room_id) VALUES ("SMOKE", 1);
INSERT INTO sensor(sensor_type, room_id) VALUES ("OPTICAL", 2);
INSERT INTO sensor(sensor_type, room_id) VALUES ("MOTION", 2);
INSERT INTO sensor(sensor_type, room_id) VALUES ("SMOKE", 2);
INSERT INTO sensor(sensor_type, room_id) VALUES ("OPTICAL", 3);
INSERT INTO sensor(sensor_type, room_id) VALUES ("MOTION", 3);
INSERT INTO sensor(sensor_type, room_id) VALUES ("SMOKE", 3);
INSERT INTO sensor(sensor_type, room_id) VALUES ("OPTICAL", 4);
INSERT INTO sensor(sensor_type, room_id) VALUES ("MOTION", 4);
INSERT INTO sensor(sensor_type, room_id) VALUES ("SMOKE", 4);
INSERT INTO sensor(sensor_type, room_id) VALUES ("OPTICAL", 5);
INSERT INTO sensor(sensor_type, room_id) VALUES ("MOTION", 5);
INSERT INTO sensor(sensor_type, room_id) VALUES ("SMOKE", 5);
INSERT INTO sensor(sensor_type, room_id) VALUES ("OPTICAL", 6);
INSERT INTO sensor(sensor_type, room_id) VALUES ("MOTION", 6);
INSERT INTO sensor(sensor_type, room_id) VALUES ("SMOKE", 6);
INSERT INTO sensor(sensor_type, room_id) VALUES ("OPTICAL", 7);
INSERT INTO sensor(sensor_type, room_id) VALUES ("MOTION", 7);
INSERT INTO sensor(sensor_type, room_id) VALUES ("SMOKE", 7);
INSERT INTO sensor(sensor_type, room_id) VALUES ("OPTICAL", 8);
INSERT INTO sensor(sensor_type, room_id) VALUES ("MOTION", 8);
INSERT INTO sensor(sensor_type, room_id) VALUES ("SMOKE", 8);

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



//CLEAR TABLES
DROP TABLE building;
DROP TABLE reading;
DROP TABLE room;
DROP TABLE sensor;
DROP TABLE users;