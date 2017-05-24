INSERT INTO `article` (`id`, `date_add`, `date_last_edit`, `title`, `content`) VALUES
  (1, '2017-05-12 16:15:34', NULL, 'Premier Billet', 'Bonjour,\r\n\r\ncomment ça va ?'),
  (2, '2017-05-15 16:15:34', NULL, 'deuxieme Billet', 'Bonjour,\r\n\r\ncomment ça va ?')
;


INSERT INTO `comment` (`id`, `article_id`, `parent_id`, `level`, `date_add`, `date_last_edit`, `author`, `email`, `content`, `report`) VALUES
  (1, 1, NULL, 0, '2017-05-12 16:17:28', NULL, 'Fremendream', 'fremendream@gmail.com', 'Coucou , moi ça va bien !', 0),
  (2, 1, NULL, 0, '2017-05-12 14:57:56', NULL, 'fred', NULL, 'moi aussi', 0);
