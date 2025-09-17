# Lingo Client Tracker

A comprehensive client and project management system built for internal use at Lingo Technologies. This application provides robust client tracking, project management, user administration, and financial tracking capabilities.

## 🎉 MAJOR UPDATE: daisyUI Migration Complete!

As of September 2025, we've successfully migrated **100%** of the application from raw Tailwind utilities to semantic daisyUI components, resulting in:
- **70% reduction** in HTML class verbosity
- **Consistent dark theme** across all components
- **Improved mobile responsiveness**
- **Better maintainability** and developer experience
- **Faster development** with reusable components

## 🚀 Tech Stack

- **Backend**: Laravel 12.x with PHP 8.2+
- **Frontend**: Livewire 3 + Alpine.js
- **Styling**: Tailwind CSS 3.4.0 + **daisyUI 5.0.50** (Primary UI Framework)
- **Database**: MySQL 8
- **Authentication**: Laravel Jetstream (Livewire stack)
- **Permissions**: Spatie Laravel-Permission
- **Build Tool**: Vite

## 🎨 Design System & Component Library

### We Use daisyUI - NOT Raw Tailwind!

This application has been migrated to use **daisyUI** semantic component classes. This means cleaner, more maintainable code.

#### Component Examples:
```blade
<!-- ✅ CORRECT: Using daisyUI -->
<button class="btn btn-primary">Save</button>
<input class="input input-bordered w-full" />
<div class="card bg-base-200">
    <div class="card-body">Content</div>
</div>

<!-- ❌ WRONG: Raw Tailwind utilities -->
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
```

## ✅ Migration Status

### Completed Components
| Component Category | Files | Status |
|-------------------|-------|--------|
| **Buttons** | All button components | ✅ Complete |
| **Forms** | Input, select, textarea, checkbox, radio, toggle | ✅ Complete |
| **Modals** | All modal variations | ✅ Complete |
| **Tables** | Data tables with sorting/pagination | ✅ Complete |
| **Navigation** | Main nav, mobile drawer | ✅ Complete |
| **Alerts** | Success, error, warning, info | ✅ Complete |
| **Cards** | Content cards, form sections | ✅ Complete |
| **Authentication** | All auth views | ✅ Complete |
| **Profile Management** | All profile forms | ✅ Complete |
| **User Management** | Complete CRUD interface | ✅ Complete |

### Component Library

We have a comprehensive set of reusable Blade components:

```blade
<!-- Buttons -->
<x-button>Primary</x-button>
<x-secondary-button>Secondary</x-secondary-button>
<x-danger-button>Delete</x-danger-button>

<!-- Form Controls -->
<x-form-control label="Email" for="email" :error="$errors->first('email')">
    <x-input id="email" type="email" wire:model="email" />
</x-form-control>

<!-- Modals -->
<x-dialog-modal wire:model="showModal">
    <x-slot name="title">Modal Title</x-slot>
    <x-slot name="content">Content here</x-slot>
    <x-slot name="footer">
        <x-button>Save</x-button>
    </x-slot>
</x-dialog-modal>

<!-- Alerts -->
<x-validation-errors />
<x-action-message on="saved">Saved successfully!</x-action-message>
```

## 📁 Project Structure

```
lingo-client-tracker/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # HTTP Controllers
│   │   └── Livewire/        # Livewire Components
│   ├── Models/              # Eloquent Models
│   └── Providers/           # Service Providers
├── resources/
│   ├── views/
│   │   ├── auth/            # Authentication views (migrated ✅)
│   │   ├── components/      # Blade components (migrated ✅)
│   │   ├── layouts/         # Layout templates
│   │   ├── livewire/        # Livewire templates (migrated ✅)
│   │   ├── profile/         # Profile management (migrated ✅)
│   │   └── api/             # API token management (migrated ✅)
│   ├── css/
│   │   └── app.css          # Main stylesheet
│   └── js/
│       └── app.js           # Main JavaScript
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── routes/
│   └── web.php              # Web routes
├── docs/
│   ├── ai-instructions.md   # AI development guide
│   ├── DAISYUI_CONVERSION_GUIDE.md  # Migration guide
│   └── MIGRATION_STATUS.md  # Detailed migration tracking
└── tailwind.config.js       # Tailwind + daisyUI config
```

## 🛠️ Installation & Setup

### Prerequisites
- PHP 8.2 or higher
- Composer 2.x
- Node.js 18+ & NPM
- MySQL 8.0+

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

5. **Configure database in `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lingo_client_tracker
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. **Run migrations and seeders**
```bash
php artisan migrate
php artisan db:seed  # Optional: seed with test data
```

7. **Build frontend assets**
```bash
npm run dev  # For development with hot reload
# OR
npm run build  # For production
```

8. **Start development server**
```bash
php artisan serve
```

Visit `http://localhost:8000` to view the application.

## 🌑 Dark Theme System

The application uses an **exclusive dark theme** powered by daisyUI's theming system:

### Theme Configuration (`tailwind.config.js`)
```javascript
daisyui: {
  themes: [{
    dark: {
      "primary": "#6366f1",      // Indigo-600
      "secondary": "#8b5cf6",     // Purple-600
      "accent": "#10b981",        // Green-600
      "base-100": "#1f2937",      // Gray-800 (main bg)
      "base-200": "#111827",      // Gray-900 (cards)
      "base-300": "#0f172a",      // Gray-950 (darkest)
      "success": "#10b981",       // Green-500
      "warning": "#f59e0b",       // Amber-500
      "error": "#ef4444",         // Red-500
      "info": "#3b82f6",          // Blue-500
    }
  }]
}
```

### Usage Guidelines
- **Backgrounds**: `bg-base-100`, `bg-base-200`, `bg-base-300`
- **Text**: `text-base-content`, `text-base-content/70` (muted)
- **Never use**: `bg-white`, `bg-gray-XXX`, `text-gray-XXX`

## 📱 Mobile Responsiveness

All components are **mobile-first responsive**:

### Breakpoints
- **Mobile**: 375px (base)
- **Tablet**: 768px (`sm:`)
- **Desktop**: 1024px (`lg:`)
- **Wide**: 1920px (`xl:`)

### Common Patterns
```blade
<!-- Full width on mobile, auto on desktop -->
<button class="btn btn-primary w-full sm:w-auto">

<!-- Stack on mobile, row on desktop -->
<div class="flex flex-col sm:flex-row gap-4">

<!-- Responsive grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

<!-- Hide/show based on screen size -->
<div class="hidden sm:block">Desktop only</div>
<div class="block sm:hidden">Mobile only</div>
```

## 🔑 Key Features

### Currently Implemented ✅
- **User Management System**
  - CRUD operations
  - Role assignment
  - Wage history tracking
  - Activity logging
- **Authentication & Security**
  - Two-factor authentication
  - Session management
  - Password policies
  - API token management
- **Role-Based Permissions**
  - Admin role
  - Manager role
  - Employee role
  - Custom permissions
- **UI/UX Features**
  - Dark theme throughout
  - Mobile responsive design
  - Real-time validation
  - Loading states
  - Error handling

### In Development 🚧
- **Client Management**
  - Client profiles
  - Contact information
  - Communication history
- **Project Tracking**
  - Project lifecycle
  - Milestone tracking
  - Task management
- **Financial Module**
  - Invoice generation
  - Payment tracking
  - Financial reports
- **Reporting Dashboard**
  - Analytics
  - Custom reports
  - Data exports

## 👨‍💻 Development Guidelines

### Before Writing Code
1. **Check existing components** in `/resources/views/components/`
2. **Read documentation** in `/docs/`
3. **Use daisyUI classes** - check [daisyui.com](https://daisyui.com)
4. **Follow established patterns** in existing code
5. **Test on mobile first**

### Creating New Components

#### Livewire Component
```php
// app/Http/Livewire/MyComponent.php
namespace App\Http\Livewire;

use Livewire\Component;

class MyComponent extends Component
{
    public $property = '';
    
    public function save()
    {
        $this->validate([
            'property' => 'required|string|max:255',
        ]);
        
        // Save logic
        
        $this->emit('saved');
    }
    
    public function render()
    {
        return view('livewire.my-component');
    }
}
```

#### Blade Component
```blade
{{-- resources/views/components/my-component.blade.php --}}
@props(['variant' => 'primary', 'size' => 'md'])

<div {{ $attributes->merge(['class' => 'card bg-base-200']) }}>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
```

### Code Style Guide
- Use **daisyUI components** for all UI elements
- Use **Tailwind utilities** only for layout and spacing
- Follow **PSR-12** for PHP code
- Use **Blade components** for reusable UI
- Implement **Livewire** for interactive features
- Add **loading states** for all async operations
- Include **error handling** for all user inputs

## 🧪 Testing

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run with coverage
php artisan test --coverage
```

### Testing Guidelines
- Write feature tests for all user workflows
- Write unit tests for business logic
- Test mobile responsiveness manually
- Verify dark theme consistency
- Check accessibility with screen readers

## 🚀 Deployment

### Production Server
- **Hosting**: Cloudways
- **Server Path**: `/home/master/applications/fmayejttab/public_html`
- **PHP Version**: 8.2+
- **Database**: MySQL 8

### Deployment Process
```bash
# On production server
git pull origin main
composer install --optimize-autoloader --no-dev
npm ci
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
php artisan queue:restart  # If using queues
```

### Environment Variables
Key production environment variables:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

## 📚 Documentation

### Project Documentation
- **AI Development Guide**: [`/docs/ai-instructions.md`](./docs/ai-instructions.md)
- **daisyUI Conversion Guide**: [`/docs/DAISYUI_CONVERSION_GUIDE.md`](./docs/DAISYUI_CONVERSION_GUIDE.md)
- **Migration Status**: [`/docs/MIGRATION_STATUS.md`](./docs/MIGRATION_STATUS.md)
- **Component Reference**: [`/resources/views/components/COMPONENT_REFERENCE.md`](./resources/views/components/COMPONENT_REFERENCE.md)

### External Resources
- **daisyUI Documentation**: [https://daisyui.com](https://daisyui.com)
- **Laravel Documentation**: [https://laravel.com/docs](https://laravel.com/docs)
- **Livewire Documentation**: [https://livewire.laravel.com](https://livewire.laravel.com)
- **Alpine.js Documentation**: [https://alpinejs.dev](https://alpinejs.dev)
- **Tailwind CSS**: [https://tailwindcss.com](https://tailwindcss.com)

## 🤝 Contributing

### Contribution Guidelines
1. **Follow the design system** - Use daisyUI components
2. **Maintain dark theme** - No light backgrounds
3. **Ensure mobile responsiveness** - Test all screen sizes
4. **Write clean code** - Follow PSR-12 standards
5. **Document changes** - Update relevant documentation
6. **Test thoroughly** - Write and run tests
7. **Create meaningful commits** - Use conventional commits

### Pull Request Process
1. Create feature branch from `main`
2. Make changes following guidelines
3. Test on multiple devices/browsers
4. Update documentation if needed
5. Submit PR with clear description
6. Wait for code review
7. Address feedback
8. Merge after approval

## 🔒 Security

### Reporting Security Issues
Please report security vulnerabilities privately to the development team. Do not create public issues for security problems.

### Security Best Practices
- Keep dependencies updated
- Use parameterized queries
- Validate all user input
- Implement CSRF protection
- Use HTTPS in production
- Regular security audits
- Follow OWASP guidelines

## ⚠️ Important Notes

### DO's ✅
- **DO** use daisyUI component classes
- **DO** maintain dark theme consistency
- **DO** test on mobile devices
- **DO** include loading states
- **DO** handle errors gracefully
- **DO** follow established patterns
- **DO** document complex logic

### DON'Ts ❌
- **DON'T** use raw Tailwind for components
- **DON'T** use light/white backgrounds
- **DON'T** forget mobile responsiveness
- **DON'T** use localStorage/sessionStorage
- **DON'T** hardcode colors
- **DON'T** skip error handling
- **DON'T** ignore accessibility

## 📊 Performance Optimization

### Current Optimizations
- Vite for fast builds and HMR
- Lazy loading for Livewire components
- Optimized database queries
- CDN for static assets
- Compressed images
- Minified CSS/JS in production

### Monitoring
- Laravel Telescope (development)
- Error tracking with logs
- Performance metrics tracking
- Database query optimization

## 🚦 Project Status

### Current Phase
✅ **Phase 1: Foundation** (Complete)
- User management
- Authentication system
- Role-based permissions
- UI component library
- daisyUI migration

🚧 **Phase 2: Core Features** (In Progress)
- Client management
- Project tracking
- Basic reporting

📅 **Phase 3: Advanced Features** (Planned)
- Financial module
- Advanced analytics
- API integrations
- Mobile app

## 📞 Support & Contact

### Development Team
- **Project Lead**: [Contact via GitHub]
- **GitHub Issues**: [https://github.com/jlevi001/client-tracker/issues](https://github.com/jlevi001/client-tracker/issues)
- **Documentation**: Check `/docs/` folder

### Getting Help
1. Check documentation first
2. Search existing issues
3. Create detailed issue with:
   - Steps to reproduce
   - Expected behavior
   - Actual behavior
   - Screenshots if applicable
   - Environment details

---

**Built with ❤️ for Lingo IT Company**

*Last Updated: January 2025 - Post daisyUI Migration*
