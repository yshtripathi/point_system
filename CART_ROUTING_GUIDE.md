# Cart Routing Guide - Course vs Points

## Overview

The system now has **TWO separate cart flows**:

1. **Course Cart** (`/coursecart`) - For enrolling in courses using points
2. **Wallet Cart** (`/cart`) - For purchasing points/topping up wallet

---

## Flow Comparison

### 🎓 Course Enrollment Flow

```
1. User browses courses at /product-lists
   ↓
2. User selects course and level
   ↓
3. Form submits to: singleAddToCart (CartController)
   ↓
4. Item added to cart with product_id < 1000
   ↓
5. Redirects to: route('coursecart') → /coursecart
   ↓
6. User sees course cart page with:
   - Course name
   - Selected level (e.g., "Beginner")
   - Points cost
   - Level badge
   ↓
7. User clicks "Proceed to Checkout" → /checkout
   ↓
8. User selects "Redeem Points" payment option
   ↓
9. Points deducted from wallet
   ↓
10. Redirect to Dashboard → /user/
```

### 💰 Points Top-up Flow

```
1. User clicks "Buy Points" or goes to /points/topup
   ↓
2. User selects points package or enters custom amount
   ↓
3. Form submits to: addToCart (PointsController)
   ↓
4. Item added to cart with product_id = 1000
   ↓
5. Redirects to: route('cart') → /cart
   ↓
6. User sees wallet top-up cart page with:
   - Points package details
   - Price in USD/JPY/HKD
   - Points bonus (multiplier)
   ↓
7. User clicks "Checkout"
   ↓
8. User enters payment details (credit card)
   ↓
9. Payment processed
   ↓
10. Points added to wallet
    ↓
11. Redirect to Dashboard → /user/
```

---

## Routes and Controllers

| Action | Route | Handler | Redirects To |
|--------|-------|---------|--------------|
| Add course to cart | POST `/add-to-cart` | `CartController@singleAddToCart()` | `/coursecart` |
| Add points to cart | POST `/points/add-to-cart` | `PointsController@addToCart()` | `/cart` |
| View course cart | GET `/coursecart` | View `frontend.pages.coursecart` | - |
| View wallet cart | GET `/cart` | View `frontend.pages.cart` | - |
| Checkout (both) | GET `/checkout` | `CartController@checkout()` | View `frontend.pages.checkout` |
| Redeem points | POST `/points/redeem` | `PointsController@redeem()` | `/user/` (Dashboard) |
| Checkout payment | POST `/cart/order` | `OrderController@store()` | Payment gateway |

---

## Cart Item Identifiers

### Product ID Convention

- **product_id < 1000** = Course/Product items
  - Example: product_id = 5, 10, 25, etc.
  - Stored with: course name, level, points cost
  - Checkout: Redeem Points

- **product_id = 1000** = Points/Wallet top-up
  - Fixed ID for wallet purchases
  - Stored with: USD amount, points bonus, payment details
  - Checkout: Credit card payment

---

## Business Rules

### ✅ Cart Mixing Prevention
Users **CANNOT** mix courses and points in the same transaction:

```php
// In PointsController::addToCart()
if (isset($existing_item) && $existing_item < 1000) {
    return back()->with('error', 'You cannot add points to a cart 
    containing courses. Please checkout or clear your cart first.');
}
```

**Reason:** 
- Courses use points → points are deducted from wallet
- Points top-up → points are added to wallet
- These are opposite operations; can't happen in one order

### ✅ Course Cart Rules
- Only items with **product_id < 1000** allowed
- Displays with **level information**
- Redirects to: **`/coursecart`**
- Checkout uses: **Points Redeem** option
- Points deducted from: **`users.points_balance`**

### ✅ Wallet Cart Rules
- Only items with **product_id = 1000** allowed
- No level information (not applicable)
- Redirects to: **`/cart`**
- Checkout uses: **Credit Card** payment
- Points added to: **`users.points_balance`**

---

## Summary Table

| Aspect | Course Cart | Wallet Cart |
|--------|------------|-------------|
| URL | `/coursecart` | `/cart` |
| Product ID | < 1000 | = 1000 |
| Display | Course name + Level + Points | Points package + Price |
| Checkout | Points Redeem | Credit Card |
| Action | Deduct points | Add points |
| Redirect From | `singleAddToCart()` | `addToCart()` |
| Payment Status | Completed immediately | Pending payment gateway |

---

## Key Files

- **Course Cart:** `resources/views/frontend/pages/coursecart.blade.php`
- **Wallet Cart:** `resources/views/frontend/pages/cart.blade.php`
- **Checkout:** `resources/views/frontend/pages/checkout.blade.php`
- **Course Controller:** `app/Http/Controllers/CartController.php`
- **Points Controller:** `app/Http/Controllers/PointsController.php`
- **Dashboard:** `resources/views/frontend/user/dashboard.blade.php`

---

## Testing the Flows

### Test 1: Course Enrollment
```
✅ Go to /product-lists
✅ Select a course and level
✅ Should redirect to /coursecart
✅ Course card shows level badge
✅ Click "Proceed to Checkout"
✅ Select "Redeem Points"
✅ Points deducted
✅ See in Dashboard "Points Redeemed" tab
```

### Test 2: Points Top-up
```
✅ Go to /points/topup
✅ Select points package
✅ Should redirect to /cart
✅ See price and points bonus
✅ Click "Checkout"
✅ Enter payment details
✅ Payment processed
✅ See in Dashboard "Points Purchased" tab
```

### Test 3: Cart Mixing Prevention
```
✅ Add course to cart → /coursecart
✅ Try to add points → Should show error
✅ OR add points to cart → /cart
✅ Try to add course → Should show error
```

---

**Status:** ✅ Two separate cart flows implemented and verified
**Last Updated:** 2026-05-22
