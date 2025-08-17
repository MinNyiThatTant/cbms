# Clinic Booking Management System [CBMS]
## Online မှတစ်ဆင့် ‌ဆေးခန်းချိန်းဆို Appointment ဝန်ဆောင်မှုတစ်ခုဖြစ်သော CBMS စနစ်ဖြင့် အဆင်ပြေစွာ ဆေးကုသရန် ရည်ရွယ်ပါသည်။


![System Architecture](https://placehold.co/800x300?text=Clinic+Booking+Management+System)

## Table of Contents
1. [System Overview](#system-overview)
2. [Database Schema](#database-schema)
3. [Email Notifications](#email-notifications)
4. [Role](#role)
5. [Installation](#installation)

---

## System Overview

The Clinic Booking Management System (CBMS) is an online platform designed to facilitate seamless appointment scheduling for patients seeking medical care. The system allows patients to book appointments with doctors and manage their accounts efficiently. 

Key features of CBMS include:
- User-friendly interface for easy navigation
- Secure authentication for patients and doctors
- Real-time appointment scheduling and management
- Email notifications for appointment confirmations and reminders
- Administrative controls for managing doctors and patient records

CBMS aims to enhance the patient experience by providing a convenient and efficient way to access healthcare services.

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

### Email Sending Mechanism
- The system uses SMTP service via **Mailtrap.io** to send notifications. Mailtrap is a reliable email service provider that allows for safe testing and debugging of email sending without sending real emails to users.
- This ensures timely delivery and proper formatting of emails while keeping the development environment secure.

## Role

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
