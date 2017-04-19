CREATE TABLE user (
username VARCHAR(20) PRIMARY KEY,
salt VARCHAR(20),
hashed_password VARCHAR(256));
