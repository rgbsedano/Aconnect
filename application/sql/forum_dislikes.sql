-- Forum dislikes table
-- Run in HeidiSQL against your Aconnect database.

CREATE TABLE IF NOT EXISTS `forum_dislikes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `post_id` INT(11) NOT NULL,
  `alumni_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_forum_dislikes_post_alumni` (`post_id`, `alumni_id`),
  KEY `idx_forum_dislikes_post_id` (`post_id`),
  KEY `idx_forum_dislikes_alumni_id` (`alumni_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
