
use car_maintenance;

create table customer
(customer_id   integer(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 name_first    varchar(50) NOT NULL,
 name_last     varchar(50) NOT NULL,
 phone         varchar(50) NOT NULL,
 email_address varchar(50) NOT NULL,
 comments      varchar(200) NOT NULL )
engine = INNODB;

create table address
(customer_id   integer(6) NOT NULL,
 address_id    integer(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 address_type  varchar(8) NOT NULL,
 address1      varchar(50) NOT NULL,
 address2      varchar(50),
 city          varchar(50) NOT NULL,
 state         varchar(2) NOT NULL,
 zip_code      varchar(10) NOT NULL  )
engine = INNODB;

create table vehicle
(customer_id      integer(6) NOT NULL,
 vehicle_id       integer(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 make             varchar(50) NOT NULL,
 model            varchar(50) NOT NULL,
 year             integer(4) NOT NULL,
 vin              varchar(30) NOT NULL,
 inspection_date  date  )
engine = INNODB;

create table vehicle_maintenance
(vehicle_id      integer(6) NOT NULL,
 maintenance_id  integer(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 mileage         integer(6) NOT NULL,
 model           varchar(50),
 maint_date      date NOT NULL,
 comments        varchar(512) NOT NULL )
engine = INNODB;

create table vehicle_maintenance_details
(maintenance_id  integer(6) NOT NULL,
 line_item_id    integer(6) NOT NULL,
 description     varchar(256) NOT NULL )
engine = INNODB;

