# TODO: Implement Claim Status Tracking on Dashboard

## Plan
- [x] 1. Update NasabahDashboardController.php to fetch latest claim
- [x] 2. Update dashboard.blade.php to display dynamic claim data
- [x] 3. Verify the implementation

## Notes
- Fetch latest claim for authenticated user
- Display claim status dynamically
- Link "Lacak Klaim" button to claims list page

## Implementation Summary

### Controller Changes (NasabahDashboardController.php):
- Added `Claim` model import
- Added query to fetch latest claim with policy and product relationship
- Passed `$latestClaim` variable to the view

### View Changes (dashboard.blade.php):
- Replaced hardcoded claim status with dynamic data from `$latestClaim`
- Added status color coding:
  - `pending`: Amber background (Menunggu)
  - `review`: Blue background (Dalam Review)
  - `approved`: Emerald background (Disetujui)
  - `rejected`: Red background (Ditolak)
  - `paid`: Emerald background (Dibayar)
- Added progress bar that changes based on status
- Displays: Claim number, Product name, Incident date, Amount claimed
- "Lacak Klaim" button links to `route('nasabah.claims')`
- Added empty state when user has no claims with link to create claim page

