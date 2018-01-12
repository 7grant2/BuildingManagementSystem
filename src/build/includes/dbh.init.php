CREATE TABLE user (
       user_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
       user_fname  varchar(60) not null,
       user_lname varchar(60) not null,
       user_email varchar(60) not null,
       user_uname varchar(60) not null,
       user_pwd varchar(60) not null
);

CREATE TABLE floor(
    room_id int(11) UNIQUE NOT NULL PRIMARY KEY
);

CREATE TABLE room (
    room_id int(11) UNIQUE NOT NULL PRIMARY KEY,
    room_name varchar(70) NOT NULL
);

//smoke, occupany, motion
CREATE TABLE sensor (
    sensor_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    room_id int(11) NOT NULL,
    sensor_type varchar(60) NOT NULL,
    FOREIGN KEY (room_id) REFERENCES room (room_id)
)

CREATE TABLE reading (
    sensor_id int(11) NOT NULL,
    reading_date date NOT NULL,
    reading_time time NOT NULL,
    reading_value int(11) NOT NULL,
    FOREIGN KEY(sensor_id) REFERENCES sensor (sensor_id)
);

INSERT INTO sensor(room_id, sensor_type) VALUES (1, "OPTICAL");
INSERT INTO sensor(room_id, sensor_type) VALUES (1, "MOTION");
INSERT INTO sensor(room_id, sensor_type) VALUES (1, "SMOKE");

INSERT INTO sensor(room_id, sensor_type) VALUES (2, "OPTICAL");
INSERT INTO sensor(room_id, sensor_type) VALUES (2, "MOTION");
INSERT INTO sensor(room_id, sensor_type) VALUES (2, "SMOKE");

INSERT INTO sensor(room_id, sensor_type) VALUES (3, "OPTICAL");
INSERT INTO sensor(room_id, sensor_type) VALUES (3, "MOTION");
INSERT INTO sensor(room_id, sensor_type) VALUES (3, "SMOKE");

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

INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (9, '2017/01/08', '8:44:23', 0);
INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES (9, '2017/01/08', '11:41:53', 1);

