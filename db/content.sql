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
  parent_id smallint(5) UNSIGNED ,
  level tinyint(5) UNSIGNED DEFAULT '0',
  date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  author varchar(100) NOT NULL,
  email varchar(255) DEFAULT NULL,
  content longtext NOT NULL,
  report smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  constraint fk_com_bil foreign key(id) references article(id),
  constraint fk_com_com foreign key(parent_id) references comment(id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `article` (`id`, `date`, `title`, `content`) VALUES
  (1, '2017-05-12 16:15:34', 'Premier Billet', 'Bonjour,\r\n\r\ncomment ça va ?'),
  (2, '2017-05-15 16:15:34', 'deuxieme Billet', 'Bonjour,\r\n\r\ncomment ça va ?');

INSERT INTO `comment` (`id`, `article_id`, `parent_id`, `level`, `date`, `author`, `email`, `content`, `report`) VALUES
  (1, 1, NULL, NULL, '2017-05-12 16:17:28', 'Fremendream', 'fremendream@gmail.com', 'premier commentaire', 0),
  (2, 2, NULL, NULL, '2017-05-12 14:57:56', 'fred', NULL, 'moi aussi', 0),
  (3, 1, 1, NULL, '2017-05-12 15:33:46', 'fred', NULL, 'ah yeahhhhh', 0),
  (4, 1, 3, NULL, '2017-05-25 10:52:46', 'fredouille', 'fredouille@laposte.net', 'ceci est une réponse à un commentaire', 0),
  (5, 1, 3, NULL, '2017-05-25 10:52:46', 'fredouille', 'fredouille@laposte.net', 'et encore un post', 0),
  (6, 1, NULL, NULL, '2017-05-12 16:17:28', 'Fremendream', 'fremendream@gmail.com', 'Coucou , moi ça va bien !', 0),
  (7, 1, 1, NULL, '2017-05-25 10:52:46', 'fredouille', 'fredouille@laposte.net', 'que puis je dire', 0),
  (8, 1, 4, NULL, '2017-05-25 10:52:46', 'fredouille', 'fredouille@laposte.net', 'encore !', 0),
  (9, 1, NULL, NULL, '2017-05-26 15:12:53', 'anonymous', NULL, 'test', 0),
  (10, 1, NULL, NULL, '2017-05-26 15:15:33', 'anonymous', NULL, 'test', 0),
  (11, 1, NULL, NULL, '2017-05-26 15:16:01', 'anonymous', NULL, 'ceci est un commentaire de commentaire', 0),
  (12, 1, NULL, NULL, '2017-05-26 15:23:27', 'anonymous', NULL, 'commentaire avec message flash', 0),
  (13, 1, NULL, NULL, '2017-05-26 15:24:01', 'anonymous', NULL, 'commentaire avec message flash', 0);
