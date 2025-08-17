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
1. **Clone the Repository**
```bash
git clone https://github.com/YOUR_USERNAME/trip-planner.git

Backend Setup (PHP + MySQL)

Install XAMPP

Place trip_planner/ folder in htdocs

Import travel_planner.sql into phpMyAdmin

Update db.php with your MySQL credentials

Stripe Setup

Add your Stripe API keys in create_payment_intent.php & process_payment.php

PHP Mail Setup

In mail.php, set your recipient email address

Python AI Backend

cd trip_planner/flask-backend
pip install -r requirements.txt
python app.py

Access Application
Open: http://localhost/trip_planner/Home.html
📂 Project Structure
trip_planner/
│── flask-backend/       # Flask server + AI optimization
│── img/                 # Images
│── *.php                # PHP backend scripts
│── *.html               # Frontend pages
│── *.css                # Stylesheets
│── travel_planner.sql   # Database schema

📷 Screenshots

(Add screenshots if available)

📜 License

This project is open-source under the MIT License.


---

## **3️⃣ Collaboration: How to Show Your Team**
- ✅ **GitHub README:** The **Team Members** section is the formal way (you don’t need to do more, recruiters check README).  
- ✅ **GitHub Repo "About" Section:** Just add a short description of the project (not required to list teammates here).  
- ✅ **LinkedIn Post:** LinkedIn lets you “Add collaborators.” You can **tag your teammate** so it appears for both of you. That’s the best and most professional approach.  

👉 You don’t need to formally add collaborators in GitHub unless you want both of you to push code to the repo. For portfolio purposes, **listing names in README + tagging on LinkedIn is enough and formal**.  

---

⚡ So, next steps for you:
1. Create `README.md` in VS Code → paste the above content.  
2. Replace `[Your Full Name]` and `[Friend’s Full Name]`.  
3. Run the Git commands I gave you earlier to push the project.  
4. On LinkedIn, make your post and tag your friend as collaborator.  

---

Do you want me to also **write the LinkedIn post again, but this time mentioning collaboration/teamwork** so you can just copy-paste it?
