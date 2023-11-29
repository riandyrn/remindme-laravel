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

- email: `alice@mail.com`, password: `123456`
- email: `bob@mail.com`, password: `123456`

> **Note:**
>
> Since `refresh_token` will be used every time the client want to generate new `access_token`, it should be stored in client storage indefinitely.

**Body:**

- `email`, String => The email for login into the system.
- `password`, String => The password for given username.

**Example Request:**

```json
POST /session
Content-Type: application/json

{
    "email": "alice@mail.com",
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
        "user": {
            "id": 1,
            "email": "alice@mail.com",
            "name": "Alice"
        },
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

[Back to Top](#rest-api)

---

## Refresh Access Token

PUT: `/api/session`

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

    Client will receive this error when it submitted invalid refresh token. There are 2 causes of invalid refresh token: either the value is incorrect or the value is deemed expired by the system. In case client receiving this error, the client should redirect user to the login page.

[Back to Top](#rest-api)

---

## List Reminders

GET: `/api/reminders?limit={limit}`

This endpoint returns the upcoming reminders for the user. The reminders are sorted by `remind_at` in ascending order.

**Header:**

- `Authorization`, String => The value is `Bearer <access_token>`.

**Query Parameters:**

- `limit`, Integer, _OPTIONAL_ => The maximum number of reminders to be returned. The default value is `10`.

**Example Request:**

```text
GET /reminders?limit=5
Authorization: Bearer 933e89b1-980b-4c98-8d73-18f7ccfac25d
```

**Success Response:**

```json
HTTP/1.1 200 OK
Content-Type: application/json

{
    "ok": true,
    "data": {
        "reminders": [
            {
                "id": 1,
                "title": "Meeting with Bob",
                "description": "Discuss about new project related to new system",
                "remind_at": "1701246722",
                "event_at": "1701223200"
            }
        ],
        "limit": 5
    }
}
```

**Error Responses:**

No specific error responses.

[Back to Top](#rest-api)

---

## Create Reminder

POST: `/api/reminders`

This endpoint is used by client to create a new reminder. When the reminder is successfully created, the system will send email notification to the user when the reminder is due (when `reminder_at` is reached).

**Header:**

- `Authorization`, String => The value is `Bearer <access_token>`.

**Request Body:**

- `title`, String => Title of the reminder.
- `description`, String => Description of the reminder.
- `remind_at`, Integer => Unix timestamp in seconds when the reminder should be reminded to the user.
- `event_at`, Integer => Unix timestamp in seconds when the event will occurs.

**Example Request:**

```json
POST /api/reminders
Authorization: Bearer 933e89b1-980b-4c98-8d73-18f7ccfac25d

{
    "title": "Meeting with Bob",
    "description": "Discuss about new project related to new system",
    "remind_at": 1701246722,
    "event_at": 1701223200
}
```

**Success Response:**

```json
HTTP/1.1 200 OK
Content-Type: application/json

{
    "ok": true,
    "data": {
        "id": 1,
        "title": "Meeting with Bob",
        "description": "Discuss about new project related to new system",
        "remind_at": "1701246722",
        "event_at": "1701223200"
    }
}
```

**Error Responses:**

No specific error responses.

[Back to Top](#rest-api)

---

## View Reminder

GET: `/api/reminders/{id}`

This endpoint is used by client to view details of a reminder.

**Header:**

- `Authorization`, String => The value is `Bearer <access_token>`.

**Path Parameters:**

- `id`, Integer => Id of the reminder.

**Example Request:**

```text
GET: /api/reminders/1
Authorization: Bearer 933e89b1-980b-4c98-8d73-18f7ccfac25d
```

**Success Response:**

```json
HTTP/1.1 200 OK
Content-Type: application/json

{
    "ok": true,
    "data": {
        "id": 1,
        "title": "Meeting with Bob",
        "description": "Discuss about new project related to new system",
        "remind_at": "1701246722",
        "event_at": "1701223200"
    }
}
```

**Error Responses:**

No specific error responses.

[Back to Top](#rest-api)

---

## Edit Reminder

PUT: `/api/reminders/{id}`

This endpoint is used by client to edit a reminder.

**Header:**

- `Authorization`, String => The value is `Bearer <access_token>`.

**Path Parameters:**

- `id`, Integer => Id of the reminder.

**Request Body:**

- `title`, String, _OPTIONAL_ => Title of the reminder.
- `description`, String, _OPTIONAL_ => Description of the reminder.
- `remind_at`, Integer, _OPTIONAL_ => Unix timestamp in seconds when the reminder should be reminded to the user.
- `event_at`, Integer, _OPTIONAL_ => Unix timestamp in seconds when the event will occurs.

**Example Request:**

```json
PUT /api/reminders/1
Authorization: Bearer 933e89b1-980b-4c98-8d73-18f7ccfac25d

{
    "title": "Meeting with Bob",
    "description": "Discuss about new project related to new system",
    "remind_at": 1701246722,
    "event_at": 1701223200
}
```

**Success Response:**

```json
HTTP/1.1 200 OK
Content-Type: application/json

{
    "ok": true,
    "data": {
        "id": 1,
        "title": "Meeting with Bob",
        "description": "Discuss about new project related to new system",
        "remind_at": "1701246722",
        "event_at": "1701223200"
    }
}
```

**Error Responses:**

No specific error responses.

[Back to Top](#rest-api)

---

## Delete Reminder

DELETE: `/api/reminders/{id}`

This endpoint is used by client to delete a reminder.

**Header:**

- `Authorization`, String => The value is `Bearer <access_token>`.

**Path Parameters:**

- `id`, Integer => Id of the reminder.

**Example Request:**

```text
DELETE: /api/reminders/1
```

**Success Response:**

```json
HTTP/1.1 200 OK
Content-Type: application/json

{
    "ok": true
}
```

**Error Responses:**

No specific error responses.

[Back to Top](#rest-api)

---