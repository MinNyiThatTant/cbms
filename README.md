# Clinic Booking Management System

![System Architecture](https://placehold.co/800x300?text=Clinic+System+Architecture)

## Table of Contents
1. [System Overview](#system-overview)
2. [Database Schema](#database-schema)
3. [Authentication System](#authentication-system)
4. [Booking Management](#booking-management)
5. [Email Notifications](#email-notifications)
6. [Frontend Components](#frontend-components)
8. [Role](#role)
9. [Installation](#installation)

---

## System Overview

```mermaid
flowchart TD
    A[Patient] -->|Books| B[Web Interface]
    B --> C[Backend API]
    C --> D[(Database)]
    E[Admin] -->|Manages| D
    F[Doctor] -->|Views| D
    C --> G[Email Service]

### Admin
  
- Admin can add doctors, edit doctors, delete doctors    
- Schedule new doctors sessions, remove sessions   
- View patients details    
- View booking of patients    
    
### Doctors

- View their Appointment
- View their scheduled sessions
- View details of patients
- Delete account    
- Eedit account settings
        
### Patiens(Clients)
  
  - Make appointment online
  - Create accounts themslves
  - View their old booking
  - Delete account
  - Edit account settings