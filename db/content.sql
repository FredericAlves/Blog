INSERT INTO `article` (`id`, `date`, `title`, `content`) VALUES
  (1, '2017-05-12 16:15:34', 'Premier Billet', 'Bonjour,\r\n\r\ncomment ça va ?'),
  (2, '2017-05-15 16:15:34', 'deuxieme Billet', 'Bonjour,\r\n\r\ncomment ça va ?');

INSERT INTO `comment` (`id`, `article_id`, `parent_id`, `date`, `author`, `content`, `report`) VALUES
  (6, 1, 5, '2017-05-30 15:42:18', 'Fred', 'Oui je trouve !!!!!', 0),
  (5, 1, 4, '2017-05-30 15:41:53', 'Fremen', 'tu trouves ???', 0),
  (4, 1, NULL, '2017-05-30 15:41:26', 'Fred', 'Wouaa super billet !', 0),
  (7, 1, 5, '2017-05-30 15:44:29', 'Titi ', 'Ouaiii t\'as raison !', 0);


insert into user values
  (1, 'jean', '$2y$13$F9v8pl5u5WMrCorP9MLyJeyIsOLj.0/xqKd/hqa5440kyeB7FQ8te', 'YcM=A$nsYzkyeDVjEUa7W9K', 'ROLE_USER', 'Jean Forteroche');


insert into user values
  (3, 'admin', '$2y$13$A8MQM2ZNOi99EW.ML7srhOJsCaybSbexAj/0yXrJs4gQ/2BqMMW2K', 'EDDsl&fBCJB|a5XUtAlnQN8', 'ROLE_ADMIN', 'Admin du site');