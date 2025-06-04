QQL is Quick Query Language
===

# Usage

## Open

```php
OP()->Unit()->QQL()->Open('Example.sqlite3');
```

## Get

```php
$single_user_record = OP()->Unit()->QQL()->Get(' t_user.id = $id ');
```

```php
$active_user_records = OP()->Unit()->QQL()->Get(' t_user.deleted = null ');
```

## Set

```php
$set = [
    'name'     => $name,
    'password' => $password,
];
$auto_increment_id = OP()->Unit()->QQL()->Set('t_user', $set);
```

### Update

```php
$set = [
    'password' => $password,
];
$where = [
    'id' => $id,
];
$result = OP()->Unit()->QQL()->Set('t_user', $set, $where);
```

## Error

```php
if( $error = OP()->Unit()->QQL()->Error() ){
    OP()->Notice($error);
}
```

# Supported

 * Open
 * Insert
 * Update
 * Select
 * Where
 * Join
 * Limit
 * Offset
 * Pager
 * Field
 * As

# Not Supported

 * Delete
 * Where
	 * Or
 * Join
	 * Right
	 * Inner
	 * Outer

# CI

1. Copy `QQL.sqlite3` to `asset:/db/ci/` directory.

# Sandbox

1. Copy `QQL.sqlite3` to `asset:/db/sandbox/` directory.
2. Change to owner id `asset:/db/sandbox/` directory and `QQL.sqlite3`.
