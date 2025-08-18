# 🌍 Trip Planner Application

## 📌 Overview
The **Trip Planner Application** is a full-stack web platform that allows users to plan trips, book hotels, schedule activities, make payments, and contact the site owner — all in one place.  
It combines:
- PHP/MySQL backend
- Python Flask + Genetic Algorithm for route optimization
- Stripe for secure payments
- PHP Mail for contact forms

This project was developed as a **team collaboration**.

---

## 👥 Team Members
- **[Rifna Raheem]**  
- **[Bhagya Rajapaksha]**

---

## 🚀 Features
- **User Authentication**
  - Register, login, logout
  - Password reset
- **Trip Scheduling**
  - Input trip details (start, end, duration, cities)
  - AI-powered route optimization (Flask backend + Genetic Algorithm)
- **Hotel Booking**
  - Search hotels
  - View & confirm bookings
  - Prevent duplicate bookings
- **Payments**
  - Secure checkout via **Stripe**
  - Payment success & history
  - Cancellations & refunds
- **Contact Form**
  - Integrated **PHP Mail**
  - Sends messages directly to the site owner’s email
- **Profile Management**
  - Edit personal details
  - View bookings & payments
- **Responsive UI**
  - Clean design with HTML, CSS, JS, Bootstrap

---

## 🛠 Tech Stack
- **Frontend:** HTML, CSS, JavaScript, Bootstrap  
- **Backend:** PHP, Flask (Python)  
- **Database:** MySQL (XAMPP)  
- **AI/Optimization:** Genetic Algorithm in Python  
- **Payment Gateway:** Stripe  
- **Email Handling:** PHP Mail  

---

## ⚙️ Installation & Setup

## 1. Clone the Repository

git clone https://github.com/Rifna-Raheem/trip-planner.git

## 2. Backend Setup (PHP + MySQL)
- Install **XAMPP**  
- Place `trip_planner/` folder in **htdocs**  
- Import `travel_planner.sql` into **phpMyAdmin**  
- Update `db.php` with your MySQL credentials  

## 3. Stripe Setup
- Add your **Stripe API keys** in:  
  - `create_payment_intent.php`  
  - `process_payment.php`  

## 4. PHP Mail Setup
- In `mail.php`, set your **password** and **recipient email address**  

## 5. Python AI Backend

- cd trip_planner/flask-backend
- pip install -r requirements.txt
- python app.py

## 6. Access Application
Open: http://localhost/trip_planner/Home.html


## 📂 Project Structure


trip_planner/
│── flask-backend/       # Flask server + AI optimization
│── img/                 # Images
│── *.php                # PHP backend scripts
│── *.html               # Frontend pages
│── *.css                # Stylesheets
│── travel_planner.sql   # Database schema
---

## 📷 Screenshots

### 🏠 Home Page
![Home Page](screenshots/home.png)

### 📅 Trip Planner
![Trip Planner](screenshots/booking.png)

### 💳 Payment Page
![Payment Page](screenshots/payment.png)


---

## 📜 License

This project is open-source under the MIT License.

