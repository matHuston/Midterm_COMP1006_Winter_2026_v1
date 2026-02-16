# Event Registration System

## Overview

In this project, you will build a simple **Event Registration System** using PHP and PDO.

Users must be able to register for an event. When the form is submitted, the data must be validated on the server and then stored in the database.

The administrator must be able to:

- View all registrations
- Update existing registrations
- Delete registrations

All database interactions must use PDO and prepared statements.

---

## Database Table

You will work with a table named:

`registrations`

### Table Fields

- `id` (Primary Key, Auto Increment)
- `first_name`
- `last_name`
- `email`
- `phone`
- `created_at`

Your application must connect to the database using PDO.

---

# Application Requirements

## 1. Create (Insert and Store in Database)

Create a form that collects:

- First Name
- Last Name
- Email
- Phone

The form must:

- Use the `POST` method
- Submit to a PHP processing script
- Validate all input on the server
- Insert the validated data into the `registrations` table

After a successful insert:

- Display a confirmation message
- Retrieve all records from the database
- Display them in an HTML table

Data must actually be saved to the database.

---

## 2. Server-Side Validation

All validation must occur on the server.

You must:

- Confirm the form was submitted using:

```php
$_SERVER['REQUEST_METHOD'] === 'POST'

