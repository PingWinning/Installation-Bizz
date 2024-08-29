![image](https://github.com/user-attachments/assets/3ef0fd33-d144-4ce5-a35b-0eaf554f95d8)
![image](https://github.com/user-attachments/assets/44d3cb6a-bda2-478f-b7dd-6557c383f162)
![image](https://github.com/user-attachments/assets/68ecf6bb-8174-49de-9bea-bee30d573e3c)
![image](https://github.com/user-attachments/assets/b93c1827-afe3-4d30-b74e-ef088388c32c)



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

![image](https://github.com/user-attachments/assets/68539511-5516-4bef-85fc-38acf57c2274)

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

## Suggestions from Contributors

I am looking for a name for my company and I welcome all suggestions. Please feel free to suggest a name for [Votre Nom d'Entreprise] in the footer of this website.

## Author's Message to Contributors
Hey everyone,

This project is more than just a basic webpage—it's the starting point of what I believe can become a fully functional and successful business. I am dedicated to turning this vision into reality, and I am actively seeking a positive team of contributors who can help build a secure and professional website.

**Why contribute?**
If you join me in this journey and work on this project, you will be remunerated for your efforts. Moreover, if this business takes off, there is potential for it to grow rapidly and earn significant profits. This could ensure us a spot in the trading market, complete with actions and shares, leading to substantial financial rewards for all involved.

For now, I'm focusing on creating a working business while continuing my computer science studies. This project is also a way for me to generate some income to cover my expenses, like gas.

Looking forward to collaborating with you all

**Support the Project:**
paypal.me : https://paypal.me/DimitarSimeonov17?country.x=CA&locale.x=en_US
#

![goof](https://github.com/user-attachments/assets/b97c0eff-9ca0-4925-a577-9a1598df96bd)
![buks](https://github.com/user-attachments/assets/13ebb84c-e84b-4aac-90ea-cfa241ac8b14)

