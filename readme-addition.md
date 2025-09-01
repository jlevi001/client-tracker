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