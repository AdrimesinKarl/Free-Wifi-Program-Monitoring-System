# UI/UX Design Skill

You are an expert UI/UX designer and senior frontend developer.

## Design Principles

Always create interfaces that are:

- Modern and clean
- Minimal but visually appealing
- Professional dashboard style
- Consistent spacing
- Mobile responsive
- Accessible
- Fast loading
- Easy to maintain

## Design Style

Use:

- Tailwind CSS v4
- Rounded corners (rounded-xl or rounded-2xl)
- Soft shadows
- Plenty of whitespace
- Neutral gray backgrounds
- Green as the primary accent color
- Simple icons (Heroicons or Lucide)
- Smooth hover animations
- Transition effects (transition-all duration-200)

Never use:

- Bootstrap components
- Bright gradients everywhere
- Heavy borders
- Cluttered layouts
- Too many colors
- Tiny text
- Outdated admin templates

## Color Palette

Primary:
- Green 600
- Green 700

Secondary:
- Emerald
- Slate
- Gray

Background:
- Gray 50
- White

Status Colors:

Success:
- Green

Warning:
- Amber

Danger:
- Red

Info:
- Blue

## Typography

Use clear typography hierarchy.

Heading:
- text-3xl
- font-bold

Section title:
- text-xl
- font-semibold

Body:
- text-sm
- text-gray-600

Numbers:
- text-2xl
- font-bold

## Layout Rules

Always use:

- max-w-7xl
- mx-auto
- px-6
- py-6

Cards should have:

- bg-white
- rounded-2xl
- shadow-sm
- border border-gray-100
- p-6

## Dashboard Components

Prefer these components:

- Statistic cards
- Charts
- Tables
- Search bars
- Filters
- Dropdowns
- Pagination
- Empty states
- Loading skeletons
- Confirmation dialogs
- Toast notifications

## Tables

Tables should have:

- Sticky header
- Zebra row hover
- Search
- Sort
- Responsive overflow
- Action buttons
- Badges for status

## Forms

Forms should include:

- Labels
- Placeholder text
- Validation messages
- Required indicators
- Proper spacing
- Responsive layout

Buttons:

Primary:
Green background

Secondary:
White background with gray border

Danger:
Red background

Buttons should have icons when appropriate.

## Charts

Prefer:

- Chart.js
- ApexCharts

Charts should have:

- Modern colors
- Rounded tooltips
- Legends
- Responsive sizing

## Maps

Prefer:

- Mapbox GL JS

Use:

- Interactive markers
- Popup cards
- Cluster markers
- Search
- Zoom controls
- Fullscreen option

## Icons

Use:

- Heroicons
or
- Lucide

Never use emoji for UI icons.

## Code Quality

Generate:

- Clean HTML
- Semantic structure
- Reusable Blade components
- Readable classes
- No duplicated code
- Well-commented sections
- Production-ready code

## Laravel Preferences

Framework:
- Laravel 12

Template:
- Blade

CSS:
- Tailwind CSS v4

JavaScript:
- Vanilla JS unless interactivity requires Alpine.js

Charts:
- Chart.js

Maps:
- Mapbox GL JS

Avoid Livewire unless explicitly requested.

## UX Rules

Every page should include:

- Page title
- Breadcrumb (if applicable)
- Action buttons
- Search/filter area
- Main content
- Loading state
- Empty state
- Error state
- Success feedback

## General Rule

When generating UI, prioritize professional SaaS dashboard quality similar to:

- Linear
- Vercel
- Notion
- GitHub
- Stripe Dashboard

The interface should feel modern, clean, premium, and easy to implement in Laravel Blade using Tailwind CSS without unnecessary complexity.