drop table if exists comment;
drop table if exists article;

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
  parent_id smallint(5) UNSIGNED NOT NULL,
  level tinyint(5) UNSIGNED NOT NULL DEFAULT '0',
  date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  author varchar(100) NOT NULL,
  email varchar(255) DEFAULT NULL,
  content longtext NOT NULL,
  report smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  constraint fk_com_bil foreign key(id) references article(id),
  constraint fk_com_com foreign key(parent_id) references comment(id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


