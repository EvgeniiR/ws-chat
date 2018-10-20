Online chat on websocket using Swoole (https://www.swoole.co.uk/)
Working example here: http://62.109.21.96/

For using on local machine:
1. pecl install swoole
2. Create MySQL database "ws-chat" and create table messages.
SQL code:

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

3. mv ws-chat/app/DBConfig.php.sample ws-chat/app/DBConfig.php and configure it.
4. Configure nginx: https://www.nginx.com/blog/websocket-nginx/
5. start server: 
 - php ws-chat/ws_start_server.php
