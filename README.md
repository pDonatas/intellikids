### How to setup the project

For Unix systems, you can use the following commands to setup the project:

```bash
    git clone https://github.com/pDonatas/intellikids.git
    cd intellikids
    sh init.sh
```

For others:

1. Clone the repository
2. Copy .env.example to .env
3. Copy docker-compose.example.yml to docker-compose.yml
4. Run docker-compose up -d
5. Run docker-compose exec app composer install
6. Run docker-compose exec app php artisan key:generate
7. Run docker-compose exec app php artisan migrate
8. Run docker-compose exec app php artisan db:seed
9. Enjoy!

To run tests, run `docker-compose exec app php artisan test`

Postman collection file is located in the root of the project named `api.json`.
You can import it to your Postman and test the API.

Default user credentials:
```
email: admin@email.com
password: S8perpass1.
```

### API Endpoints

#### Auth

##### Login

```
POST /api/login
```

Request body:
```json
{
    "email": "admin@email.com",
    "password": "S8perpass1."
}
```

##### Register

```
POST /api/register
```

Request body:
```json
{
    "name": "John Doe",
    "email": "email@domain.tld",
    "password": "password",
    "password_confirmation: "password"
}
```

##### Logout

```
    GET /api/logout
```

#### Router

```
    GET /{any}
```

#### Urls

##### List

```
    GET /api/urls
```

##### Create

```
    POST /api/urls
```

Request body:
```json
{
    "long_url": "https://google.com",
    "short_url": "google", // optional
    "expires_at": "2021-01-01 00:00" // optional
}
```

##### Show

```
    GET /api/urls/{id}
```

##### Update

```
    PATCH /api/urls/{id}
```

Request body:
```json
{
    "url": "https://google.com", // optional
    "short_url": "google", // optional
    "expires_at": "2021-01-01 00:00" // optional
}
```

##### Delete

```
    DELETE /api/urls/{id}
```
