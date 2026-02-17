# Database Seeders Documentation

## Role & Permission System

### Roles Overview

| Role | Description | Access Level |
|------|-------------|--------------|
| **super_admin** | Super Administrator | Full access to everything (via Gate) |
| **admin** | Administrator | Full access to insurance, users, and content management |
| **manager** | Manager | Limited access - Dashboard, Products (Full CRUD), Policy & Claim (View Only) |
| **nasabah** | Customer | Frontend user - No admin panel access |

---

## Role Permissions Details

### 1. Super Admin (`super_admin`)
- ✅ **Full Access** to all resources (handled by `Gate::before()` in `AuthServiceProvider`)
- ✅ Access to Log Viewer
- ✅ All CRUD operations on all resources
- ✅ System configuration and settings

### 2. Admin (`admin`)
- ✅ **Insurance Module**: Full CRUD
  - Products (view, create, update, delete, restore, force delete)
  - Policies (view, create, update, delete, restore, force delete)
  - Claims (view, create, update, delete, restore, force delete)
- ✅ **User Management**: Full CRUD
  - View, create, update, delete users
- ✅ **Content Management**: Full CRUD
  - Blog posts and categories
  - Banners and content
  - Contact forms
- ✅ Access to Log Viewer
- ❌ No access to Super Admin features (role management, shield)

### 3. Manager (`manager`)
**Limited to insurance operations only:**

#### ✅ Product Management (Full CRUD)
- `view_product` - View single product
- `view_any_product` - View all products
- `create_product` - Create new product
- `update_product` - Edit existing product
- `delete_product` - Delete product
- `delete_any_product` - Bulk delete products
- `restore_product` - Restore soft-deleted product
- `restore_any_product` - Restore multiple products
- `force_delete_product` - Permanently delete product
- `force_delete_any_product` - Permanently delete multiple products

#### 👁️ Policy Management (View Only)
**Why view only?** Policies are filled by Nasabah (customers), Manager can only view for monitoring.
- `view_policy` - View single policy
- `view_any_policy` - View all policies
- ❌ Cannot create, update, or delete policies

#### 👁️ Claim Management (View Only)
**Why view only?** Claims are submitted by Nasabah (customers), Manager can only view for monitoring.
- `view_claim` - View single claim
- `view_any_claim` - View all claims
- ❌ Cannot create, update, or delete claims

#### ❌ No Access To:
- User management
- Role/Permission management
- Settings & Configuration
- Content management (Blog, Banner)
- Log viewer
- System administration features

### 4. Nasabah (`nasabah`)
- Frontend user role
- No admin panel permissions
- Can submit policies and claims through frontend interface
- Blocked from accessing admin panel by `PreventCustomerAccess` middleware

---

## Running Seeders

### Fresh Installation
Run all seeders in order:
```bash
docker compose exec app php artisan migrate:fresh --seed
```

### Individual Seeders

#### 1. Roles & Permissions
```bash
docker compose exec app php artisan db:seed --class=RolesAndPermissionsSeeder
```

#### 2. Super Admin User
```bash
docker compose exec app php artisan db:seed --class=SuperadminSeeder
```

#### 3. Test Users (Admin, Manager, Nasabah)
```bash
docker compose exec app php artisan db:seed --class=UsersTableSeeder
```

#### 4. Products
```bash
docker compose exec app php artisan db:seed --class=ProductsTableSeeder
```

#### 5. Policies
```bash
docker compose exec app php artisan db:seed --class=PoliciesTableSeeder
```

### Clear Permission Cache
After modifying permissions, always clear the cache:
```bash
docker compose exec app php artisan permission:cache-reset
```

---

## Test Credentials

After running seeders, you can login with:

| Role | Email | Password |
|------|-------|----------|
| Super Admin | superadmin@local.com | 12341234 |
| Admin | admin@local.com | 12341234 |
| Manager | manager@local.com | 12341234 |
| Nasabah | nasabah@local.com | 12341234 |

*Default password is defined in `.env` as `DEFAULT_USER_PASSWORD`*

---

## Troubleshooting

### Manager doesn't see resources
1. Clear permission cache: `php artisan permission:cache-reset`
2. Re-run seeder: `php artisan db:seed --class=RolesAndPermissionsSeeder`
3. Logout and login again
4. Check if permissions exist in database:
   ```sql
   SELECT * FROM permissions WHERE name LIKE '%product%' OR name LIKE '%policy%' OR name LIKE '%claim%';
   ```

### Permissions not working
1. Ensure FilamentShield has generated permissions:
   ```bash
   php artisan shield:generate --all
   ```
2. Clear cache:
   ```bash
   php artisan permission:cache-reset
   php artisan cache:clear
   ```
3. Check `AuthServiceProvider` has correct Gate setup for super_admin

### Navigation items not showing
1. Resources use FilamentShield's automatic navigation visibility based on `view_any_{resource}` permission
2. Ensure user has correct active role in session (check Role Switcher)
3. Verify resource implements `HasShieldPermissions` interface

---

## Adding New Permissions

### For New Resources

1. Generate permissions using Filament Shield:
```bash
php artisan shield:generate --all
```

2. Update `RolesAndPermissionsSeeder.php` to include new permissions:
```php
// In setupManagerPermissions() or setupAdminPermissions()
$newResourcePermissions = [
    'view_new_resource',
    'view_any_new_resource',
    // ... other permissions
];
```

3. Re-run seeder:
```bash
php artisan permission:cache-reset
php artisan db:seed --class=RolesAndPermissionsSeeder
```

---

## Custom Permission Guidelines

### Manager Role Philosophy
- **Full Access**: Resources that Manager actively manages (Products)
- **View Only**: Resources filled by customers where Manager monitors (Policies, Claims)
- **No Access**: System administration and user management

### Security Notes
- Super Admin bypasses all permission checks via Gate
- Nasabah role is blocked at middleware level from admin panel
- Always run `permission:cache-reset` after permission changes
- Test with actual role users, not just super admin

---

## Related Files

- `/app/Providers/AuthServiceProvider.php` - Gate setup for Super Admin
- `/app/Http/Middleware/PreventCustomerAccess.php` - Blocks Nasabah from admin
- `/config/filament-shield.php` - FilamentShield configuration
- `/database/seeders/RolesAndPermissionsSeeder.php` - Main permissions seeder
- `/database/seeders/SuperadminSeeder.php` - Super admin user creation
- `/database/seeders/UsersTableSeeder.php` - Test users creation
