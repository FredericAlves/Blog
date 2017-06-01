DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS article;
DROP TABLE IF EXISTS user;

CREATE TABLE article (
  id smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  title varchar(100) NOT NULL,
  content text NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE comment (
  id smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  article_id smallint(5) UNSIGNED NOT NULL,
  parent_id smallint(5) UNSIGNED,
  date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  author varchar(100) NOT NULL,
  content longtext NOT NULL,
  report tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  CONSTRAINT del_casc FOREIGN KEY (article_id) REFERENCES article(id) ON DELETE CASCADE,
  constraint fk_com_com foreign key(parent_id) references comment(id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE user (
  id smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL ,
  password VARCHAR(88) NOT NULL ,
  salt VARCHAR(23) NOT NULL ,
  role VARCHAR(50) NOT NULL,
  PRIMARY KEY (id)
  ) engine=innodb character set utf8 collate utf8_unicode_ci;
