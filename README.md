## Resource-Method-Representation

More about this exact architecture [here](https://www.peej.co.uk/articles/rmr-architecture.html).
Code above is my own implementation variant, which came to life as a result of long nights 
in quarantine ;) It's still under development, though.

I would rather call it **ROR** (Resource-Operation-Representation) architecture, 
where controller logic is moved from resources to separate classes, **Operations**. 
They follow Request Handler pattern and actually act like Action components known 
from ADR architecture. 

**Resources** are in turn a core of business (or application) layer,
where high-level business logic is applied on domain objects. But they're still aware 
of a RESTful system. Resources respond to the standard HTTP methods and - still - have 
a bit of controller inside (e.g. they can throw HTTP exceptions).

**Representation** of the resource is just a formatted content of the response.
Operation should not know the output format of the resource, but it should expose that
resource in normalized form instead - then it's formatter's responsibility to render 
resource in a wire format - JSON or XML in this case. 

### Installation

Clone repository and install dependencies:

```
git clone https://github.com/Assasz/rmr.git
composer install
```

Set up the database:

```
# .env
DATABASE_URL='mysql://user:secret@localhost/mydb'
```

```
./vendor/bin/doctrine orm:schema-tool:create
./vendor/bin/doctrine orm:schema-tool:update --force
```

(I will add some fixtures later.)