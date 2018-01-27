CREATE TABLE pkw (
 id bigint(20) NOT NULL AUTO_INCREMENT,
 "timestamp" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 client_ip varchar(65),
 session_id varchar(65) NOT NULL,
 vote_value varchar(65) NOT NULL,
 counter bigint(20) NOT NULL DEFAULT 1,
 PRIMARY KEY (id),
 UNIQUE KEY unique_ip (client_ip),
 UNIQUE KEY unique_session (session_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


$query_table_create = "
CREATE TABLE `pkw` (
 `id` bigint(20) NOT NULL AUTO_INCREMENT,
 `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `client_ip` varchar(65) DEFAULT NULL,
 `session_id` varchar(65) DEFAULT NULL,
 `vote_value` varchar(65) NOT NULL,
 `counter` bigint(20) NOT NULL DEFAULT 1,
 PRIMARY KEY (`id`),
 UNIQUE KEY `unique_ip` (`client_ip`),
 UNIQUE KEY `unique_session` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";