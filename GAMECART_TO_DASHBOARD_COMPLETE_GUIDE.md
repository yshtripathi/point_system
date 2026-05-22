# Game Cart to Dashboard - Complete Flow Guide

## 📋 Overview

This document explains the complete journey of how items flow from the **Game Cart** page to the **User Dashboard** after purchase. It covers the implementation of both systems and how they work together.

---

## 🛒 Part 1: Game Cart Implementation

### File Location
```
resources/views/frontend/pages/gamecart.blade.php
```

### Page Structure

```
┌─────────────────────────────────────────────────────────────┐
│                      GAME CART PAGE                         │
├─────────────────────────────────────────────────────────────┤
│  ▲ Hero Section                                             │
│  ├─ Video background with breadcrumb                        │
│  └─ Page title "Cart"                                       │
│                                                             │
│  ▼ Cart Content Section                                     │
│  ├─ Credits Banner (User's available points)                │
│  └─ Main Grid                                               │
│     ├─ LEFT: Cart Items Display                             │
│     │   └─ Product Cards (grid layout)                      │
│     └─ RIGHT: Cart Summary (sticky sidebar)                 │
│        └─ Total Points & Action Buttons                     │
└─────────────────────────────────────────────────────────────┘
```

### 1.1 Authentication Check

**Line 33-41:** Only shows content to authenticated users

```blade
@auth
@php
    $points = DB::table('users')->where('id', auth()->user()->id)->pluck('points')->first();
@endphp
<div class="kv-credits-banner">
    <i class="fal fa-coins"></i>
    <span>{{ __('common.available_credits') }}: <strong class="kv-credits-value">{{ $points }}</strong></span>
</div>
@endauth
```

**What it does:**
- Fetches current user's points from database
- Displays available credits in banner
- Shows coin icon with formatted points count

---

### 1.2 Cart Items Display

**Line 45-120:** Shows all items in user's shopping cart

#### Data Source
```blade
@foreach(Helper::getAllProductFromCart()->where('order_id', null) as $key => $cart)
```

**Key Filter:** `where('order_id', null)` - Only shows unpurchased items
- Items with `order_id = NULL` = Not yet purchased
- Items with `order_id = <value>` = Already purchased (won't show in cart)

#### Product Card Components

**Line 64-104:** Each item displays as a card with:

```
┌──────────────────────────────────────┐
│  Product Image                    [X] │  ← Delete button
├──────────────────────────────────────┤
│  Product Title (clickable)            │
│                                       │
│  Training Hours: 10.5 hrs             │  ← If hours > 0
│  Calculation: 10.5 × 20 = 210 pts     │
│                                       │
│  Total Points: 500 pts                │
└──────────────────────────────────────┘
```

#### Training Cost Calculation

**Line 56-62:**
```php
$hours = $cart->hours;
$perhour = 20;
$training_cost = 0;

if($hours > 0) {
    $training_cost = $hours * $perhour;
}
```

**Formula:** `Hours × 20 = Training Cost in Points`
- 10 hours = 200 points
- 5.5 hours = 110 points
- 0 hours = 0 points (no training cost)

#### Total Points Calculation

**Line 101:**
```blade
<span class="kv-points-value">{{ number_format($cart['price'], 0) }}</span>
```

**Total Points = Base Product Price + Training Cost**
- Stored in `$cart['price']`
- Formatted with no decimals

---

### 1.3 Cart Summary Section

**Line 123-150:** Sticky sidebar with purchase summary

```
┌───────────────────────────┐
│  ORDER SUMMARY            │
├───────────────────────────┤
│  ⊕ Total: 1,250 pts       │
├───────────────────────────┤
│  [Purchase Services]      │
│  [Continue Shopping]      │
└───────────────────────────┘
```

#### Total Calculation

**Line 135:**
```blade
{{ number_format(Helper::totalCartPrice(), 0) }} {{ __('common.points') }}
```

**Sums all items:** `totalCartPrice()` = Sum of all product prices in cart

#### Action Buttons

**Line 139:** Purchase Button
```blade
<a href="{{ route('buygame') }}" class="kv-btn kv-btn-accent kv-btn-lg w-100">
    {{ __('common.purchase_services') }}
</a>
```
- Routes to: `route('buygame')` → Checkout page
- Initiates purchase process

**Line 143:** Continue Shopping Button
```blade
<a href="{{ route('home') }}" class="kv-btn kv-btn-outline kv-btn-lg w-100">
    {{ __('common.continue_shopping') }}
</a>
```
- Routes back to home
- Continue shopping without purchasing

---

### 1.4 Empty Cart State

**Line 108-119:** When no items in cart

```blade
@if(Helper::cartCount())
    <!-- Show cart items -->
@else
    <!-- Show empty state -->
    <div class="kv-cart-empty">
        <i class="fal fa-shopping-cart"></i>
        <h3>Cart is empty</h3>
        <a href="{{ route('home') }}">Continue Shopping</a>
    </div>
@endif
```

---

### 1.5 Styling & Layout

**Cart Grid Layout:**
```css
.kv-cart-grid {
    display: grid;
    grid-template-columns: 1fr 350px;  /* Items + Summary */
    gap: 40px;
}
```

**Product Cards Grid:**
```css
.kv-cart-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}
```

**Color Scheme:**
- Primary Green: `#6B8E23`
- Gold Accent: `#FFB700`
- Dark Background: `#0F1410`, `#1A2415`

---

## 🔄 Part 2: Purchase Flow (Cart → Checkout → Order)

### Complete Flow Diagram

```
USER IN CART PAGE
    ↓
[Sees available points & products]
    ↓
Clicks "Purchase Services" Button
    ↓
Navigates to: route('buygame') ← Checkout Page
    ↓
┌─────────────────────────────────┐
│    CHECKOUT / PAYMENT PAGE      │
├─────────────────────────────────┤
│ • Displays cart items again     │
│ • Payment processing            │
│ • Points deduction              │
│ • Order creation                │
│ • Cart items marked with order  │
└─────────────────────────────────┘
    ↓
Payment Processed Successfully
    ↓
DATABASE UPDATES:
├─ users.points = points - total_amount
├─ orders table: INSERT new order
│  └─ order_number, user_id, total_amount, status, etc.
└─ cart_items: UPDATE order_id = new_order_id
    ↓
User Redirected to DASHBOARD
    ↓
ORDER NOW VISIBLE IN DASHBOARD
```

---

### Transaction Details

#### 1. Points Deduction
```sql
UPDATE users 
SET points = points - [total_cart_price]
WHERE id = [auth()->id()];
```

**Example:**
- User has: 500 points
- Purchases: 350 points worth
- Result: 150 points remaining

#### 2. Order Creation
```sql
INSERT INTO orders (
    order_number,      -- ORD-12345 (unique)
    user_id,           -- Current user ID
    first_name,        -- User's first name
    last_name,         -- User's last name
    email,             -- User's email
    quantity,          -- Number of items
    currency,          -- USD, JPY, HKD, etc.
    total_amount,      -- Total points spent
    status,            -- 'Completed', 'Pending', 'Failed'
    payment_status,    -- 'Paid', 'Unpaid'
    trans_id,          -- Payment transaction ID
    created_at,        -- Order timestamp
    updated_at
)
VALUES (...);
```

#### 3. Cart Items Updated
```sql
UPDATE cart_items 
SET order_id = [new_order_id]
WHERE id IN ([cart_item_ids]);
```

**Before Purchase:**
```
cart_items table:
├─ id: 100, product_id: 5, order_id: NULL    ← Unpurchased
├─ id: 101, product_id: 3, order_id: NULL    ← Unpurchased
└─ id: 102, product_id: 8, order_id: NULL    ← Unpurchased
```

**After Purchase:**
```
cart_items table:
├─ id: 100, product_id: 5, order_id: 42      ← Now linked to order
├─ id: 101, product_id: 3, order_id: 42      ← Now linked to order
└─ id: 102, product_id: 8, order_id: 42      ← Now linked to order
```

---

## 📊 Part 3: Dashboard Implementation

### File Location
```
resources/views/frontend/user/dashboard.blade.php
```

### Dashboard Structure

```
┌────────────────────────────────────────────────────┐
│           USER DASHBOARD                           │
├────────────────────────────────────────────────────┤
│  ▲ Hero Section                                    │
│  └─ Page title: "Welcome, [Name]"                  │
│                                                    │
│  ▼ Stats Cards (4 columns)                         │
│  ├─ Available Points      │ Total Orders          │
│  ├─ Completed Orders      │ Member Since          │
│  └─────────────────────────────────────────────── │
│                                                    │
│  ▼ Main Dashboard Grid (2-column)                  │
│  ├─ LEFT: Sidebar Navigation                       │
│  │  ├─ User Profile Card                           │
│  │  ├─ Points Purchased ← Tab link                 │
│  │  ├─ Points Redeemed ← Tab link                  │
│  │  └─ Logout                                      │
│  │                                                 │
│  └─ RIGHT: Tab Content Area                        │
│     ├─ Points Purchased Tab (Active)               │
│     │  └─ Orders Table (wallet top-ups)            │
│     └─ Points Redeemed Tab                         │
│        └─ Orders Table (product purchases)         │
└────────────────────────────────────────────────────┘
```

---

### 3.1 Stats Cards

**Line 30-70:** Display 4 key metrics

```blade
<div class="kv-dashboard-stats">
    <div class="kv-stat-card">
        <i class="fal fa-coins"></i>
        <span>Available Points</span>
        <span>{{ DB::table('users')->where('id', auth()->id())->value('points') ?? 0 }}</span>
    </div>
    
    <div class="kv-stat-card">
        <i class="fal fa-shopping-bag"></i>
        <span>Total Orders</span>
        <span>{{ count($orders) }}</span>
    </div>
    
    <div class="kv-stat-card">
        <i class="fal fa-check-circle"></i>
        <span>Completed Orders</span>
        <span>{{ count($orders->where('status', 'Completed')) }}</span>
    </div>
    
    <div class="kv-stat-card">
        <i class="fal fa-user"></i>
        <span>Member Since</span>
        <span>{{ auth()->user()->created_at->format('M Y') }}</span>
    </div>
</div>
```

---

### 3.2 Sidebar Navigation

**Line 74-106:** User profile and navigation

```blade
<aside class="kv-dashboard-sidebar">
    <div class="kv-sidebar-header">
        <div class="kv-sidebar-avatar">
            <i class="fal fa-user"></i>
        </div>
        <h4>{{ auth()->user()->name }}</h4>
        <p>{{ auth()->user()->email }}</p>
    </div>

    <nav class="kv-sidebar-nav">
        <!-- Tab Navigation Links -->
        <a href="#points-purchased" class="kv-sidebar-link active" data-tab="points-purchased">
            <i class="fal fa-credit-card"></i>
            <span>{{ __('common.points_purchased_nav') }}</span>
        </a>
        
        <a href="#points-redeemed" class="kv-sidebar-link" data-tab="points-redeemed">
            <i class="fal fa-shopping-bag"></i>
            <span>{{ __('common.points_redeemed_nav') }}</span>
        </a>
        
        <a href="{{ route('user.logout') }}" class="kv-sidebar-link kv-sidebar-logout">
            <i class="fal fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </nav>
</aside>
```

---

### 3.3 Points Purchased Tab (Wallet Top-ups)

**Line 171-241:** Shows orders where product_id = 1000

#### Filter Logic

```php
@php
    $pointsPurchased = $orders->filter(function($order) {
        $cartItem = $order->cart_info->first();
        return $cartItem && $cartItem->product_id == 1000;
    });
@endphp
```

**What it does:**
- Gets all user's orders
- Filters for cart items with `product_id == 1000`
- Product ID 1000 = Points/Wallet top-up
- Shows only wallet purchases

#### Table Columns

| Column | Content | Example |
|--------|---------|---------|
| **Order Number** | Unique order ID | ORD-12345 |
| **Points Bought** | Quantity purchased | 500 pts |
| **Price Paid** | Amount paid | USD $29.99 |
| **Payment Status** | Status badge | Paid / Unpaid |
| **Date** | Purchase date | 15 May 2026 |
| **Action** | View details | [View] |

#### Empty State

```blade
@if($pointsPurchased->count() > 0)
    <!-- Show table -->
@else
    <div class="kv-dashboard-empty">
        <h4>{{ __('common.no_past_orders_found') }}</h4>
    </div>
@endif
```

---

### 3.4 Points Redeemed Tab (Product Purchases)

**Line 244-313:** Shows orders where product_id < 1000

#### Filter Logic

```php
@php
    $pointsRedeemed = $orders->filter(function($order) {
        $cartItem = $order->cart_info->first();
        return $cartItem && $cartItem->product_id < 1000;
    });
@endphp
```

**What it does:**
- Gets all user's orders
- Filters for cart items with `product_id < 1000`
- Any ID below 1000 = Product purchase (game services, boosts, etc.)
- Shows only product purchases

#### Table Columns

| Column | Content | Example |
|--------|---------|---------|
| **Order Number** | Unique order ID | ORD-12344 |
| **Customer** | User name | John Doe |
| **Points Used** | Quantity redeemed | 350 pts |
| **Status** | Order status | Completed / Pending |
| **Date** | Purchase date | 14 May 2026 |
| **Action** | View details | [View] |

---

### 3.5 Tab Switching (Vanilla JavaScript)

**Line 1024-1055:** JavaScript for switching between tabs

```javascript
document.addEventListener('DOMContentLoaded', function() {
    const tabLinks = document.querySelectorAll('.kv-sidebar-link[data-tab]');

    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const tabId = this.getAttribute('data-tab');
            
            // Remove active class from all links
            tabLinks.forEach(l => l.classList.remove('active'));
            
            // Add active class to clicked link
            this.classList.add('active');
            
            // Hide all tabs
            document.querySelectorAll('.kv-dashboard-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Show target tab
            const targetTab = document.getElementById(tabId);
            if(targetTab) {
                targetTab.classList.add('active');
            }
        });
    });
});
```

**How it works:**
1. User clicks a sidebar link (e.g., "Points Redeemed")
2. Script gets the `data-tab` attribute (e.g., "points-redeemed")
3. Removes `active` class from all links and tabs
4. Adds `active` class to clicked link and target tab
5. CSS shows/hides tabs based on `active` class

**CSS:**
```css
.kv-dashboard-tab {
    display: none !important;
}

.kv-dashboard-tab.active {
    display: block !important;
}
```

---

## 🔗 Part 4: Data Flow Integration

### Complete Data Journey

```
CART PAGE ($cart variable)
├─ cart_items.id
├─ cart_items.product_id
├─ cart_items.hours
├─ cart_items.price
├─ cart_items.order_id = NULL (not yet purchased)
└─ product.title, product.photo, product.slug

    ↓ User clicks "Purchase Services"
    ↓ Navigates to checkout (route('buygame'))
    ↓ Payment processed

AFTER PURCHASE:
├─ users.points -= total_amount
│
├─ orders table (NEW RECORD)
│  ├─ order_number = 'ORD-12345'
│  ├─ user_id = auth()->id()
│  ├─ first_name
│  ├─ last_name
│  ├─ email
│  ├─ quantity
│  ├─ currency
│  ├─ total_amount (points spent)
│  ├─ status = 'Completed'
│  ├─ payment_status = 'Paid'
│  ├─ trans_id
│  ├─ created_at = NOW()
│  └─ cart_info (relationship to cart_items)
│
└─ cart_items (UPDATED)
   ├─ order_id = new_order_id (no longer NULL)
   ├─ product_id (unchanged)
   └─ Now linked to order

    ↓ User redirected to dashboard

DASHBOARD PAGE ($orders variable)
├─ Queries: Order::where('user_id', auth()->id())->get()
│
├─ Points Purchased Tab
│  └─ Filter: $order->cart_info->product_id == 1000
│     └─ Shows wallet top-up purchases
│
└─ Points Redeemed Tab
   └─ Filter: $order->cart_info->product_id < 1000
      └─ Shows product purchases
```

---

## 🎨 Part 5: Styling & Design

### Color Scheme (Both Cart & Dashboard)

| Color | Value | Usage |
|-------|-------|-------|
| **Primary Green** | `#6B8E23` | Borders, accents |
| **Gold** | `#FFB700` | Active states, highlights |
| **Success Green** | `#4cde80` | Status badges |
| **Error Red** | `#ff4757` | Negative states |
| **Dark BG 1** | `#0F1410` | Main background |
| **Dark BG 2** | `#1A2415` | Secondary background |

### Responsive Breakpoints

```css
/* Desktop (>1024px) */
.kv-cart-grid { grid-template-columns: 1fr 350px; }
.kv-dashboard-grid { grid-template-columns: 280px 1fr; }

/* Tablet (768px - 1024px) */
@media (max-width: 1024px) {
    .kv-cart-grid,
    .kv-dashboard-grid { grid-template-columns: 1fr; }
}

/* Mobile (<768px) */
@media (max-width: 768px) {
    .kv-sidebar-card { display: none; }
    .kv-dashboard-main { width: 100%; }
    .kv-dashboard-stats { grid-template-columns: repeat(2, 1fr); }
}
```

---

## 🔐 Part 6: Security & Access Control

### Authentication Requirements

**Game Cart:**
```blade
@auth
    <!-- Show cart -->
@else
    <!-- Redirect to login -->
@endauth
```

**Dashboard:**
```blade
@extends('frontend.layouts.main')
@auth
    <!-- Dashboard content -->
@endauth
```

### Data Isolation

```php
// Fetch only current user's orders
$orders = Order::where('user_id', auth()->id())->get();
```

- Users can only see their own orders
- Database query filters by `user_id`
- Cannot access other users' data

---

## 📊 Part 7: Key Database Tables

### orders Table
```sql
CREATE TABLE orders (
    id BIGINT PRIMARY KEY,
    order_number VARCHAR(50) UNIQUE,
    user_id BIGINT FOREIGN KEY,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    email VARCHAR(255),
    quantity INT,
    currency VARCHAR(10),
    total_amount DECIMAL(10,2),
    status VARCHAR(50),              -- 'Completed', 'Pending', 'Failed'
    payment_status VARCHAR(50),      -- 'Paid', 'Unpaid'
    trans_id VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### cart_items Table
```sql
CREATE TABLE cart_items (
    id BIGINT PRIMARY KEY,
    user_id BIGINT FOREIGN KEY,
    product_id INT,
    hours DECIMAL(5,2),
    price DECIMAL(10,2),
    order_id BIGINT NULLABLE,        -- NULL = unpurchased, Value = purchased
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### users Table
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    points INT,                      -- User's current points balance
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## 🧪 Part 8: Testing the Complete Flow

### Test Scenario: Purchasing Points

```
1. LOGIN
   └─ User logs in with credentials

2. NAVIGATE TO CART
   └─ Route: /gamecart
   └─ Should see available points: 500 pts

3. ADD ITEMS TO CART
   └─ (Assume already added via other pages)
   └─ Cart shows: 3 items, Total: 350 pts

4. CLICK PURCHASE SERVICES
   └─ Route: /buygame (checkout page)
   └─ Should show cart summary again

5. COMPLETE PAYMENT
   └─ Payment gateway processes
   └─ Points deducted: 500 → 150 pts
   └─ Order created in database

6. REDIRECT TO DASHBOARD
   └─ Route: /user/dashboard
   └─ Available Points card shows: 150 pts
   └─ Total Orders updated
   └─ New order appears in appropriate tab

7. VERIFY IN DASHBOARD
   ✓ Points Purchased Tab: Shows new wallet top-up order
   ✓ Order Number: ORD-xxxxx (formatted)
   ✓ Points Bought: Shows quantity purchased
   ✓ Price Paid: Shows amount paid
   ✓ Payment Status: Shows "Paid"
   ✓ Date: Shows current date
   ✓ Action: "View" button works
```

---

## 🔄 Part 9: Points Calculation Examples

### Example 1: Game Boost Order

```
Cart Items:
├─ Rank Boost Service (product_id: 5)
│  ├─ Base Price: 250 pts
│  └─ No training hours
├─ Coaching (product_id: 8)
│  ├─ Base Price: 100 pts
│  ├─ Training Hours: 5
│  └─ Training Cost: 5 × 20 = 100 pts
│  └─ Total: 100 + 100 = 200 pts

CART TOTAL: 250 + 200 = 450 pts
User has: 500 pts
After purchase: 500 - 450 = 50 pts

Dashboard:
├─ Points Redeemed Tab
│  └─ Shows both items
│  └─ Total Amount: 450 pts
│  └─ Status: Completed
```

### Example 2: Wallet Top-up Order

```
Cart Items:
├─ Points Package (product_id: 1000)
│  └─ Package: 1000 points for $29.99
│  └─ No training hours

CART TOTAL: 1000 pts
User has: 50 pts
Points purchased: 1000 pts
After purchase: 50 + 1000 = 1050 pts

Dashboard:
├─ Points Purchased Tab
│  └─ Points Bought: 1000 pts
│  └─ Price Paid: USD $29.99
│  └─ Payment Status: Paid
│  └─ Status: Completed
```

---

## 📝 Part 10: Translation Keys Used

### Dashboard Translation Keys

| Key | English | Japanese |
|-----|---------|----------|
| `common.dashboard` | Dashboard | ダッシュボード |
| `common.welcome` | Welcome | ようこそ |
| `common.available_credits` | Available Points | 利用可能なポイント |
| `common.total_orders` | Total Orders | 合計注文数 |
| `common.completed` | Completed | 完了 |
| `common.member_since` | Member Since | メンバー登録日 |
| `common.order_number` | Order Number | 注文番号 |
| `common.customer` | Customer | 顧客 |
| `common.status` | Status | ステータス |
| `common.date` | Date | 日付 |
| `common.action` | Action | アクション |
| `common.payment_status` | Payment Status | 支払いステータス |
| `common.points_purchased_nav` | Points Purchased | ポイント購入 |
| `common.points_redeemed_nav` | Points Redeemed | ポイント引き換え |
| `common.points_purchased_title` | Points Purchased (Wallet Top-Up) | ポイント購入（ウォレットトップアップ） |
| `common.points_redeemed_title` | Points Redeemed (Product Purchases) | ポイント引き換え（商品購入） |
| `common.points_bought` | Points Bought | 購入ポイント |
| `common.price_paid` | Price Paid | 支払い金額 |
| `common.points_used` | Points Used | 使用ポイント |
| `common.no_past_orders_found` | No past orders found. | 過去の注文が見つかりませんでした。 |

---

## 🎯 Summary Flow Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                    COMPLETE USER JOURNEY                        │
└─────────────────────────────────────────────────────────────────┘

USER STARTS HERE
        ↓
    [HOME PAGE]
        ↓
  Browse Products
        ↓
  Add to Cart (stores in cart_items table)
        ↓
[GAME CART PAGE] ← resources/views/frontend/pages/gamecart.blade.php
├─ Shows all cart items (WHERE order_id = NULL)
├─ Displays available points (from users table)
├─ Calculates total points needed
└─ Shows Purchase button (route: 'buygame')
        ↓
  User clicks "Purchase Services"
        ↓
[CHECKOUT PAGE]
├─ Payment processing
├─ Points deduction: users.points -= total_amount
├─ Order creation: INSERT into orders table
├─ Cart items update: SET cart_items.order_id = new_order
└─ User redirected to dashboard
        ↓
[USER DASHBOARD] ← resources/views/frontend/user/dashboard.blade.php
├─ Stats Cards Updated
│  ├─ Available Points: shows new balance
│  ├─ Total Orders: incremented by 1
│  └─ Completed Orders: incremented if status = 'Completed'
│
└─ Two Tabs with order data:
   ├─ POINTS PURCHASED TAB
   │  ├─ Filter: WHERE product_id = 1000
   │  ├─ Shows: Wallet top-ups
   │  └─ Example: 500 pts for $29.99
   │
   └─ POINTS REDEEMED TAB
      ├─ Filter: WHERE product_id < 1000
      ├─ Shows: Product purchases
      └─ Example: Game boosts, coaching, training

        ↓
  User can click "View" to see full order details
        ↓
[ORDER DETAIL PAGE]
├─ Complete order information
├─ Payment details
├─ Transaction ID
└─ Download PDF invoice

        ↓
  User continues using service or purchases again
```

---

## 🚀 Quick Reference

### Files Involved
- **Cart:** `resources/views/frontend/pages/gamecart.blade.php`
- **Dashboard:** `resources/views/frontend/user/dashboard.blade.php`
- **Checkout:** Handled by `route('buygame')` controller
- **Translations:** `resources/lang/en/common.php`, `resources/lang/ja/common.php`

### Key Routes
- `route('gamecart')` → Cart page
- `route('buygame')` → Checkout page
- `route('user.dashboard')` → Dashboard
- `route('user.order.show', $order->id)` → Order details

### Key Helpers
- `Helper::cartCount()` → Check if cart has items
- `Helper::getAllProductFromCart()` → Get all cart items
- `Helper::totalCartPrice()` → Calculate total points
- `Helper::getProductPriceByCurrency()` → Get price by currency

### Key Database Queries
- Get user's orders: `Order::where('user_id', auth()->id())->get()`
- Get user's points: `DB::table('users')->where('id', auth()->id())->value('points')`
- Filter cart items: `$orders->filter(fn($o) => $o->cart_info->first()->product_id == 1000)`

---

## ✅ Checklist

After purchase, verify these items:

- [ ] Order appears in dashboard "Points Purchased" or "Points Redeemed" tab
- [ ] Available Points updated in stats card
- [ ] Total Orders count increased by 1
- [ ] Order Number displays correctly (ORD-xxxxx)
- [ ] Payment Status shows correct status
- [ ] Order Date matches current date
- [ ] Tab switching works (click between tabs)
- [ ] "View" button navigates to order details
- [ ] Empty state message displays if no orders in tab
- [ ] Dashboard displays in both English and Japanese (if user switches language)
- [ ] Responsive design works on mobile/tablet
- [ ] User can log out from sidebar

---

## 📞 Support

For issues or questions:
1. Check cart items have `order_id = NULL` (unpurchased)
2. Verify user is authenticated
3. Check order was created in database
4. Verify cart_items were updated with order_id
5. Check user's points were deducted
6. Clear browser cache and reload page

---

**Last Updated:** 2026-05-22
**Status:** Complete Guide ✅
