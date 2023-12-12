## Reminder App Using Laravel 10.x

Example Rest Api

### Feature

- Register & Login User Sanctum (Token Lifetime only 20 second)
- Refresh Token User Sanctum
- Create, Read, Update, Detail Reminder App 

## Requirement
- <= php 8.2
- Mysql / 10.4.8-MariaDB (Tested)
- Docker
- Postman Collection V2.1

## Command

### Installation

  - Create Database `db_reminder`
  - rename `.env.example` to `.env`
  - change the config line
  ```env
    DB_HOST=docker.for.mac.localhost // if you are using docker desktop for mac
    DB_PORT=3306
    DB_DATABASE=db_reminder
    DB_USERNAME=root
    DB_PASSWORD=

    MAIL_MAILER=smtp
    MAIL_HOST=sandbox.smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=""
    MAIL_FROM_NAME="${APP_NAME}"
  ```

### Deploy With Docker

  - Go to `src` directory

  ```sh
  $ cd src
  ```

  - Build and run container using `docker compose`

  ```sh
  $ docker compose up -d
  ```

  - Stop container using `docker compose`

  ```sh
  $ docker compose stop
  ```

  - Stop, remove container using `docker compose`

  ```sh
  $ docker compose down
  ```

  - Stop, remove container & images using `docker compose`

  ```sh
  $ docker compose down --rmi local
  ```


## Run API in Postman

- Open Postman
- Import Collection from folder `postman/Reminder API.postman_collection.json` in root directory 
- First thing you must `Register` account
    - Authentication/Register
- And get the token with `Login` endpoint
    - Authentication/Login -> get `accessToken` (Token lifetime only 20 sec)
    - Authentication/Refresh Token -> refresh token with`refreshToken` to get new `accessToken` (Token lifetime only 20 sec)

- And CRUD `Reminder` with accessToken Header


### Author

Ginanjar Dwi Putranto

- [Gitlab](https://gitlab.com/genjerdotkom)
- [LinkedIn](https://www.linkedin.com/in/ginanjar-putranto-0416a913b/)
