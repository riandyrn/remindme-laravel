# REST API

This document contains API specification for the web app.

- [Login](#login)
- [Refresh Access Token](#refresh-access-token)
- [List Reminders](#list-reminders)
- [Create Reminder](#create-reminder)
- [View Reminder](#view-reminder)
- [Edit Reminder](#edit-reminder)
- [Delete Reminder](#delete-reminder)

Beside these endpoints, the web app must also implement [Common Errors](./common_errors.md).

## Login

POST: `/api/session`

This endpoint is used by client to log in the user. Upon successful call, this endpoint returns `access_token` that will be used to authenticate subsequent API calls.

Notice that `access_token` has very short lifetime. In this system the lifetime duration is set to `20 seconds`. So after `20 seconds` the `access_token` will be expired. 

When the current `access_token` is already expired, client must call [Refresh Access Token](#refresh-access-token) to generate the new `access_token` using `refresh_token` from the response.

Currently only `2` users available in the system:

- username: `alice`, password: `123456`
- username: `bob`, password: `123456`

> **Note:**
>
> Since `refresh_token` will be used every time the client want to generate new `access_token`, it should be stored in client storage indefinitely.

**Body:**

- `username`, String => The username for login into the system.
- `password`, String => The password for given username.

**Example Request:**

```json
POST /session
Content-Type: application/json

{
    "username": "alice",
    "password": "123456"
}
```

**Success Response:**

```json
HTTP/1.1 200 OK
Content-Type: application/json

{
    "ok": true,
    "data": {
        "access_token": "933e89b1-980b-4c98-8d73-18f7ccfac25d",
        "refresh_token": "8eebef3c-03e0-4ead-b78e-27bac3fc43c3"
    }
}
```

**Error Responses:**

- Invalid Credentials (`401`)

    ```json
    HTTP/1.1 401 Unauthorized
    Content-Type: application/json

    {
        "ok": false,
        "err": "ERR_INVALID_CREDS",
        "msg": "incorrect username or password"
    }
    ```

    Client will receive this error when it submitted incorrect combination of username & password.

[Back to Top](#http-api)

## Refresh Access Token

PUT: `/session`

This endpoint is used by client to replace expired `access_token` with the new one.

**Header:**

- `Authorization`, String => The value is `Bearer <refresh_token>`.

**Example Request:**

```json
PUT /session
Authorization: Bearer 8eebef3c-03e0-4ead-b78e-27bac3fc43c
```

**Success Response:**

```json
HTTP/1.1 200 OK
Content-Type: application/json

{
    "ok": true,
    "data": {
        "access_token": "933e89b1-980b-4c98-8d73-18f7ccfac25d"
    }
}
```

**Error Responses:**

- Invalid Refresh Token (`401`)

    ```json
    HTTP/1.1 401 Unauthorized
    Content-Type: application/json

    {
        "ok": false,
        "err": "ERR_INVALID_REFRESH_TOKEN",
        "msg": "invalid refresh token"
    }
    ```

    Client will receive this error when it submitted invalid refresh token. There are 2 causes of invalid refresh token: either the value is incorrect or the value is deemed expired by the system. In case client receiving this error, it is expected to redirect user to the login page.

[Back to Top](#rest-api)

## List Reminders

[Back to Top](#rest-api)

## Create Reminder

[Back to Top](#rest-api)

## View Reminder

[Back to Top](#rest-api)

## Edit Reminder

[Back to Top](#rest-api)

## Delete Reminder

[Back to Top](#rest-api)