# Clinic Booking Management System [CBMS]
## Online မှတစ်ဆင့် ‌ဆေးခန်းချိန်းဆို Appointment ဝန်ဆောင်မှုတစ်ခုဖြစ်သော CBMS စနစ်ဖြင့် အဆင်ပြေစွာ ဆေးကုသရန် ရည်ရွယ်ပါသည်။


![CBMS](https://placehold.co/600x200?text=Clinic+Booking+Management+System)

## Table of Contents
1. [System Overview](#system-overview)
2. [Database Schema](#database-schema)
3. [Email Notifications](#email-notifications)
4. [Role](#role)
5. [Installation](#installation)

---

## System Overview

The Clinic Booking Management System (CBMS) is an webpage for patients to easily schedule appointments with doctors and manage their accounts.

- User-friendly interface
- Secure login
- Real-time appointment scheduling
- Email notifications
- Admin controls for managing records

## Database Schema

The CBMS database consists of tables that store information;
- admin
- appointment
- schedule
- patients
- doctors
- booking
- usertype
- specialities 

## Email Notifications

### Email System
- The system uses SMTP via **Mailtrap.io** to send notifications, testing without sending real emails.
- This ensures timely delivery and formatting.

## Roles

### Admin
  
- Admin can add doctors, edit doctors, delete doctors    
- Schedule new doctors sessions, remove sessions   
- View patients details    
- View booking of patients    
    
### Doctors

- Manage(confirm/cancel) their Appointment
- View their scheduled sessions
- View details of patients
- Delete account    
- Edit account settings
        
### Patiens(Clients)
  
  - Make appointment 
  - Create accounts themselves
  - View their old booking
  - Delete account
  - Edit account settings

## Installation

### Prerequisites
- Xampp for web server (e.g., Apache, MySQL)
- PHP version 7.4 or higher
- MySQL or MariaDB database