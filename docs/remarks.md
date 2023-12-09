# Remarks

## Common Errors

1.  Bad Request (`400`)

    Its just specify 1 field and 1 validation error in message.
    While the request can contain multiple fields and each field can produce different validation errors based on the value.

    Usually the message will contain summary information for the users.
    While the validation error will be in array schema.

2. Internal Server Error (`500`)

    The error message should be general.

For this code challenge, the app will produce the same error as described in the [Common Errors](./common_errors.md).
