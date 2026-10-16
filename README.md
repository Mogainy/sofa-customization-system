# 🛋️ Sofa Customization and Ordering System

A web-based sofa customization and ordering management system designed to help customers personalize sofa designs and place orders online.

The system provides an interactive platform for exploring sofa products, customizing designs, managing customer accounts, and processing orders through an administrative interface.

## 📌 Project Overview

The Sofa Customization and Ordering System is a web application developed to simplify the process of purchasing customized furniture.

Customers can explore available sofa products, personalize their preferred designs, review their selections, and submit orders online.

The project demonstrates practical web development skills, including database integration, user authentication, server-side programming, and interactive web interfaces.

## ✨ Key Features

### Customer Features

- **User Registration and Login:** Customer account creation and authentication.
- **Sofa Product Browsing:** Explore available sofa products.
- **Sofa Customization:** Personalize sofa designs through the customization interface.
- **Order Placement:** Submit customized sofa orders.
- **Order Review:** Review customization selections before ordering.
- **Order History:** Access previously placed orders.
- **Order Cancellation:** Request or perform order cancellation where supported.

### Administration

- Administrative interface for managing system operations.
- Backend functionality for supporting customer orders and sofa products.
- Database-driven management of application information.

## 🛠️ Technologies Used

| Technology | Purpose |
|---|---|
| PHP | Backend application logic |
| MySQL | Database management |
| HTML5 | Web page structure |
| CSS3 | Styling and layouts |
| JavaScript | Interactive functionality |
| XAMPP | Local development environment |
| PHPMailer | Email functionality |
| Git & GitHub | Version control and source code hosting |

## 📂 Project Structure

```text
sofa_customizer/
│
├── admin/                 # Administration interface
├── assets/                # Frontend assets
├── config/                # Application configuration
├── PHPMailer/             # Email functionality
├── uploads/               # Uploaded customization assets
│
├── index.php              # Homepage
├── customize.php          # Sofa customization
├── product.php            # Product details
├── register.php           # Customer registration
├── login.php              # Customer login
├── logout.php             # Logout functionality
├── place_order.php        # Order submission
├── review_order.php       # Order review
├── my_orders.php          # Customer orders
├── cancel_order.php       # Order cancellation
├── save_canvas.php        # Save customization canvas
├── sofa_customizer.sql    # Database SQL file
├── sample_data.sql        # Sample database data
└── .gitignore             # Git exclusion rules
```

## ⚙️ Installation and Setup

### Prerequisites

- XAMPP or another PHP/MySQL development environment
- PHP
- MySQL or MariaDB
- A modern web browser

### Step 1: Clone the Repository

```bash
git clone https://github.com/Mogainy/sofa-customization-system.git
```

### Step 2: Move the Project

Place the project folder inside your XAMPP `htdocs` directory.

Example:

```text
C:\xampp\htdocs\sofa_customizer
```

### Step 3: Set Up the Database

1. Start Apache and MySQL from the XAMPP Control Panel.
2. Open `http://localhost/phpmyadmin`.
3. Create a database using the name expected by the application configuration.
4. Import `sofa_customizer.sql`.
5. Optionally import `sample_data.sql` if it contains suitable demonstration data.

### Step 4: Configure Database Connection

Update the database configuration inside the `config/` directory to match your local MySQL settings.

Do not publish actual database passwords or email app passwords.

### Step 5: Run the Application

Open your browser and navigate to:

```text
http://localhost/sofa_customizer/
```

### Step 6: Configure Email Notifications

If email functionality is required, configure valid SMTP credentials securely in your local environment. The repository must not contain real passwords or private API keys.

## 📸 Project Screenshots

Screenshots of the application will be added to demonstrate:

- Homepage
- Sofa customization interface
- Customer ordering process
- Customer dashboard
- Administrative interface

## 🎯 Project Objectives

- Simplify the process of ordering customized sofas.
- Provide customers with an interactive furniture customization experience.
- Improve organization of customer orders.
- Demonstrate practical full-stack web development and database integration.

## 🚀 Future Improvements

Potential enhancements include:

- Online payment integration.
- Enhanced customization previews.
- Customer order tracking.
- Mobile experience improvements.
- Automated order status notifications.

## 👨‍💻 Developer

**Enock Mokaya**

Diploma in Information Technology  
Zetech University, Kenya

**GitHub:** https://github.com/Mogainy

**Email:** enockmokaya35@gmail.com

## 📄 Project Status

Academic and portfolio project demonstrating web application development, customization workflows, and database-driven ordering functionality.

---

Developed by **Enock Mokaya**.