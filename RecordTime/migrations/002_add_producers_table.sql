CREATE TABLE IF NOT EXISTS `producers` (
  id int(11) NOT NULL auto_increment,
  PRIMARY KEY  (id),
  user_id int(11) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES tbl_user(id),
  philosophy text,
  genres text,
  skills text
);

-- seed data
