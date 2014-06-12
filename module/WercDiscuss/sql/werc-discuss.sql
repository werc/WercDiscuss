-- Adminer 4.0.2 MySQL dump
-- ZF2 WercDiscuss, Tomas Stryja, www.we-rc.com

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '+02:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DELIMITER ;;

DROP PROCEDURE IF EXISTS `r_discuss_traversal`;;
CREATE PROCEDURE `r_discuss_traversal`(
  IN paction VARCHAR(8),
  IN particleid MEDIUMINT, 
  IN pmessageid MEDIUMINT
)
BEGIN

  DECLARE new_lft, new_rgt, root_messageid, width, child MEDIUMINT;

  CASE paction

    WHEN 'insert' THEN
		
        SELECT rgt INTO new_lft FROM discuss WHERE message_id = pmessageid;
		
		START TRANSACTION;
	    IF new_lft IS NULL THEN
			SELECT message_id INTO root_messageid FROM discuss WHERE article_id = particleid AND lft = 1;
			IF root_messageid IS NULL THEN
				-- first comment
				INSERT INTO discuss (article_id, lft, rgt) VALUES (particleid, 1, 2);
				SELECT LAST_INSERT_ID() INTO root_messageid;
		    END IF; 
			
			SELECT rgt INTO new_lft FROM discuss WHERE message_id = root_messageid;
		END IF;
		UPDATE discuss SET rgt = rgt + 2 WHERE article_id = particleid AND rgt >= new_lft;
		UPDATE discuss SET lft = lft + 2 WHERE article_id = particleid AND lft > new_lft;
	    INSERT INTO discuss (article_id, lft, rgt) VALUES (particleid, new_lft, new_lft+1);
		COMMIT;

		SELECT LAST_INSERT_ID() AS lastInsertId;

    WHEN 'delete' THEN

        SELECT (rgt-lft) INTO child FROM discuss WHERE message_id = pmessageid;
        SELECT lft, rgt, (rgt-lft+1) INTO new_lft, new_rgt, width FROM discuss WHERE message_id = pmessageid;

        IF (child = 1) THEN
		  START TRANSACTION;
          DELETE FROM discuss WHERE article_id = particleid AND lft BETWEEN new_lft AND new_rgt;
          UPDATE discuss SET rgt = rgt - width WHERE article_id = particleid AND rgt > new_rgt;
          UPDATE discuss SET lft = lft - width WHERE article_id = particleid AND lft > new_rgt;
		  COMMIT;
        ELSE
		  START TRANSACTION;
          DELETE FROM discuss WHERE article_id = particleid AND lft = new_lft;
          UPDATE discuss SET rgt = rgt - 1, lft = lft - 1 WHERE article_id = particleid AND lft BETWEEN new_lft AND new_rgt;
          UPDATE discuss SET rgt = rgt - 2 WHERE article_id = particleid AND rgt > new_rgt;
          UPDATE discuss SET lft = lft -2 WHERE article_id = particleid AND lft > new_rgt;
		  COMMIT;	  
        END IF;
  
   END CASE;

END;;

DROP PROCEDURE IF EXISTS `r_discuss_tree`;;
CREATE PROCEDURE `r_discuss_tree`(

  IN particleid MEDIUMINT

)
BEGIN

  SELECT node.message_id, (COUNT(parent.message_id) - 1) AS depth,
  (SELECT post_time FROM discuss_messages WHERE message_id = node.message_id) AS post_time,
  (SELECT author_name FROM discuss_messages WHERE  message_id = node.message_id) AS author_name,
  (SELECT message FROM discuss_messages WHERE  message_id = node.message_id) AS message
  FROM discuss AS node, 
	   discuss AS parent
  WHERE
	node.article_id = particleid
	AND parent.article_id = particleid
    AND node.lft BETWEEN parent.lft AND parent.rgt
  GROUP BY node.message_id
  ORDER BY node.lft;


END;;

DELIMITER ;

DROP TABLE IF EXISTS `discuss`;
CREATE TABLE `discuss` (
  `message_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` mediumint(8) unsigned NOT NULL,
  `lft` smallint(5) unsigned NOT NULL,
  `rgt` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `article` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `discuss_messages`;
CREATE TABLE `discuss_messages` (
  `message_id` mediumint(8) unsigned NOT NULL,
  `post_time` datetime NOT NULL,
  `email` varchar(90) NOT NULL,
  `author_name` varchar(50) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`message_id`),
  CONSTRAINT `del_msg` FOREIGN KEY (`message_id`) REFERENCES `discuss` (`message_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='discuss node';

-- 2014-06-12 16:19:14
