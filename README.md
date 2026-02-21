# Laravel WatchPay Payout System

This is a robust and secure withdrawal management system built with Laravel 12, featuring seamless integration with the WatchPay API.

## ✨ Features
- **Dynamic Configuration:** Manage merchant credentials and gateway status directly from the Admin UI.
- **Automated Payouts:** One-click withdrawal initiation with real-time API response handling.
- **Secure Webhooks:** Built-in signature validation for incoming transaction notifications.
- **Advanced Dashboard:** Stylish UI for Pending, Approved, and Rejected requests using Tailwind CSS.
- **Safety First:** Database transaction management (rollback on failure) and IP whitelist ready.

## 🛠️ Tech Stack
- Laravel 12
- Tailwind CSS (Modern Dark UI)
- WatchPay Payment API
- MySQL

## 🚀 Installation
1. Clone the repository.
2. Run `composer install`.
3. Set up your `.env` file.
4. Run `php artisan install:api`.
5. Run `php artisan migrate`.
6. Configure your Merchant credentials from the Gateway Settings page.
