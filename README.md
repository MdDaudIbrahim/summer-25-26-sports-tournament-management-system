# Sports Tournament Management System

A clean, responsive, and minimalist web application for managing sports tournaments, designed and developed strictly according to the **AIUB Web Technologies (CSC 3222)** laboratory and examination standards.

---

## 👥 User Roles & Responsibilities

1. **Admin**
   - Create and manage tournaments
   - View real-time Tournament Analytics Dashboard
   - Monitor live tournaments & venue schedules with clash alerts

2. **Coach**
   - Register teams for tournaments and pay registration fees
   - Track player performance and statistics
   - Match Lineup & Starting 5 Strategy Manager

3. **Spectator**
   - View match schedules, venues, and teams
   - Purchase tickets and verify payments
   - Participate in fan voting and live match predictions

4. **Employee**
   - Manage venues and equipment inventory
   - Manage match preparation checklist tasks
   - Report incidents and maintenance issues

---

## 🛠️ Technology Stack & Architecture

- **Frontend**: Pure Semantic HTML5, Vanilla CSS3 (Modular external stylesheets), Vanilla JavaScript (Native DOM APIs & Event Listeners)
- **Backend**: Native PHP (Procedural MySQLi, `cleanInput()` server-side sanitization, prepared statements)
- **Database**: MySQL (`backend/db_schema.sql`)
- **Zero External Dependencies**: No Tailwind CDN, No Bootstrap, No Google Fonts CDN, No External APIs. 100% offline-compatible native web technologies.

---

## 📁 File Structure

```
sports_tournament_management_system/
├── css/
│   ├── style.css             # Base resets, typography, color palette, utilities
│   ├── components.css        # Form elements, buttons, badges, tables, alerts
│   └── dashboard.css         # Sidebar layout, top navbar, bento grid, scoreboard
├── js/
│   ├── validation.js         # Client-side form validation (Login, Registration, Incident)
│   └── dashboard.js          # Interactive checklist counter, prediction poll, live score
├── backend/
│   ├── db_schema.sql         # MySQL database schema & sample seed data
│   ├── db_connect.php        # Procedural mysqli_connect() database connection
│   ├── process_login.php     # Session authentication & role routing
│   ├── process_registration.php # User registration with cleanInput() sanitization
│   ├── process_incident.php  # Employee incident reporting handler
│   ├── process_prediction.php# Spectator fan match prediction handler
│   └── process_team_reg.php  # Coach team registration handler
├── index.html                # Entry point redirecting to login.html
├── login.html                # Login Authentication View
├── registration.html         # User Registration View
├── admin_dashboard.html      # Admin Panel Dashboard View
├── coach_dashboard.html      # Coach Panel Dashboard View
├── employee_dashboard.html   # Employee Panel Dashboard View
└── spectator_dashboard.html  # Spectator Panel Dashboard View
```

---

## 🚀 Getting Started

1. Clone the repository:
   ```bash
   git clone https://github.com/MdDaudIbrahim/wbt-summer-project-25-26.git
   ```
2. Place the folder into your local web server root (e.g. `htdocs` for XAMPP or `www` for WampServer).
3. Import `backend/db_schema.sql` into MySQL using phpMyAdmin or MySQL CLI:
   ```bash
   mysql -u root -p < backend/db_schema.sql
   ```
4. Open your browser and navigate to:
   ```
   http://localhost/sports_tournament_management_system/
   ```
