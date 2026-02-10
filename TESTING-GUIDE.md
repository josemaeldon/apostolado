# Testing Guide for New Features

This document describes how to test the 4 implemented features.

## Setup

Test users have been created:
- **Admin**: email: `admin@test.com`, password: `password`
- **Editor**: email: `editor@test.com`, password: `password`

Test token: `ABC12`

## Feature 1: Mobile Menu Fix

### Test Steps:
1. Open the website on a mobile device or resize browser to mobile width (<1024px)
2. Click the hamburger menu icon (☰) in the top right
3. **Expected**: Menu should open and display navigation links
4. Click the icon again
5. **Expected**: Menu should close

### What was fixed:
- Removed duplicate event listeners that were preventing the menu from toggling

## Feature 2: Swipe Functionality for Sliders

### Test Steps for Hero Slider:
1. Open homepage on a touch device or use browser dev tools to simulate touch
2. On the hero slider section, swipe left
3. **Expected**: Slider advances to next slide
4. Swipe right
5. **Expected**: Slider goes to previous slide

### Test Steps for News/Articles Slider:
1. Scroll down to the news/articles section
2. Swipe left on the news cards
3. **Expected**: News slider advances to next set of cards
4. Swipe right
5. **Expected**: News slider goes back to previous cards

### Technical Details:
- Minimum swipe distance: 50 pixels
- Works on both hero slider and news slider
- Touch events: touchstart and touchend

## Feature 3: Token-Based Access for Member Registration

### Test Steps:

#### A. Accessing Registration Without Token:
1. Navigate to `/cadastro-membro`
2. **Expected**: Token entry form is displayed
3. Try to access `/cadastro-membro/formulario` directly
4. **Expected**: Redirected to token form with error message

#### B. Using Invalid Token:
1. Go to `/cadastro-membro`
2. Enter an invalid token (e.g., "XYZ99")
3. Click "Continuar"
4. **Expected**: Error message: "Token inválido, expirado ou sem usos disponíveis"

#### C. Using Valid Token:
1. Go to `/cadastro-membro`
2. Enter the test token: `ABC12`
3. Click "Continuar"
4. **Expected**: Redirected to registration form at `/cadastro-membro/formulario`
5. Complete and submit the form
6. **Expected**: Registration succeeds and token usage count increments

#### D. Managing Tokens (Admin Only):
1. Login as admin (`admin@test.com` / `password`)
2. Navigate to Admin Panel → Cadastros → Tokens de Cadastro
3. **Expected**: See list of tokens including ABC12
4. Click "+ Novo Token"
5. Fill in description, set max uses (optional), expiration date (optional)
6. Click "Criar Token"
7. **Expected**: New token is generated automatically (format: ABC12)
8. Edit a token - change description or max uses
9. **Expected**: Token updated successfully
10. Delete a token
11. **Expected**: Token deleted successfully

### Token Format:
- 3 uppercase letters + 2 numbers (e.g., ABC12, XYZ99)
- Auto-generated on creation
- Cannot be manually changed

### Token Properties:
- **Description**: Optional description for the token
- **Active/Inactive**: Toggle token availability
- **Max Uses**: Optional limit on number of uses (null = unlimited)
- **Used Count**: Tracks how many times the token has been used
- **Expires At**: Optional expiration date/time
- **Validation**: Token is invalid if:
  - Not active
  - Expired
  - Max uses reached

## Feature 4: Role-Based Access Control

### Test Steps:

#### A. Admin Access (Full Access):
1. Login as admin (`admin@test.com` / `password`)
2. Navigate to Admin Panel
3. **Expected**: Can see all menu items including:
   - Dashboard
   - Página Inicial (Seções, Cartões de Recurso)
   - Páginas
   - Artigos
   - Intenções
   - Eventos
   - Galeria
   - Sliders
   - Categorias
   - Cadastros (Membros, Tokens de Cadastro)
   - Configurações section (Site, Armazenamento, API REST)
4. Try accessing any admin resource
5. **Expected**: Full access granted

#### B. Editor Access (Limited Access):
1. Login as editor (`editor@test.com` / `password`)
2. Navigate to Admin Panel
3. **Expected**: Can see only:
   - Dashboard
   - Páginas
   - Artigos
   - Intenções
   - Eventos
   - Galeria
   - Categorias
   - Cadastros (Membros, Tokens de Cadastro)
4. **Expected**: Cannot see:
   - Página Inicial (Seções, Cartões de Recurso) - admin only
   - Sliders - admin only
   - Configurações section - admin only
5. Try accessing an editor-allowed resource (e.g., `/admin/pages`)
6. **Expected**: Access granted
7. Try accessing an admin-only resource (e.g., `/admin/sliders`)
8. **Expected**: 403 Forbidden error

#### C. Regular User Access:
1. Create a regular user with role='user' or use an unverified account
2. Try accessing any admin route (e.g., `/admin/pages`)
3. **Expected**: 403 Forbidden error

### Role Definitions:
- **Admin**: Full access to all features and settings
- **Editor**: Can manage:
  - Pages (Páginas)
  - Articles (Artigos)
  - Prayer Intentions (Intenções)
  - Events (Eventos)
  - Media Gallery (Galeria)
  - Categories (Categorias)
  - Member Registrations (Cadastros de Membros)
  - Registration Tokens (Tokens de Cadastro)
- **User**: No admin panel access (regular website visitor)

### Technical Implementation:
- Middleware: `admin` and `editor` middleware aliases
- Routes: Organized into editor-accessible and admin-only groups
- UI: Admin layout conditionally shows menu items based on `auth()->user()->isAdmin()`
- User Model Methods:
  - `isAdmin()`: Check if user is admin
  - `isEditor()`: Check if user is editor
  - `isAdminOrEditor()`: Check if user has any admin privileges
  - `canAccess($resource)`: Check if user can access specific resource

## Database Changes

### New Tables:
1. **registration_tokens**:
   - `id`, `token`, `description`, `is_active`, `max_uses`, `used_count`, `expires_at`, `created_at`, `updated_at`

### Modified Tables:
1. **users**:
   - Added `role` column (enum: 'admin', 'editor', 'user')
   - Removed `is_admin` column (migrated to `role`)

### Migrations:
- `2026_02_10_113728_create_registration_tokens_table.php`
- `2026_02_10_114140_add_role_to_users_table.php`
- `2026_02_10_114155_migrate_is_admin_to_role.php`

## Security Considerations

### Token System:
- Tokens are validated on both display and submission
- Session storage ensures token persistence during registration
- Token usage is tracked and enforced
- Expired or inactive tokens are rejected

### Role-Based Access:
- Middleware enforces access at route level
- UI conditionally shows/hides features based on role
- Direct URL access to restricted routes returns 403 Forbidden
- Role checks are performed on every request

### Input Validation:
- Token format validated with regex: `[A-Z]{3}\d{2}`
- Expiration dates must be in the future
- Max uses must be positive integer
- All inputs sanitized and validated

## Troubleshooting

### Mobile menu not working:
- Clear browser cache
- Ensure JavaScript is enabled
- Check browser console for errors

### Swipe not working:
- Ensure using a touch device or touch simulation in dev tools
- Check that slider has multiple slides
- Verify minimum swipe distance (50px)

### Token validation failing:
- Check token is active (`is_active = true`)
- Verify token hasn't expired (`expires_at > now()`)
- Check token hasn't reached max uses (`used_count < max_uses`)
- Ensure correct format (3 uppercase letters + 2 numbers)

### Role-based access not working:
- Verify user has correct role in database
- Check middleware is registered in `bootstrap/app.php`
- Ensure routes are properly grouped with middleware
- Clear route and config cache: `php artisan route:clear && php artisan config:clear`
