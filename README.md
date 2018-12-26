# ToasterDO
Simple TODO application.

You can see [DEMO](http://demo.bitabit.com.ua/). 
* login:     `test@test.com`
* password:  `1234 `

##Installation
###Docker
Use  [Docker](https://www.docker.com/) container platform.
* paste in console`docker-compose up --build`
* go database server `localhost:6080`
* import `toasterdo.sql` in `toasterdo` table
* go app `localhost::8080`
###Other
* copy folder `toasterdo` in host
* import database `toasterdo/toasterdo.sql` 
* set up configuration `toasterdo/aplication/config.php`
###Configuration
**application/config.php** -config file for web-app.
* DB **host** - ``define('DB_HOST', 'localhost');`` 
* DB **name** - ``define('DB_NAME', 'toasterdo');`` 
* DB **user** - ``define('DB_USER', 'root');`` 
* DB **pass** - ``define('DB_PASS', '');``

