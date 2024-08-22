# Professional Installation Services - User Panel

This repository contains the user panel for our Professional Installation Services business, offering a seamless interface for customers to explore and request our services. Our business is dedicated to providing top-notch installation services across Laval and Montreal, ensuring that all your equipment is set up with care and precision.

## Features

- **Bilingual Support:** The user panel supports both French and English, allowing customers to switch languages effortlessly.
- **Service Overview:** A comprehensive list of services, including furniture assembly, TV installation, appliance installation, and more. Each service is described in detail to help customers understand what we offer.
- **Responsive Design:** The interface is fully responsive, ensuring a smooth experience across all devices, from mobile phones to desktops.
- **Secure Contact Form:** Users can reach out to us directly through the contact form, which includes input validation and error handling to ensure accurate communication.
- **Real-time Status Updates:** Customers receive instant confirmation of their requests, with status updates available directly in the panel.

## Installation Services Offered

- **Furniture Assembly:** We expertly assemble all types of furniture, ensuring everything is securely put together and ready for use.
- **TV Installation:** Our team safely mounts your TV on any wall, optimizing your viewing experience.
- **Appliance Setup:** We handle the installation of ovens, refrigerators, microwaves, and other appliances with precision.
- **Sofa Connection:** We connect and configure sectional sofas to fit perfectly into your space.
- **Box Removal & Recycling:** We take care of the tedious task of unpacking and recycling, leaving your space clean and organized.
- **Moving Services:** Professional moving services are available across Laval and Montreal, with additional options for long-distance moves.

## Admin Panel Overview

The admin panel allows administrators to manage user requests effectively. Key features include:

- **User Authentication:** Secure login for administrators with the default username `Boss007` and password `pass`.
- **Ticket Management:** View, filter, and update the status of user-submitted tickets.
  - **Filters:** Administrators can filter tickets by status (`pending`, `in-progress`, `completed`) and submission date.
  - **Pagination:** The admin panel supports pagination to manage large numbers of tickets, with options to show 5, 10, or 20 tickets per page.
- **Status Updates:** Administrators can update the status of user requests directly from the admin panel, helping keep track of progress.
- **Request Details:** For longer user requests, a "See More" button reveals the full content without cluttering the interface.
- **Deletion of Tickets:** Administrators can delete tickets if necessary, helping maintain a clean and organized database.

### How to Use the Admin Panel

1. **Login:**
   - Navigate to the login page and use the default credentials (`Boss007` / `pass`) to access the admin dashboard.
   - Upon successful login, administrators are redirected to the user tickets management page.

2. **Managing Tickets:**
   - Use the filters and pagination controls to navigate through the tickets.
   - Update the status of a ticket by selecting the appropriate status from the dropdown menu.
   - View full request details by clicking the "See More" button, which opens a modal with the complete message.
   - To delete a ticket, click the "Delete" button next to the ticket.

## SQL Back-end Overview

### Database Structure

The SQL back-end is built using MariaDB and manages two primary tables:

1. **`tickets`** - This table stores user requests with the following structure:
    - `id`: Auto-incremented unique identifier for each request.
    - `name`: Name of the user.
    - `phone`: User's phone number.
    - `email`: User's email address.
    - `request`: The message or service request made by the user.
    - `status`: The current status of the request (`pending`, `in-progress`, `completed`).
    - `submission_date`: The date when the request was submitted.

2. **`users`** - This table stores user credentials, specifically for admin access:
    - `id`: Auto-incremented unique identifier for each user.
    - `username`: The username for the user (default admin is `Boss007`).
    - `password_hash`: The hashed password for secure authentication (default password is `pass`).

### How to Use the Database

1. **Setting Up the Database:**
   - Import the provided SQL dump into your MariaDB or MySQL instance to create the necessary tables and initial data.
   - Ensure that the `tickets` table is configured to auto-increment the `id` field to prevent conflicts when inserting new records.

2. **Admin Access:**
   - The default admin username is `Boss007`, and the password is `pass`.
   - The password is stored as a hashed value in the `users` table, ensuring security. For hashing passwords, ensure your PHP environment uses a secure hashing algorithm (e.g., `password_hash()` function).

3. **Storing User Information:**
   - User requests submitted through the contact form on the front-end are stored in the `tickets` table.
   - The admin can view and manage these requests, updating the status as needed.

### Notes for Contributors

- **Security:** Contributions should prioritize security, especially when handling user data and authentication processes.
- **Database Migrations:** If you make changes to the database schema, please include migration scripts and update the SQL dump accordingly.

## Technologies Used

- **PHP & MySQL:** For backend processing and database management.
- **HTML, CSS, TailwindCSS:** For creating a clean, modern, and responsive user interface.
- **JavaScript:** Enhancing user interaction and handling form submissions.

## How to Contribute

We welcome contributions to improve the user panel and admin dashboard. Whether it’s enhancing the UI, optimizing the backend, or adding new features, your input is valuable. Please submit a pull request or open an issue to start contributing.

## Author's Message to Contributors

Hey everyone,

I know this is a really basic webpage right now, but I'm passionate about turning it into a fully functional business. While there may be some security issues at this stage, I'm committed to fixing them and I'm actively looking for a positive team of contributors who can help build a secure and professional website. The goal is to manage user requests and, in the future, potentially handle transactions and employee management.

For now, I'm focused on creating a working business while I continue my computer science studies. This project is also a way for me to earn some money to help cover my expenses, like gas.

Looking forward to collaborating with you all!

paypal.me : https://paypal.me/DimitarSimeonov17?country.x=CA&locale.x=en_US
#
![Untitled](https://github.com/user-attachments/assets/1ec54497-013f-4b57-8ce4-f334ea1e9bc2)
#

![goof](https://github.com/user-attachments/assets/b97c0eff-9ca0-4925-a577-9a1598df96bd)
