Online chat on websocket using Swoole (https://www.swoole.co.uk/)

For using on local machine:
1. Make sure you have installed Docker and Docker-compose
2. Clone project using Git and enter project directory
3. cp src/Config.php.sample src/Config.php and configure it.
   cp ./docker/env-example ./docker/.env and configure it.
4. cd docker; docker-compose build && docker-compose up -d
5. docker exec -it ws_chat_workspace bash
   npm install
   composer install
   php bin/console app:database:create
   php bin/console app:migration:migrate (Enter nothing when it`ll ask about the version)
   
   (May be someday I will automate this process)
   
