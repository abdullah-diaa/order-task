Order Task API
Overview
The Order Task API is a simple, full-stack  system built with Laravel 11+ and FilamentPHP 3+. It provides essential functionalities for user authentication, product management, cart operations, and order processing. The backend follows the Service Repository Pattern for scalability and maintainability.
-------------------------------------------------------------
Technologies Used
Backend Framework: Laravel 11
Admin Panel: FilamentPHP 3+
Authentication: Laravel Sanctum (Token-based)
Database: MySQL

------------------------------------------------------------------------


Setup Instructions
Extract the compressed file into your preferred directory.

Install dependencies:

Run the following command to install PHP dependencies:

```
bash
composer install


```
bash
cp .env.example .env

```
bash
php artisan key:generate

```
php artisan migrate

```
php artisan db:seed

```
php artisan serve

--------------------------------------------------------------------------------------------------------

API Documentation

For Authntication 

1-register   

post  : http://127.0.0.1:8000/api/register


Example data :


{
  "name": "Abdullah diaa",
  "email": "abdullah@example.com",
  "password": "securePassword123",
  "password_confirmation": "securePassword123"
}




2-login

post :  http://127.0.0.1:8000/api/login




Example data :


{
  "email": "abdullah@example.com",
  "password": "securePassword123"
}



3-logout

post    :   http://127.0.0.1:8000/api/logout


--------------------------------------------------------------------------------------

Products


1-Get the Products


get :  http://127.0.0.1:8000/api/products


2-Show Specific Product Details


get  : http://127.0.0.1:8000/api/products/{id}

---------------------------------------------------------------------------------------

Cart

1- addToCart

post : http://127.0.0.1:8000/api/cart

with Example data

 {
    "product_id": 10,
    "quantity": 2
}


2-removeFromCart  

delete  :  http://127.0.0.1:8000/api/cart/{cartItemId}

---------------------------------------------------------------------------------------------

Order

1-orders


get  : http://127.0.0.1:8000/api/orders


Retrieve Orders for the Authenticated User



2-checkout

post  :   http://127.0.0.1:8000/api/checkout


For checking items and moving them to the order



3-updateOrder

put   :  http://127.0.0.1:8000/api/orders/{orderId}


To update the order for the authenticated user, such as changing the quantity, etc.



4-deleteOrder

delete  :  http://127.0.0.1:8000/api/orders/{orderId}

To delete the order


----------------------------------------------------------------------------

Overview of the Project
This project, Order Task, is a fully functional shopping system developed using Laravel 11 and FilamentPHP. The system has a secure token-based authentication implemented with Laravel Sanctum, providing users with safe access to their account and shopping data. The core functionalities include product management, shopping cart operations, order processing, and user authentication. The database has been seeded with a large number of sample data for all components to simulate a real-world environment and ensure robust performance.

Database Seeding
The database has been populated with a significant amount of data for all core entities — users, products, orders, and cart items. This data allows for thorough testing of the application, simulating real-world scenarios with numerous records. The seeding process includes:

Users: A variety of user profiles are seeded to simulate multiple customer accounts.
Products: A wide range of product data is included, each with attributes like price, stock, and description, ensuring realistic testing for product management and purchasing.
Orders: Orders are seeded with various statuses to test the order flow and functionality, including completed, pending, and canceled orders.
Cart Items: Sample cart data has been seeded to allow for testing of cart operations and user behavior.
FilamentPHP Admin Panel
The FilamentPHP Admin Panel has been integrated to provide a user-friendly interface for managing the backend of the application. Admin users can perform CRUD operations for managing:

Users: Create, update, and delete user accounts, as well as manage roles and permissions.
Products: Add, edit, and delete product listings, with detailed options for product attributes like stock quantity and price.
Orders: Monitor and manage all customer orders, with the ability to view order details, update order status, and track the progress of pending orders.
The FilamentPHP panel also features filtering and search functionalities, making it easy for admins to find specific products, users, or orders based on criteria such as name, status, or date.

Stock Management and Quantity Updates
The system features real-time stock management that is tightly integrated with cart and order functionalities. When a product is added to the cart, the system checks the stock availability and updates the stock accordingly. If the user checks out and places an order, the stock is further updated to reflect the purchased quantity, ensuring that the inventory remains accurate.

Admin users can update the product quantities directly from the admin panel, and these changes are immediately reflected in the frontend for customers. This ensures a smooth and accurate shopping experience for users, preventing issues like overselling out-of-stock products.

Secure Operations
Security has been a primary focus throughout the project:

Token-Based Authentication: Laravel Sanctum is used to secure all routes, ensuring that only authenticated users can access sensitive endpoints, such as cart, orders, and user account details.
Data Integrity: Throughout the application, proper validation and error handling have been implemented to ensure that user input is correctly sanitized and validated, preventing malicious data manipulation.
Role-Based Access Control (RBAC): Admin users have elevated access, enabling them to manage users, products, and orders. Regular users are limited to only interacting with their own accounts and orders.
Real-Time Data and User Interaction
The system is designed to be scalable and responsive, with real-time updates where needed. For example, when users add products to the cart, the stock is checked dynamically. If an admin updates the stock or product details in the Filament panel, those changes are reflected in real-time for all users.
