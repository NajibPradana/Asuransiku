# Quick Reference - Role & Permissions

## 🚀 Quick Commands

### Check All Roles
```bash
docker compose exec app php artisan role:show
```

### Check Specific Role
```bash
docker compose exec app php artisan role:show manager
docker compose exec app php artisan role:show admin
docker compose exec app php artisan role:show super_admin
```

### Regenerate Permissions
```bash
# Step 1: Generate all permissions
docker compose exec app php artisan shield:generate --all

# Step 2: Clear cache
docker compose exec app php artisan permission:cache-reset

# Step 3: Run seeder
docker compose exec app php artisan db:seed --class=RolesAndPermissionsSeeder
```

### Fresh Start
```bash
docker compose exec app php artisan migrate:fresh --seed
```

---

## 👥 Test Users

| Role | Email | Password | Can Do |
|------|-------|----------|--------|
| Super Admin | superadmin@local.com | 12341234 | Everything |
| Admin | admin@local.com | 12341234 | Manage insurance, users, content |
| Manager | manager@local.com | 12341234 | Manage products, view policies/claims |
| Nasabah | nasabah@local.com | 12341234 | Frontend only (blocked from admin) |

---

## 📋 Manager Permissions Summary

### ✅ Can Do:
- **Products**: Create, Read, Update, Delete (Full CRUD)
- **Policies**: Read Only (view list, view detail)
- **Claims**: Read Only (view list, view detail)
- **Dashboard**: Access (no special permission needed)

### ❌ Cannot Do:
- Create/Edit/Delete Policies (filled by Nasabah)
- Create/Edit/Delete Claims (submitted by Nasabah)
- Manage Users
- Manage Roles/Permissions
- Access Settings
- Manage Content (Blog, Banner)
- View Logs

---

## 🔧 Troubleshooting

### "Manager can't see resources"
```bash
# 1. Clear cache
docker compose exec app php artisan permission:cache-reset
docker compose exec app php artisan cache:clear

# 2. Reseed permissions
docker compose exec app php artisan db:seed --class=RolesAndPermissionsSeeder

# 3. Logout and login again
```

### "Permission not found"
```bash
# Regenerate all permissions
docker compose exec app php artisan shield:generate --all
docker compose exec app php artisan permission:cache-reset
docker compose exec app php artisan db:seed --class=RolesAndPermissionsSeeder
```

### "Check if permissions exist in database"
```bash
docker compose exec app php artisan tinker --execute="
\$perms = Spatie\Permission\Models\Permission::where('name', 'like', '%product%')
    ->orWhere('name', 'like', '%policy%')
    ->orWhere('name', 'like', '%claim%')
    ->pluck('name')
    ->sort();
foreach (\$perms as \$p) echo '✓ ' . \$p . PHP_EOL;
"
```

---

## 📁 Important Files

| File | Description |
|------|-------------|
| `database/seeders/RolesAndPermissionsSeeder.php` | Main permission seeder |
| `database/seeders/SuperadminSeeder.php` | Super admin user |
| `database/seeders/UsersTableSeeder.php` | Test users |
| `app/Console/Commands/ShowRolePermissions.php` | Role checker command |
| `app/Providers/AuthServiceProvider.php` | Gate setup for super_admin |
| `config/filament-shield.php` | FilamentShield config |

---

## 🎯 Manager Use Cases

### ✅ Scenario 1: Create New Insurance Product
Manager can:
1. Navigate to "Produk Asuransi"
2. Click "Create"
3. Fill in product details
4. Save

### ✅ Scenario 2: Review Customer Policy
Manager can:
1. Navigate to "Polis"
2. View list of all policies
3. Click on a policy to view details
4. **Cannot** edit or delete (read-only)

### ✅ Scenario 3: Monitor Claims
Manager can:
1. Navigate to "Klaim"
2. View all submitted claims
3. View claim details
4. **Cannot** edit or delete claims (read-only)

### ❌ Scenario 4: Add New User (NOT ALLOWED)
Manager:
- Cannot access user management
- Navigation item won't appear
- Direct URL access will be denied

---

## 🔐 Security Notes

1. **Super Admin Bypass**: Super admin bypasses ALL permission checks via `Gate::before()`
2. **Nasabah Block**: Nasabah is blocked at middleware level from admin panel
3. **Permission Cache**: Always clear cache after permission changes
4. **Session**: Active role is stored in session
5. **Auto Navigation**: FilamentShield automatically shows/hides navigation based on `view_any_{resource}` permission

---

## 💡 Development Tips

### Adding New Resource with Manager Access

1. Create the resource
2. Generate permissions:
   ```bash
   php artisan shield:generate --all
   ```
3. Update `RolesAndPermissionsSeeder.php`:
   ```php
   // In setupManagerPermissions()
   $newResourcePermissions = [
       'view_new_resource',
       'view_any_new_resource',
       // ... add based on needs
   ];
   ```
4. Reseed:
   ```bash
   php artisan permission:cache-reset
   php artisan db:seed --class=RolesAndPermissionsSeeder
   ```

### Removing Access

1. Update seeder to remove permissions
2. Reseed
3. Clear cache

---

## ✅ Verification Checklist

After setup, verify:

- [ ] Run `php artisan role:show` - Shows all 4 roles
- [ ] Run `php artisan role:show manager` - Shows 14 permissions
- [ ] Login as manager@local.com
- [ ] Can see: Dashboard, Produk Asuransi, Polis, Klaim
- [ ] Cannot see: Users, Roles, Settings, etc.
- [ ] Can create products
- [ ] Can only view policies (no create/edit/delete buttons)
- [ ] Can only view claims (no create/edit/delete buttons)
- [ ] Nasabah cannot access admin panel at all

---

For detailed documentation, see: `database/seeders/README.md`
