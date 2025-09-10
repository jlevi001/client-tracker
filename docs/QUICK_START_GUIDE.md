# Quick Start Guide for New Developers

Welcome to the Lingo Client Tracker project! This guide will get you up and running quickly.

## 🎯 The Most Important Thing to Know

**We use daisyUI semantic components, NOT raw Tailwind utilities!**

```html
<!-- ❌ DON'T write this -->
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">

<!-- ✅ DO write this -->
<button class="btn btn-primary">
```

## 🚀 Getting Started in 5 Minutes

### 1. Clone and Setup (2 minutes)
```bash
git clone https://github.com/jlevi001/client-tracker.git
cd client-tracker
composer install
npm install
cp .env.example .env
php artisan key:generate
```

### 2. Configure Database (1 minute)
Edit `.env` file:
```env
DB_DATABASE=lingo_client_tracker
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 3. Run Migrations (1 minute)
```bash
php artisan migrate
php artisan db:seed  # Optional test data
```

### 4. Start Development (1 minute)
```bash
# Terminal 1
npm run dev

# Terminal 2
php artisan serve
```

Visit: http://localhost:8000

## 📚 Essential Documentation

Read these in order:
1. **This Guide** - You are here! ✅
2. **Component Reference** - `/resources/views/components/COMPONENT_REFERENCE.md`
3. **AI Instructions** - `/docs/ai-instructions.md` (if using AI assistants)
4. **Conversion Guide** - `/docs/DAISYUI_CONVERSION_GUIDE.md` (for migrations)

## 🎨 Component Cheat Sheet

### Most Used Components

#### Buttons
```blade
<x-button>Primary Action</x-button>
<x-secondary-button>Cancel</x-secondary-button>
<x-danger-button>Delete</x-danger-button>
```

#### Form Fields
```blade
<x-form-control label="Email" for="email" :error="$errors->first('email')">
    <x-input id="email" type="email" wire:model="email" />
</x-form-control>
```

#### Modals
```blade
<x-dialog-modal wire:model="showModal">
    <x-slot name="title">Modal Title</x-slot>
    <x-slot name="content">Content here</x-slot>
    <x-slot name="footer">
        <x-button>Save</x-button>
    </x-slot>
</x-dialog-modal>
```

#### Tables
```blade
<div class="overflow-x-auto">
    <table class="table table-zebra">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="hover">
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
```

#### Cards
```blade
<div class="card bg-base-200 shadow-xl">
    <div class="card-body">
        <h2 class="card-title">Card Title</h2>
        <p>Card content</p>
        <div class="card-actions justify-end">
            <button class="btn btn-primary">Action</button>
        </div>
    </div>
</div>
```

## 🌑 Dark Theme Colors

Never use raw colors! Use theme variables:

| Instead of | Use |
|------------|-----|
| `bg-gray-800` | `bg-base-100` |
| `bg-gray-900` | `bg-base-200` |
| `bg-gray-950` | `bg-base-300` |
| `text-white` | `text-base-content` |
| `text-gray-400` | `text-base-content/70` |
| `bg-indigo-600` | `bg-primary` |
| `bg-red-600` | `bg-error` |
| `bg-green-600` | `bg-success` |

## 📱 Mobile Responsiveness

Always make components mobile-first:

```blade
<!-- Full width on mobile, auto on desktop -->
<button class="btn btn-primary w-full sm:w-auto">

<!-- Stack on mobile, row on desktop -->
<div class="flex flex-col sm:flex-row gap-4">

<!-- Different columns per screen size -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
```

## ⚡ Livewire Integration

### Form with Loading States
```blade
<form wire:submit.prevent="save">
    <x-form-control label="Name" for="name">
        <x-input id="name" wire:model.defer="name" />
    </x-form-control>
    
    <x-button wire:loading.attr="disabled">
        <span wire:loading.remove>Save</span>
        <span wire:loading class="loading loading-spinner loading-sm"></span>
    </x-button>
</form>
```

### Real-time Validation
```blade
<x-input 
    wire:model.lazy="email"
    wire:blur="validateEmail"
    :class="$errors->has('email') ? 'input-error' : ''"
/>
<x-input-error for="email" :messages="$errors->get('email')" />
```

## 🧭 Project Structure

```
resources/views/
├── components/        # Reusable Blade components (USE THESE!)
├── livewire/         # Livewire component views
├── layouts/          # Page layouts
├── auth/             # Authentication pages
├── profile/          # User profile pages
└── api/              # API management pages

app/Http/
├── Livewire/         # Livewire component classes
└── Controllers/      # HTTP controllers

docs/
├── ai-instructions.md              # For AI assistants
├── DAISYUI_CONVERSION_GUIDE.md    # Migration guide
├── MIGRATION_STATUS.md            # What's completed
└── QUICK_START_GUIDE.md           # You are here!
```

## ✅ Development Checklist

Before committing code:
- [ ] Used daisyUI components (not raw Tailwind)
- [ ] Tested on mobile (375px)
- [ ] Tested on tablet (768px)
- [ ] Tested on desktop (1024px)
- [ ] Added loading states for async operations
- [ ] Handled error states
- [ ] Used theme colors (not hardcoded)
- [ ] Followed existing patterns

## 🚫 Common Mistakes to Avoid

### 1. Using Raw Tailwind for Components
```blade
<!-- ❌ WRONG -->
<button class="px-4 py-2 bg-indigo-600...">

<!-- ✅ RIGHT -->
<button class="btn btn-primary">
```

### 2. Hardcoding Colors
```blade
<!-- ❌ WRONG -->
<div class="bg-gray-800">

<!-- ✅ RIGHT -->
<div class="bg-base-100">
```

### 3. Forgetting Mobile
```blade
<!-- ❌ WRONG -->
<button class="btn btn-primary w-96">

<!-- ✅ RIGHT -->
<button class="btn btn-primary w-full sm:w-auto">
```

### 4. Not Using Form Control Wrapper
```blade
<!-- ❌ WRONG -->
<label>Email</label>
<input class="input input-bordered">
@error('email') {{ $message }} @enderror

<!-- ✅ RIGHT -->
<x-form-control label="Email" for="email" :error="$errors->first('email')">
    <x-input id="email" wire:model="email" />
</x-form-control>
```

## 💡 Pro Tips

1. **Check daisyUI Docs First**: [daisyui.com/components](https://daisyui.com/components)
2. **Use Existing Components**: Check `/resources/views/components/` before creating new ones
3. **Copy from Examples**: The codebase has many patterns to follow
4. **Ask Questions**: Better to ask than to use raw Tailwind
5. **Think Semantic**: `btn btn-primary` is clearer than utility classes

## 🆘 Getting Help

1. **Component Usage**: See `/resources/views/components/COMPONENT_REFERENCE.md`
2. **Migration Help**: See `/docs/DAISYUI_CONVERSION_GUIDE.md`
3. **Project Status**: See `/docs/MIGRATION_STATUS.md`
4. **GitHub Issues**: https://github.com/jlevi001/client-tracker/issues

## 🎯 Your First Task

1. Run the application locally
2. Navigate to User Management (`/users`)
3. Try creating, editing, and deleting a user
4. Look at `/resources/views/livewire/user-management.blade.php` to see patterns
5. Notice how it uses daisyUI components throughout

## 📈 What Success Looks Like

Your code should:
- Be 75% shorter than raw Tailwind
- Use semantic class names
- Work on all screen sizes
- Follow dark theme colors
- Include loading/error states
- Match existing patterns

## 🚀 Ready to Code!

You now know:
- ✅ We use daisyUI, not raw Tailwind
- ✅ Dark theme with `base-100/200/300` colors
- ✅ Mobile-first responsive design
- ✅ Component-based architecture
- ✅ Livewire for interactivity

**Welcome to the team! Let's build something great with clean, semantic code!**

---

*Questions? Check the documentation or ask the team!*
*Remember: When in doubt, use daisyUI!*
