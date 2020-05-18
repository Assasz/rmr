## Resource-Method-Representation

More about this exact architecture [here](https://www.peej.co.uk/articles/rmr-architecture.html).
Code above is my own implementation variant, which came to life as a result of long nights 
in quarantine ;) It's still under development, though.

I would rather call it **ROR** (Resource-Operation-Representation) architecture, 
where controller logic is moved from resources to separate classes, **Operations**. 
They follow Request Handler pattern and actually act like Action components known 
from ADR architecture. 

### Installation

Via Composer:

```
composer create-project assasz/rmr=dev-master
```

Set up the database:

```
# .env
DATABASE_URL='mysql://user:secret@localhost/mydb'
```

```
./vendor/bin/doctrine orm:schema-tool:create
./vendor/bin/doctrine orm:schema-tool:update --force

php bin/console app:load-fixtures
```
