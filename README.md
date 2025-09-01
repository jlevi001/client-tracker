<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Design System & Development Standards

This project follows a strict dark theme design system to ensure consistency across all components.

### 📚 Documentation
- **Design System**: See `/docs/DESIGN_SYSTEM.md` for complete UI/UX standards
- **AI Instructions**: See `/AI_INSTRUCTIONS.md` for development guidelines
- **UI Configuration**: See `/config/ui.php` for centralized styling classes

### 🎨 Key Design Principles
1. **Dark Theme Only** - All interfaces use dark backgrounds (gray-700/800/900)
2. **Mobile-First** - Every component must be fully responsive
3. **Consistent Spacing** - Standardized padding and margins throughout
4. **Accessibility** - WCAG AA compliant with proper focus states

### 🧩 Using Dark Theme Components
We provide pre-built Blade components that automatically apply our design system:

```blade
<!-- Dark themed input -->
<x-dark-input type="email" wire:model="email" placeholder="Enter email" />

<!-- Dark themed select -->
<x-dark-select wire:model="role">
    <option value="">Select a role</option>
    <option value="admin">Admin</option>
</x-dark-select>

<!-- Dark themed button -->
<x-dark-button variant="primary" wire:click="save">
    Save Changes
</x-dark-button>

<!-- Dark themed label -->
<x-dark-label for="name" value="Full Name" />
```

### 🛠 Development Workflow
1. Always review `/docs/DESIGN_SYSTEM.md` before creating new components
2. Use the pre-built dark components when possible
3. Reference `config('ui.classes.input')` for consistent styling
4. Test on mobile (375px), tablet (768px), and desktop (1920px)
5. Ensure all states (hover, focus, disabled) follow the design system

### ⚡ Quick Reference
- **Backgrounds**: `bg-gray-900` (main), `bg-gray-800` (cards), `bg-gray-700` (inputs)
- **Primary Button**: `bg-indigo-600 hover:bg-indigo-700`
- **Text Colors**: `text-white` (primary), `text-gray-300` (secondary)
- **Borders**: `border-gray-600` (default), `border-indigo-500` (focus)
- **Spacing**: `p-4` or `p-6` for sections, `space-y-4` between fields

### 📱 Responsive Breakpoints
- Mobile: 375px+
- Tablet: 768px+ (`sm:`)
- Desktop: 1024px+ (`lg:`)
- Wide: 1920px+ (`xl:`)

---
**Important**: Never use white/light backgrounds. All components must follow the dark theme design system for consistency.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
