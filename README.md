# Chandra Daya Investasi - Modern Headless CMS (2026)

Modern, high-performance headless Content Management System for **PT Chandra Daya Investasi Tbk (CDI Group)**, built with **Laravel 12** and **Filament v3**.

This CMS operates side-by-side with the Next.js frontend (`cdi-fe`) and connects directly to the shared SQLite database (`database.sqlite`, 32 tables) without any schema alterations.

---

## Architecture & Key Features

- **Filament v3 Admin Panel**: Clean, modern dark-mode & responsive interface on port `8001` (`http://localhost:8001/admin`).
- **Visual Component Stack**: Page Management is organized into top-to-bottom vertical component stacks matching the exact visual flow of public pages:
  1. **Home Page Content**: Hero Banner ➔ About CDI ➔ Infrastructure 4-Pillar Tabs ➔ Discover ➔ Journey ➔ Reports ➔ News ➔ Quick Links.
  2. **About Us Content**: Hero Banner ➔ Overview & Video ➔ Vision & Mission ➔ Milestones & Profiles ➔ Board & Management ➔ Awards & Accreditations ➔ Historical Feeds.
  3. **Our Business Content**: Hero Banner ➔ Overview Narrative ➔ 4 Core Business Pillars Feed.
  4. **Sustainability Content**: Main Overview ➔ 3 ESG Pillars (Environment, Social, Governance) ➔ Reports & In Action ➔ Dedicated Pillars & PDF Reports.
  5. **Investor Relations Content**: Reports & Highlights ➔ Financial Information ➔ Shares, Dividends & Bonds ➔ Publications ➔ Presentations & Institutions.
  6. **Governance Content**: Hero Banner ➔ Corporate Secretary ➔ Internal Audit Unit ➔ Committees ➔ Risk Management & SHE ➔ Whistleblowing System (WBS).
  7. **Quick & Footer Links**: Categorized link directories with sorting orders.
  8. **Global & Legal Settings**: Social channels, Whistleblowing email PIC dispatch, Privacy Policy, Terms, Cookies, Disclaimer, and AI Search files (`llms.txt`).
  9. **SEO & Meta Tags**: OpenGraph & Twitter preview cards, titles, and descriptions for all site routes.
- **On-Demand Cache Purging (ISR)**: Triggers Next.js on-demand revalidation (`/api/revalidate`) via `RevalidationService` automatically on content publish.
- **Zero Schema Change**: 100% compatible with existing database schemas and data relationships.

---

## Requirements

- PHP 8.2 or 8.3+
- Composer 2+
- SQLite3 extension enabled

---

## Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/felixzzz/cdi-cms-26.git cdi-cms
   cd cdi-cms
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Configure Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Ensure `DB_DATABASE` points to your SQLite database path (e.g. `../cdi-be/database/database.sqlite`).

4. **Create Storage Symlink:**
   ```bash
   php artisan storage:link
   ```

5. **Run the Development Server:**
   ```bash
   php artisan serve --port=8001
   ```
   The CMS will be accessible at:
   `http://localhost:8001/admin`

---

## Default Admin Credentials

Existing admin users from the shared database:
- **Email:** `management@chandradaya-investasi.com` or `portal@admin.com`
- **Password:** `P@ssw0rd`

---

## Running Automated Tests

Run the full PHPUnit test suite:
```bash
./vendor/bin/phpunit
```
All feature tests cover authentication, page management component mounting, saving, and table rendering.
