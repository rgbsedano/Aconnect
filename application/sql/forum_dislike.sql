-- Forum dislike table for HeidiSQL
-- Contains id, post_id, and alumni_id as requested.

CREATE TABLE IF NOT EXISTS `forum_dislike` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `post_id` INT(11) NOT NULL,
  `alumni_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_forum_dislike_post_alumni` (`post_id`, `alumni_id`),
  KEY `idx_forum_dislike_post_id` (`post_id`),
  KEY `idx_forum_dislike_alumni_id` (`alumni_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
