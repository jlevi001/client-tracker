# Lingo Client Tracker

A comprehensive client and project management system built for internal use at Lingo Technologies. This application provides robust client tracking, project management, user administration, and financial tracking capabilities.

## 🚀 Tech Stack

- **Backend**: Laravel 12.x with PHP 8.2+
- **Frontend**: Livewire 3 + Alpine.js
- **Styling**: Tailwind CSS with **daisyUI 5.0.50** for semantic components
- **Database**: MySQL 8
- **Authentication**: Laravel Jetstream (Livewire stack)
- **Permissions**: Spatie Laravel-Permission
- **Build Tool**: Vite

## 🎨 CRITICAL: Design System & Component Usage

### ⚠️ USE daisyUI - NOT Raw Tailwind Utilities!

This application uses **daisyUI** for ALL UI components. We have daisyUI installed specifically to ensure consistency and maintainability.

#### ❌ DO NOT write this:
```html
<!-- WRONG - Raw Tailwind utilities -->
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 
               focus:outline-none focus:ring-2 focus:ring-indigo-500">
```

#### ✅ ALWAYS write this:
```html
<!-- CORRECT - daisyUI semantic classes -->
<button class="btn btn-primary">
```

### Component Examples

```html
<!-- Buttons -->
<button class="btn btn-primary">Primary</button>
<button class="btn btn-secondary">Secondary</button>
<button class="btn btn-error">Delete</button>
<button class="btn btn-ghost">Cancel</button>

<!-- Inputs -->
<input class="input input-bordered w-full" />
<select class="select select-bordered w-full">
<textarea class="textarea textarea-bordered w-full"></textarea>

<!-- Cards -->
<div class="card bg-base-200">
  <div class="card-body">
    <!-- Content -->
  </div>
</div>

<!-- Tables -->
<table class="table table-zebra">
  <!-- Table content -->
</table>

<!-- Alerts -->
<div class="alert alert-success">Success message</div>
<div class="alert alert-error">Error message</div>
```

## 📁 Project Structure

```
lingo-client-tracker/
├── app/
│   ├── Http/
│   │   └── Livewire/       # Livewire components
│   └── Models/             # Eloquent models
├── resources/
│   ├── views/
│   │   ├── livewire/       # Livewire blade templates
│   │   └── components/     # Reusable blade components
│   └── css/
│       └── app.css         # Main stylesheet (imports Tailwind/daisyUI)
├── database/
│   └── migrations/         # Database migrations
├── docs/
│   └── AI_INSTRUCTIONS.md  # Comprehensive development guidelines
└── config/
    └── ui.php             # Centralized UI configuration (if exists)
```

## 🛠️ Installation & Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL 8

### Local Development Setup

1. **Clone the repository**
```bash
git clone https://github.com/jlevi001/client-tracker.git
cd client-tracker
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install Node dependencies**
```bash
npm install
```

4. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure your database in `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lingo_client_tracker
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. **Run migrations**
```bash
php artisan migrate
```

7. **Seed the database (if seeders exist)**
```bash
php artisan db:seed
```

8. **Build assets**
```bash
npm run dev
# or for production
npm run build
```

9. **Start the development server**
```bash
php artisan serve
```

Visit `http://localhost:8000` to view the application.

## 🌑 Dark Theme Configuration

This application uses a **dark theme exclusively**. The theme is configured in `tailwind.config.js`:

```javascript
// tailwind.config.js
module.exports = {
  // ... other config
  daisyui: {
    themes: [
      {
        dark: {
          "primary": "#6366f1",      // Indigo
          "secondary": "#8b5cf6",     // Purple
          "accent": "#10b981",        // Green
          "neutral": "#374151",       // Gray
          "base-100": "#1f2937",      // Background
          "base-200": "#111827",      // Darker bg
          "base-300": "#0f172a",      // Darkest bg
          // ... other colors
        }
      }
    ],
  }
}
```

### Color Usage
- **Backgrounds**: Use `bg-base-100`, `bg-base-200`, `bg-base-300` (NOT `bg-gray-xxx`)
- **Primary Actions**: Use `btn-primary` class
- **Danger Actions**: Use `btn-error` class
- **Success States**: Use `alert-success` class

## 📱 Mobile Responsiveness

**All components must be mobile-responsive.** Test on these breakpoints:
- Mobile: 375px
- Tablet: 768px (`sm:`)
- Desktop: 1024px (`lg:`)
- Wide: 1920px (`xl:`)

### Responsive Patterns
```html
<!-- Full width on mobile, auto width on larger screens -->
<button class="btn btn-primary w-full sm:w-auto">Save</button>

<!-- Stack on mobile, side-by-side on desktop -->
<div class="flex flex-col sm:flex-row gap-4">
  <!-- Content -->
</div>
```

## 👨‍💻 Development Guidelines

### Before Creating Any Component:
1. **Read `/docs/AI_INSTRUCTIONS.md`** for comprehensive guidelines
2. **Use daisyUI classes** for all UI components
3. **Never use raw Tailwind** for component styling
4. **Test on all breakpoints** (mobile, tablet, desktop)
5. **Maintain dark theme** consistency

### Creating New Components

When creating new Livewire components:

```php
// app/Http/Livewire/ComponentName.php
class ComponentName extends Component
{
    // Component logic
}
```

```blade
<!-- resources/views/livewire/component-name.blade.php -->
<div>
    <!-- Use daisyUI classes -->
    <div class="card bg-base-200">
        <div class="card-body">
            <button class="btn btn-primary">Action</button>
        </div>
    </div>
</div>
```

### State Management
- **Use Livewire properties** for server-side state
- **Use Alpine.js** for client-side interactions
- **Never use localStorage/sessionStorage** in development

## 🔑 Key Features

### Currently Implemented
- ✅ User Management System
- ✅ Role-based Permissions (Admin, Manager, Employee)
- ✅ Wage History Tracking
- ✅ Dark Theme Throughout
- ✅ Mobile Responsive Design

### Planned Features
- 🔄 Client Management
- 🔄 Project Tracking
- 🔄 Time Tracking
- 🔄 Invoice Generation
- 🔄 Reporting Dashboard

## 🚦 Quick Reference

### daisyUI Component Classes
| Component | Class | Usage |
|-----------|-------|-------|
| Primary Button | `btn btn-primary` | Main actions |
| Secondary Button | `btn btn-secondary` | Secondary actions |
| Cancel Button | `btn btn-ghost` | Cancel/close actions |
| Text Input | `input input-bordered` | Form inputs |
| Select | `select select-bordered` | Dropdowns |
| Card | `card bg-base-200` | Content containers |
| Table | `table` | Data tables |
| Success Alert | `alert alert-success` | Success messages |
| Error Alert | `alert alert-error` | Error messages |

### Tailwind Utilities (Use ONLY for layout)
- **Layout**: `flex`, `grid`, `container`
- **Spacing**: `p-4`, `m-2`, `gap-4`, `space-y-4`
- **Responsive**: `sm:`, `md:`, `lg:`, `xl:`
- **Width/Height**: `w-full`, `h-screen`, `max-w-md`

## 📝 Contributing

1. Follow the design system using daisyUI components
2. Ensure all components are mobile-responsive
3. Test on multiple screen sizes
4. Maintain dark theme consistency
5. Write clean, documented code
6. Create meaningful commit messages

## 🔒 Production Deployment

### Server Information
- **Hosting**: Cloudways
- **Server Path**: `/home/master/applications/fmayejttab/public_html`
- **PHP Version**: 8.2+
- **Database**: MySQL 8

### Deployment Steps
```bash
# On production server
git pull origin main
composer install --optimize-autoloader --no-dev
npm install
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
```

## 📚 Documentation

- **AI Development Instructions**: [`/docs/AI_INSTRUCTIONS.md`](./docs/AI_INSTRUCTIONS.md)
- **daisyUI Documentation**: [https://daisyui.com](https://daisyui.com)
- **Laravel Documentation**: [https://laravel.com/docs](https://laravel.com/docs)
- **Livewire Documentation**: [https://livewire.laravel.com](https://livewire.laravel.com)

## 🤖 AI Assistant Development

When working with AI assistants on this project:
1. Always reference `/docs/AI_INSTRUCTIONS.md`
2. Emphasize using daisyUI over raw Tailwind
3. Ensure dark theme compliance
4. Verify mobile responsiveness

## ⚠️ Important Notes

- **NEVER** use white/light backgrounds
- **ALWAYS** use daisyUI component classes
- **ALWAYS** test mobile responsiveness
- **NEVER** use localStorage or sessionStorage
- **ALWAYS** follow the dark theme design system

## 📞 Support

For internal support and questions:
- **Project Lead**: [Contact Information]
- **GitHub Issues**: [https://github.com/jlevi001/client-tracker/issues](https://github.com/jlevi001/client-tracker/issues)

---

**Built with ❤️ for Lingo IT Company**

*Last Updated: January 2025*
