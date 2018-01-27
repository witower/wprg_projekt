<?php
// SQL QUERIES TO BE INCLUDED
$query_table_test = "SELECT count(*) FROM information_schema.TABLES WHERE (TABLE_SCHEMA = 's16125') AND (TABLE_NAME = 'pkw');";

$query_table_create = "
CREATE TABLE pkw (
    id bigint(20) NOT NULL AUTO_INCREMENT,
 `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 client_ip varchar(65),
 session_id varchar(65) NOT NULL,
 vote_value varchar(65) NOT NULL,
 counter bigint(20) NOT NULL DEFAULT 1,
 PRIMARY KEY (id),
 UNIQUE KEY unique_session (session_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

function query_check_client($sid,$cip)
{
    $cips="";
    if (!$cip=='') $cips="client_ip='{$cip}' OR";
    $str = "
SELECT count(*) AS matched FROM pkw 
  WHERE {$cips} session_id='{$sid}'
;";
    return $str;
}

function query_insert_vote($cip,$sid,$vote)
{
    return "
INSERT INTO pkw (client_ip,session_id,vote_value) VALUES 
  ('{$cip}','{$sid}','{$vote}')
;";
}
$query_results_all = "
SELECT vote_value AS Answer, count('vote_value') AS Votes  FROM pkw
  GROUP BY vote_value
;";

function query_results($value)
{
    return "
SELECT count(*) FROM pkw
  WHERE vote_value = '{$value}'
;";
}