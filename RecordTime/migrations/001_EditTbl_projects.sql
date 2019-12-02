ALTER TABLE tbl_projects
ADD description text,
ADD status int(11) NOT NULL DEFAULT '0',
ADD start_date date,
ADD project_cost decimal(11,2) DEFAULT NULL,
ADD end_date date,
ADD price_per_song decimal(11,2) DEFAULT 0,
ADD producer_id int(11) DEFAULT NULL,
ADD FOREIGN KEY (producer_id) REFERENCES tbl_user(id);
--
