![image](https://github.com/user-attachments/assets/f4562832-19f1-49f5-81f8-8b497e89c708)
![image](https://github.com/user-attachments/assets/207cbfdf-0aee-45f8-9ca8-3cf5da01f927)
![image](https://github.com/user-attachments/assets/8f91a892-f71d-4dd9-aece-ec888f0e87af)
![image](https://github.com/user-attachments/assets/2152d188-453d-4458-b4c1-065a8f1aef90)


# Professional Installation Services - User Panel

This repository contains the user panel for our Professional Installation Services business, offering a seamless interface for customers to explore and request our services. Our business is dedicated to providing top-notch installation services across Laval and Montreal, ensuring that all your equipment is set up with care and precision.

## Features

- **Bilingual Support:** The user panel supports both French and English, allowing customers to switch languages effortlessly.
- **Service Overview:** A comprehensive list of services, including furniture assembly, TV installation, appliance installation, and more. Each service is described in detail to help customers understand what we offer.
- **Responsive Design:** The interface is fully responsive, ensuring a smooth experience across all devices, from mobile phones to desktops.
- **Secure Contact Form:** Users can reach out to us directly through the contact form, which includes input validation and error handling to ensure accurate communication.
- **Real-time Status Updates:** Customers receive instant confirmation of their requests, with status updates available directly in the panel.
- **Scheduling System:** We are currently working on a scheduling system to simplify the booking process. The idea is that the admin will share their working schedules, and clients can book a time and day for the service they want to be done. This system will streamline the booking process, saving time for both parties and making it easier to manage appointments.

![image](https://github.com/user-attachments/assets/7c5211d9-4221-403d-bce8-cc24174d9ea1)

## Installation Services Offered

- **Furniture Assembly:** We expertly assemble all types of furniture, ensuring everything is securely put together and ready for use.
- **TV Installation:** Our team safely mounts your TV on any wall, optimizing your viewing experience.
- **Appliance Setup:** We handle the installation of ovens, refrigerators, microwaves, and other appliances with precision.
- **Sofa Connection:** We connect and configure sectional sofas to fit perfectly into your space.
- **Box Removal & Recycling:** We take care of the tedious task of unpacking and recycling, leaving your space clean and organized.
- **Moving Services:** Professional moving services are available across Laval and Montreal, with additional options for long-distance moves.

## Admin Panel Overview

![image](https://github.com/user-attachments/assets/50f2a191-9351-4e31-a565-a188b69663f7)

The admin panel allows administrators to manage user requests effectively. Key features include:

- **User Authentication:** Secure login for administrators with the default username `Boss007` and password `pass`.
- **Ticket Management:** View, filter, and update the status of user-submitted tickets.
  - **Filters:** Administrators can filter tickets by status (`pending`, `in-progress`, `completed`) and submission date.
  - **Pagination:** The admin panel supports pagination to manage large numbers of tickets, with options to show 5, 10, or 20 tickets per page.
- **Status Updates:** Administrators can update the status of user requests directly from the admin panel, helping keep track of progress.
- **Request Details:** For longer user requests, a "See More" button reveals the full content without cluttering the interface.
- **Deletion of Tickets:** Administrators can delete tickets if necessary, helping maintain a clean and organized database.

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

This project is more than just a basic webpage—it's the starting point of what I believe can become a fully functional and successful business. I am dedicated to turning this vision into reality, and I am actively seeking a positive team of contributors who can help build a secure and professional website.

**Why contribute?**
If you join me in this journey and work on this project, you will be remunerated for your efforts. Moreover, if this business takes off, there is potential for it to grow rapidly and earn significant profits. This could ensure us a spot in the trading market, complete with actions and shares, leading to substantial financial rewards for all involved.

For now, I'm focusing on creating a working business while continuing my computer science studies. This project is also a way for me to generate some income to cover my expenses, like gas.

Looking forward to collaborating with you all.

**Support the Project:**
[PayPal Donation](https://paypal.me/DimitarSimeonov17?country.x=CA&locale.x=en_US)
#

![goof](https://github.com/user-attachments/assets/b97c0eff-9ca0-4925-a577-9a1598df96bd)
![buks](https://github.com/user-attachments/assets/13ebb84c-e84b-4aac-90ea-cfa241ac8b14)

