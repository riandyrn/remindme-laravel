# Common Errors

This document contains specification for common errors that will be happened on the system. Common error means the error is possible to be returned by all HTTP API endpoints in the system.

- Bad Request (`400`)

    ```json
    HTTP/1.1 400 Bad Request
    Content-Type: application/json
  
    {
        "ok": false,
        "err": "ERR_BAD_REQUEST",
        "msg": "invalid value of `type`"
    }
    ```

    Client will receive this error when there is an issue with client request. Check `msg` for the cause details.

- Invalid Access Token (`401`)

    ```json
    HTTP/1.1 401 Unauthorized
    Content-Type: application/json
  
    {
        "ok": false,
        "err": "ERR_INVALID_ACCESS_TOKEN",
        "msg": "invalid access token"
    }
    ```

    Client will receive this error when the submitted access token is no longer valid (expired) or the token is literally invalid (wrong access token).

- Forbidden Access (`403`)

    ```json
    HTTP/1.1 403 Forbidden
    Content-Type: application/json
  
    {
        "ok": false,
        "err": "ERR_FORBIDDEN_ACCESS",
        "msg": "user doesn't have enough authorization"
    }
    ```

    Client will receive this error when it tried to access resource that unauthorized for user.

- Not Found (`404`)

    ```json
    HTTP/1.1 404 Not Found
    Content-Type: application/json
  
    {
        "ok": false,
        "err": "ERR_NOT_FOUND",
        "msg": "resource is not found"
    }
    ```

    Client will receive this error when the resource it tried to access is not found.

- Internal Server Error (`500`)

    ```json
    HTTP/1.1 500 Internal Server Error
    Content-Type: application/json
  
    {
        "status": 500,
        "err": "ERR_INTERNAL_ERROR",
        "msg": "unable to connect into database"
    }
    ```

    Client will receive this error when there is some issue in the server. Check `msg` for details.

[Back to Top](#common-errors)