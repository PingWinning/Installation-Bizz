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

We welcome contributions to improve the user panel. Whether it’s enhancing the UI, optimizing the backend, or adding new features, your input is valuable. Please submit a pull request or open an issue to start contributing.
