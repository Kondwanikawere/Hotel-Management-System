
# Hotel Management System

A responsive, user-friendly hotel management system designed for seamless room bookings, customer and admin management. Built with **Laravel**, **Vue.js** (via **Inertia.js**), **Tailwind CSS**, and **MySQL**.

---

## 🌟 Features

### 💻 General User Interface
- User-friendly and intuitive navigation
- Fully responsive layout for mobile and desktop
- Consistent layout and color scheme aligned with organization branding

---

## 👤 Customer Dashboard
- View different **types of rooms**
- Access the **notification page**
- Manage **user profile**
- Update **settings** (profile and credentials)
- Navigate via a structured **menu**
- **Booking request** page/button
- **Registration page** for new users
- **Log out confirmation** dialogue
- **Cancel booking request** with confirmation

---

## 🛠️ Administrator Dashboard
- Manage **room types**
- View **customer detail page**
- View and manage **user profiles** including **payment details**
- Access and update **settings**
- **Login** page for administrators
- **Check-in / Check-out** functionality
- View list of **booked and vacant rooms**
- Manage **booking requests**

---

## 🏠 Home Page
- Welcoming interface with branding-compliant visuals

---

## 🧩 UI Components
- **Search bar** and **filter** options
- **Confirmation dialogues** for critical actions
- **Visual indicators** for room status (e.g., color-coded)
- Persistent **log-out** functionality

---

## ⚙️ Tech Stack

| Layer      | Technology           |
|------------|----------------------|
| Backend    | Laravel              |
| Frontend   | Vue.js + Inertia.js  |
| Styling    | Tailwind CSS         |
| Database   | MySQL                |

---

## 🚀 Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/hotel-management-system.git
   cd hotel-management-system
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Configure environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Set up the database:**
   - Update database settings in `.env`
   - Then run:
     ```bash
     php artisan migrate --seed
     ```

5. **Run development servers:**
   ```bash
   php artisan serve
   npm run dev
   ```

---

## 📜 License

This project is licensed under the [MIT License](LICENSE).

---

## 👨‍💻 Author

Developed by [Your Name / Your Team]. Contributions and feedback are welcome via pull requests or issues.
