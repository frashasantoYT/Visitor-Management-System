# Visitor Management System
## Overview
The Visitor Management System (VMS) is a web-based application developed using PHP, designed to streamline and manage the process of visitor registration, check-in, and check-out. This system allows organizations to maintain a record of visitors, enhance security, and improve the overall visitor experience.

## Features
<ul>
<li>Visitor Registration: Allows visitors to pre-register or register upon arrival</li>
<li>Check-In and Check-Out: Simple interface for visitors to check in and out.</li>
<li>Visitor Log Management: View and manage logs of all visitor activities.</li>

<li>Admin Panel: Manage users, visitors, and system settings.</li>
 </ul>
 
### Prerequisites
- **Web Server:** Apache, Nginx, or any other web server supporting PHP
- **PHP:** Version 7.4 or higher
- **Database:** MySQL or MariaDB
- **Browser:** Modern web browser (Chrome, Firefox, Edge, etc.)

### Installation 
1. Clone the repository
   ```sh
   git clone https://github.com/frashasantoYT/Visitor-Management-System.git
   cd Vistor-Management-System

   ```
2. Configure the database 
Create a new database in MySQL/MariaDB.
Import the provided SQL file to set up the necessary tables.

```sh
mysql -u username -p password visitor_management < visitor_management.sql

```
3. Usage
### Admin Panel

- Access the admin panel at `http://localhost/Visitor-Management-System/public/`
- Log in with the default credentials:
  - **Username:** admin
  - **Password:** admin123

### LICENSE 
```sh

Copyright (c) [2024] [Frasha Santo]

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

```

