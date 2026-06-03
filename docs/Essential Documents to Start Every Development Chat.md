## 📋 Essential Documents to Start Every Development Chat

Based on the comprehensive documentation we've created, here are the **must-have documents** to attach at the beginning of every new development chat:

### 🎯 **Priority 1: Core Instructions** (Always Include These)

1. **`/docs/ai-instructions.md`** 
   - This is your MOST IMPORTANT document
   - Contains all development guidelines, component patterns, and what's already migrated
   - Shows exactly HOW to write code for this project
   - Includes the 95% migration status

2. **`/docs/DAISYUI_CONVERSION_GUIDE.md`**
   - Shows before/after examples for every component type
   - Critical for maintaining consistency
   - Prevents regression to raw Tailwind

### 📚 **Priority 2: Component Reference** (Include for Component Work)

3. **`/resources/views/components/COMPONENT_REFERENCE.md`**
   - Complete API documentation for all existing components
   - Shows how to USE the components that already exist
   - Prevents reinventing the wheel

### 📊 **Priority 3: Context Documents** (Include as Needed)

4. **`/README.md`** (For project overview)
   - When starting major new features
   - For understanding project structure
   - Shows tech stack and setup

5. **`/docs/MIGRATION_STATUS.md`** (For checking what's done)
   - When working on potentially unmigrated areas
   - To understand current progress
   - Shows what patterns are established

## 💬 **Ideal Chat Opening Message Template**

Here's a template for starting new development chats:

```markdown
I'm working on the Lingo Client Tracker project. Please review the attached documents carefully:

1. AI Instructions (CRITICAL - shows how we write code)
2. daisyUI Conversion Guide (shows component patterns)
[3. Component Reference - if doing component work]

Key points:
- We use daisyUI semantic classes, NOT raw Tailwind utilities
- 95% of components are already migrated
- Dark theme only with base-100/200/300 colors
- All components must be mobile responsive
- Check existing components before creating new ones

Current task: [Describe what you need to work on]

GitHub repo: https://github.com/jlevi001/client-tracker
```

## 🚀 **Quick Reference Card to Keep Handy**

Save this somewhere for quick copy-paste:

```markdown
## Project Standards for Lingo Client Tracker

ALWAYS:
✅ Use daisyUI components (btn btn-primary)
✅ Use theme colors (bg-base-100, text-base-content)
✅ Make mobile responsive (w-full sm:w-auto)
✅ Include loading states
✅ Use existing components from /resources/views/components/

NEVER:
❌ Use raw Tailwind for components (px-4 py-2 bg-indigo-600)
❌ Use gray colors (bg-gray-800)
❌ Hardcode colors
❌ Forget mobile testing
❌ Create new components without checking existing ones

Components: Check /resources/views/components/
Livewire: Check /resources/views/livewire/user-management.blade.php
Theme: Dark only with daisyUI theme variables
```

## 📁 **File Organization Tip**

Create a folder structure like this on your local machine:

```
Lingo-Client-Tracker-Docs/
├── 📄 ai-instructions.md (ALWAYS USE)
├── 📄 DAISYUI_CONVERSION_GUIDE.md (ALWAYS USE)
├── 📄 COMPONENT_REFERENCE.md (For component work)
├── 📄 README.md (For project overview)
├── 📄 MIGRATION_STATUS.md (To check progress)
└── 📄 Quick-Reference.md (The snippet above)
```

## ⚡ **Even Quicker Start**

If you're in a hurry and can only attach ONE document:

**Use `/docs/ai-instructions.md`** - It contains:
- Component usage patterns
- Migration status
- Code examples
- What to do and what NOT to do
- Links to other resources

## 🎯 **For Specific Task Types**

### Creating New Components:
1. `ai-instructions.md`
2. `COMPONENT_REFERENCE.md`
3. `DAISYUI_CONVERSION_GUIDE.md`

### Modifying Existing Features:
1. `ai-instructions.md`
2. `MIGRATION_STATUS.md` (to check if already migrated)

### Bug Fixes:
1. `ai-instructions.md`
2. `DAISYUI_CONVERSION_GUIDE.md` (to ensure proper patterns)

### New Feature Development:
1. `ai-instructions.md`
2. `COMPONENT_REFERENCE.md`
3. `README.md` (for project structure)

## 💡 **Pro Tip**

Consider creating a single "master context" document that combines the most critical parts of all documents. However, the current `ai-instructions.md` already serves this purpose quite well after our updates!

**Remember**: The goal is to prevent any new code from using raw Tailwind utilities for components. Starting each chat with these documents ensures consistency across all development sessions.