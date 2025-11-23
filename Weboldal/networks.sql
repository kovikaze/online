create database if not exists electric;
use electric;

CREATE TABLE products (
  id int AUTO_INCREMENT primary key,
  name varchar(100),
  type varchar(20),
  value varchar(20),
  price decimal( 10,2 ),
  created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

insert into products set name="ESP-32", type="MPU", value="32bit", price=1800.66; 
insert into products set name="STM32F407", type="MPU", value="32bit", price=3500;
insert into products set name="STLink", type="Tool", value="", price=500.15;

create user 'api'@'%' identified by '12345678';
grant all on electric.* to 'api'@'%';
