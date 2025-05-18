<h1 align="center">B2B Booking App</h1>

<p align="center">
<a href="#"><img src="https://img.shields.io/badge/status-beta-blue" alt="Project Status"></a>
<a href="#"><img src="https://img.shields.io/badge/license-MIT-green" alt="License"></a>
<a href="#"><img src="https://img.shields.io/badge/platform-B2B-lightgrey" alt="Platform Type"></a>
</p>

## About This App

This application is a **B2B booking platform** designed to seamlessly connect **accommodation providers** (such as hotels, hostels, and short-stay properties) with **transportation companies** (such as shuttle services, van rentals, or bus operators).

It empowers businesses to manage, collaborate, and streamline their operations—enabling them to offer **bundled travel experiences** and optimize logistics in one centralized system.

### Core Features

- 🔗 **Connect**: Link accommodation partners with transport providers in real-time.
- 🧾 **Manage Bookings**: Accept, track, and update bookings from either side of the network.
- 📅 **Sync Schedules**: Intelligent scheduling and calendar coordination for seamless planning.
- 💼 **Business Dashboard**: Manage listings, reservations, payments, and reports.
- ⚡ **Fast Onboarding**: Add partners and set up your business within minutes.

---

## Who Is It For?

This app is built specifically for:

- 🏨 Hotels and lodging networks looking to offer transfer services.
- 🚐 Transport operators aiming to tap into the accommodation market.
- 🧩 Travel agencies and coordinators who want to streamline bundled bookings.

---

## Getting Started

## 🚀 Installation Guide

Follow these steps to set up the project locally:

1. **Install Laravel Herd**  
   We recommend using [Laravel Herd](https://herd.laravel.com/) for a smooth local development experience. (Docker soon...)

2. **Clone the Repository**
   ```bash
   git clone https://github.com/your-username/your-repo-name.git
   cd your-repo-name
   ```

3. **Install Dependencies**
   ```bash
   composer install
   npm install && npm run build
   ```

4. **Configure with Laravel Herd**
   - Add the project to Laravel Herd by linking and parking the directory:
     ```bash
     valet link your-app-name
     valet park
     valet secure your-app-name
     ```
   - Alternatively, use Herd’s GUI to manage sites.

5. **Environment Setup**
   - Copy `.env.example` to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Update your `.env` file with the correct database and app settings.
   - Generate the application key:
     ```bash
     php artisan key:generate
     ```

6. **Run Database Migrations**
   ```bash
   sh ./scripts/fresh.sh
   ```
   The command above will run migration:fresh, add in the permissions and run the db:seeders

7. **A Super Admin account will be created during the seeding process**
   1. Check the email and password in the SuperAdminSeeder.php

8. **Access the Admin Panel**  
   Visit your site at:  
   `https://{your-local-domain}/admin` (e.g., `https://your-app-name.test/admin`)

---

## Native

1. Checkout installation docs for our [Native README.md](/ui/native/README.md) development.

---

Let me know if you want me to add optional steps like seeding the database or running tests!

## 🤝 Contributing

We welcome contributions from the community!  
Please read our [CONTRIBUTING.md](CONTRIBUTING.md) for step-by-step instructions and development workflow.

---

## License

This platform is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
