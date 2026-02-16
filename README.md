📄 README.md
Event Registration System – Exam Application
Event Registration System

This project is part of your practical exam.

You are required to build a simple Event Registration System using PHP and PDO. The application must allow users to register for an event and allow the administrator to manage registrations.

Project Setup

Import the provided SQL into your local MySQL server.

Ensure your connect.php file properly connects to the database.

All database interactions must use PDO.

Database Structure

Table: registrations

Fields:

id (Primary Key, Auto Increment)

first_name

last_name

email

phone

created_at

Application Requirements
1. Create (Insert)

Create a form that collects:

First Name

Last Name

Email

Phone

The form must use the POST method.

2. Server-Side Validation

You must:

Confirm the form was submitted using:

$_SERVER['REQUEST_METHOD'] === 'POST'


Use filter_input() to retrieve all form values

Use trim() to remove whitespace

Ensure first name, last name, and phone:

Are not null

Are not empty

Are not whitespace only

Validate email format using:

filter_var($email, FILTER_VALIDATE_EMAIL)


If validation fails:

Display an error message

Stop execution using exit;

3. Database Interaction

You must:

Store SQL queries in variables before preparing them

Use prepare()

Use bindParam()

Use execute()

Use prepared statements for ALL database operations

Do NOT insert raw user input directly into SQL.

4. Read (Display Records)

Display all registrations in an HTML table

Use a loop (e.g., foreach) to generate the table dynamically

5. Update and Delete

Include an Update button for each record

Include a Delete button for each record

Create separate scripts for update and delete

Use prepared statements in both scripts

Technical Expectations

Your solution must clearly demonstrate:

Variables

Conditional statements

Loops

Server-side validation

CRUD operations

Dynamic HTML generation

Basic separation of concerns (e.g., includes for header/footer)

Submission Requirements

Submit your full project folder

Include all PHP files

Ensure your code runs without fatal errors

All validation must be server-side
