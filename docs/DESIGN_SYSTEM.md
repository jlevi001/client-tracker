# Lingo Client Tracker - Design System & UI Standards

## Core Design Principles
- **Dark Theme Only**: The entire application uses a dark theme for reduced eye strain and modern aesthetics
- **Mobile-First Responsive**: All components must work flawlessly on mobile phones, tablets, and desktop computers
- **Consistent Spacing**: Use standardized padding and margins throughout
- **Visual Hierarchy**: Clear distinction between sections while maintaining unity

## Color Palette (Dark Theme)

### Background Colors
- **Main Background**: `bg-gray-900` (#111827)
- **Card/Modal Background**: `bg-gray-800` (#1f2937)
- **Input Fields**: `bg-gray-700` (#374151)
- **Hover States**: `bg-gray-600` (#4b5563)

### Text Colors
- **Primary Text**: `text-white` or `text-gray-100`
- **Secondary Text**: `text-gray-300`
- **Muted Text**: `text-gray-400` or `text-gray-500`
- **Labels**: `text-gray-300`

### Border Colors
- **Input Borders**: `border-gray-600`
- **Dividers**: `border-gray-700`
- **Focus Borders**: `border-indigo-500`

### Accent Colors
- **Primary Actions**: `bg-indigo-600 hover:bg-indigo-700`
- **Success**: `bg-green-600 hover:bg-green-700`
- **Danger**: `bg-red-600 hover:bg-red-700`
- **Warning**: `bg-yellow-600 hover:bg-yellow-700`
- **Info**: `bg-blue-600 hover:bg-blue-700`

## Form Field Standards

### Standard Input Field
```html
<input class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md 
             text-white placeholder-gray-400
             focus:bg-gray-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 
             hover:bg-gray-600 transition-colors duration-200">
```

### Select Dropdown
```html
<select class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md 
              text-white focus:bg-gray-600 focus:border-indigo-500 focus:ring-1 
              focus:ring-indigo-500 hover:bg-gray-600 transition-colors duration-200">
    <option value="">Select an option</option>
</select>
```

### Textarea
```html
<textarea class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md 
                text-white placeholder-gray-400
                focus:bg-gray-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 
                hover:bg-gray-600 transition-colors duration-200">
</textarea>
```

### Checkbox
```html
<input type="checkbox" class="rounded bg-gray-700 border-gray-600 text-indigo-600 
                              focus:ring-indigo-500 focus:ring-offset-gray-800">
```

### Radio Button
```html
<input type="radio" class="bg-gray-700 border-gray-600 text-indigo-600 
                           focus:ring-indigo-500 focus:ring-offset-gray-800">
```

## Button Styles

### Primary Button
```html
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 
               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
               focus:ring-offset-gray-800 transition-colors duration-200">
    Primary Action
</button>
```

### Secondary Button
```html
<button class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 
               focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 
               focus:ring-offset-gray-800 transition-colors duration-200">
    Secondary Action
</button>
```

### Danger Button
```html
<button class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 
               focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 
               focus:ring-offset-gray-800 transition-colors duration-200">
    Delete
</button>
```

### Success Button
```html
<button class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 
               focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 
               focus:ring-offset-gray-800 transition-colors duration-200">
    Save
</button>
```

### Text Button (Inline Actions)
```html
<button class="text-indigo-400 hover:text-indigo-300 focus:outline-none 
               focus:underline transition-colors duration-200">
    Edit
</button>
```

### Icon Button
```html
<button class="p-2 text-gray-400 hover:text-gray-300 hover:bg-gray-700 
               rounded-md transition-colors duration-200">
    <svg class="w-5 h-5"><!-- icon --></svg>
</button>
```

## Modal Layout Structure

### Complete Modal Template
```html
<div class="bg-gray-800 rounded-lg">
    <!-- Modal Header -->
    <div class="px-6 py-4 border-b border-gray-700">
        <h3 class="text-lg font-medium text-white">Modal Title</h3>
    </div>
    
    <!-- Modal Body -->
    <div class="px-6 py-4 space-y-6 max-h-[70vh] overflow-y-auto">
        <!-- Form Section -->
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    Field Label
                </label>
                <input type="text" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 
                                         rounded-md text-white placeholder-gray-400">
            </div>
        </div>
        
        <!-- Section Divider -->
        <div class="pt-6 border-t border-gray-700">
            <h4 class="text-md font-medium text-gray-300 mb-4">Section Title</h4>
            <!-- Section content -->
        </div>
    </div>
    
    <!-- Modal Footer -->
    <div class="px-6 py-4 bg-gray-900 border-t border-gray-700 flex justify-end space-x-3 rounded-b-lg">
        <button class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
            Cancel
        </button>
        <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            Save
        </button>
    </div>
</div>
```

## Spacing Standards

### Consistent Spacing Rules
- **Between form fields**: `space-y-4` or `mt-4`
- **Section padding**: `p-4` for compact, `p-6` for standard
- **Between sections**: `mt-6` or `space-y-6`
- **Card/Container padding**: `p-6`
- **Button spacing**: `space-x-3` for horizontal, `space-y-3` for vertical
- **Label to input**: `mb-2`
- **After headers**: `mb-4`

## Information Display Components

### Data Display Box
```html
<div class="p-4 bg-gray-700 border border-gray-600 rounded-lg">
    <div class="flex flex-wrap items-center gap-4">
        <div class="flex items-center space-x-2">
            <span class="text-gray-400 text-sm">Label:</span>
            <span class="text-white bg-gray-800 px-3 py-1 rounded">Value</span>
        </div>
    </div>
</div>
```

### Stats Card
```html
<div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-400 text-sm">Label</p>
            <p class="text-2xl font-bold text-white mt-1">Value</p>
        </div>
        <div class="text-indigo-500">
            <!-- Icon -->
        </div>
    </div>
</div>
```

## Table Styles

### Responsive Table
```html
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-700">
        <thead class="bg-gray-800">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                    Column Header
                </th>
            </tr>
        </thead>
        <tbody class="bg-gray-900 divide-y divide-gray-700">
            <tr class="hover:bg-gray-800">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                    Cell Content
                </td>
            </tr>
        </tbody>
    </table>
</div>
```

## Alert/Notification Styles

### Success Alert
```html
<div class="p-4 bg-green-900 border border-green-700 text-green-300 rounded-lg">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2"><!-- success icon --></svg>
        <span>Success message</span>
    </div>
</div>
```

### Error Alert
```html
<div class="p-4 bg-red-900 border border-red-700 text-red-300 rounded-lg">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2"><!-- error icon --></svg>
        <span>Error message</span>
    </div>
</div>
```

### Warning Alert
```html
<div class="p-4 bg-yellow-900 border border-yellow-700 text-yellow-300 rounded-lg">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2"><!-- warning icon --></svg>
        <span>Warning message</span>
    </div>
</div>
```

### Info Alert
```html
<div class="p-4 bg-blue-900 border border-blue-700 text-blue-300 rounded-lg">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2"><!-- info icon --></svg>
        <span>Info message</span>
    </div>
</div>
```

## Mobile Responsiveness

### Responsive Patterns
1. **Flex Direction**: `flex flex-col sm:flex-row`
2. **Grid Columns**: `grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3`
3. **Padding**: `p-4 sm:p-6`
4. **Text Size**: `text-sm sm:text-base`
5. **Button Width**: `w-full sm:w-auto`
6. **Stack on Mobile**: `space-y-4 sm:space-y-0 sm:space-x-4`

### Mobile-Specific Rules
- Minimum touch target size: 44x44px
- Full-width buttons on mobile
- Stack form fields vertically
- Hide non-essential columns in tables
- Convert complex layouts to cards

## File Upload Component

```html
<div class="mt-2">
    <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-600 
                border-dashed rounded-lg bg-gray-700 hover:bg-gray-600 
                hover:border-gray-500 transition-colors duration-200 cursor-pointer">
        <div class="space-y-1 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400">
                <!-- upload icon -->
            </svg>
            <div class="flex text-sm text-gray-400">
                <label class="relative cursor-pointer rounded-md font-medium text-indigo-400 
                              hover:text-indigo-300">
                    <span>Upload a file</span>
                    <input type="file" class="sr-only">
                </label>
                <p class="pl-1">or drag and drop</p>
            </div>
            <p class="text-xs text-gray-500">PNG, JPG, PDF up to 10MB</p>
        </div>
    </div>
</div>
```

## Loading States

### Loading Spinner
```html
<div class="flex justify-center items-center p-4">
    <svg class="animate-spin h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
    </svg>
</div>
```

### Loading Overlay
```html
<div class="relative">
    <div class="opacity-50 pointer-events-none">
        <!-- Content being loaded -->
    </div>
    <div class="absolute inset-0 flex items-center justify-center">
        <!-- Loading spinner -->
    </div>
</div>
```

## Accessibility Guidelines

1. **Focus States**: All interactive elements must have visible focus states
2. **Color Contrast**: Maintain WCAG AA minimum contrast ratios
3. **ARIA Labels**: Use for icon-only buttons and complex interactions
4. **Keyboard Navigation**: Ensure all features are keyboard accessible
5. **Screen Readers**: Use semantic HTML and proper heading hierarchy
6. **Alt Text**: Provide for all images and icons
7. **Error Messages**: Associate with form fields using aria-describedby

## Implementation Checklist

- [ ] All backgrounds use gray-700, gray-800, or gray-900
- [ ] All text uses appropriate contrast colors
- [ ] All inputs have hover and focus states
- [ ] All buttons follow the standard button styles
- [ ] Proper spacing between all elements
- [ ] Mobile responsive using Tailwind utilities
- [ ] Loading states for async operations
- [ ] Error states for form validation
- [ ] Consistent border colors throughout
- [ ] Proper typography hierarchy

## Notes for Developers

1. **Never use white backgrounds** in the dark theme
2. **Always test on mobile devices** not just browser responsive mode
3. **Use Tailwind utilities only** - no custom CSS unless absolutely necessary
4. **Maintain consistency** - if you need a new pattern, add it to this guide
5. **Accessibility is not optional** - all components must be accessible
6. **Performance matters** - use transitions sparingly and optimize images
7. **Test in dark mode** - ensure all third-party components respect the theme