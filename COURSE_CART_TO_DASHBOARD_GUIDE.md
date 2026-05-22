# Course Cart to Dashboard - Complete Flow Guide

## 📋 Overview

This document explains the complete journey of how course enrollments flow from the **Course Cart** page to the **User Dashboard** after purchase using points. It covers the implementation of both systems and how they work together.

---

## 🛒 Part 1: Course Cart Implementation

### File Location
```
resources/views/frontend/pages/coursecart.blade.php
```

### Page Structure

```
┌─────────────────────────────────────────────────────────────┐
│                    COURSE CART PAGE                         │
├─────────────────────────────────────────────────────────────┤
│  ▲ Hero Section                                             │
│  ├─ Breadcrumb navigation                                   │
│  └─ Page title "Course Cart"                                │
│                                                             │
│  ▼ Cart Content Section                                     │
│  ├─ Points Balance Banner (User's available points)         │
│  └─ Main Grid                                               │
│     ├─ LEFT: Cart Items Display                             │
│     │   └─ Course Cards (grid layout)                       │
│     └─ RIGHT: Cart Summary (sticky sidebar)                 │
│        └─ Total Points & Action Buttons                     │
└─────────────────────────────────────────────────────────────┘
```

### 1.1 Authentication Check

Only shows content to authenticated users

```blade
@auth
@php
    $user = auth()->user();
    $points = $user->points_balance ?? 0;
@endphp
<div class="course-points-banner">
    <i class="fal fa-coins"></i>
    <span>{{ __('common.available_points') }}: <strong class="points-balance">{{ $points }}</strong></span>
</div>
@endauth
```

**What it does:**
- Fetches current user's points from database
- Displays available points in banner
- Shows coin icon with formatted points count

---

### 1.2 Cart Items Display

Shows all items in user's shopping cart

#### Data Source
```blade
@foreach(Helper::getAllProductFromCart()->where('order_id', null) as $key => $cart)
```

**Key Filter:** `where('order_id', null)` - Only shows unpurchased items
- Items with `order_id = NULL` = Not yet purchased (in cart)
- Items with `order_id = <value>` = Already purchased (won't show in cart)

#### Course Card Components

Each item displays as a card with:

```
┌──────────────────────────────────────┐
│  Course Image                     [X]│  ← Delete button
├──────────────────────────────────────┤
│  Course Title (clickable)             │
│  Level: Beginner                      │  ← Skill level
│  Cost: 500 pts                        │  ← Points cost
└──────────────────────────────────────┘
```

#### Level Display Logic

The level name is looked up from `product_levels` table by matching:
1. `course_id` = `cart.product_id` (the course)
2. `price_in_points` = `cart.points` (the selected level price)

**Code to fetch level:**
```php
@php
    $level = \App\Models\ProductLevel::where('course_id', $cart->product_id)
                 ->where('price_in_points', $cart->points)
                 ->first();
@endphp
```

**Display in blade:**
```blade
<span class="level-badge">
    Level: {{ $level ? $level->skill_level : 'N/A' }}
</span>
```

#### Cost Calculation

**Points Cost = Selected Level's price_in_points**

```
cart.points = product_levels.price_in_points (set when user adds to cart)

Examples:
- Beginner level: 300 points
- Intermediate level: 500 points
- Advanced level: 800 points
```

---

### 1.3 Cart Summary Section

Sticky sidebar with purchase summary

```
┌───────────────────────────────────┐
│  CART SUMMARY                     │
├───────────────────────────────────┤
│  Total Points: 1,200 pts          │
├───────────────────────────────────┤
│  [Proceed to Checkout]            │
│  [Continue Shopping]              │
└───────────────────────────────────┘
```

#### Total Calculation

**Total Points = Sum of all cart items' points**

```blade
{{ number_format(Helper::totalCartPoints(), 0) }} {{ __('common.points') }}
```

The `totalCartPoints()` helper sums all points for items where `product_id < 1000`.

#### Action Buttons

**Checkout Button**
```blade
<a href="{{ route('checkout') }}" class="btn btn-primary">
    {{ __('common.proceed_to_checkout') }}
</a>
```
- Routes to checkout page
- Initiates points deduction

**Continue Shopping Button**
```blade
<a href="{{ route('home') }}" class="btn btn-outline">
    {{ __('common.continue_shopping') }}
</a>
```
- Routes back to home
- Continue without purchasing

---

### 1.4 Empty Cart State

When no items in cart:

```blade
@if(Helper::getAllProductFromCart()->where('order_id', null)->count() > 0)
    <!-- Show cart items -->
@else
    <div class="cart-empty">
        <i class="fal fa-shopping-cart"></i>
        <h3>Your cart is empty</h3>
        <a href="{{ route('home') }}">Browse Courses</a>
    </div>
@endif
```

---

### 1.5 Styling & Layout

**Cart Grid Layout:**
```css
.coursecart-grid {
    display: grid;
    grid-template-columns: 1fr 350px;  /* Items + Summary */
    gap: 40px;
}
```

**Course Cards Grid:**
```css
.coursecart-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}
```

---

## 🔄 Part 2: Purchase Flow (Cart → Checkout → Order)

### Complete Flow Diagram

```
USER IN COURSE CART PAGE
    ↓
[Sees available points & courses]
    ↓
Clicks "Proceed to Checkout" Button
    ↓
Navigates to: route('checkout')
    ↓
┌──────────────────────────────────────┐
│    CHECKOUT PAGE / POINTS GATE       │
├──────────────────────────────────────┤
│ • Displays cart items again          │
│ • Shows total points needed          │
│ • Checks user has enough points      │
│ • Deducts points from wallet         │
│ • Creates order                      │
│ • Links cart items to order          │
└──────────────────────────────────────┘
    ↓
Points Deduction & Order Processing
    ↓
DATABASE UPDATES:
├─ users.points_balance -= total_points
├─ point_transactions: INSERT log
├─ orders table: INSERT new order
│  └─ order_number, user_id, status, payment_status, etc.
└─ carts: UPDATE order_id = new_order_id
    ↓
User Redirected to DASHBOARD
    ↓
ORDERS NOW VISIBLE IN DASHBOARD TABS
```

---

### Transaction Details

#### 1. Points Deduction

```sql
UPDATE users 
SET points_balance = points_balance - [total_points_needed]
WHERE id = [auth()->id()];
```

**Example:**
- User has: 1000 points
- Purchases courses: 500 points worth
- Result: 500 points remaining

**Transaction Log:**
```sql
INSERT INTO point_transactions (
    user_id,
    amount,           -- negative for debit
    type,             -- 'debit'
    description,      -- 'Course Enrollment via Points'
    balance_before,
    balance_after
)
```

#### 2. Order Creation

```sql
INSERT INTO orders (
    order_number,      -- ORD-PTS-XXXXX (unique)
    user_id,           -- Current user ID
    first_name,        -- User's first name
    last_name,         -- User's last name
    email,             -- User's email
    quantity,          -- Number of courses
    currency,          -- 'points'
    total_amount,      -- Total points spent
    status,            -- 'Completed'
    payment_status,    -- 'paid'
    payment_method,    -- 'points'
    created_at,        -- Order timestamp
    updated_at
)
VALUES (...);
```

#### 3. Cart Items Updated

```sql
UPDATE carts 
SET order_id = [new_order_id]
WHERE user_id = [user_id] AND order_id IS NULL;
```

**Before Purchase:**
```
carts table:
├─ id: 100, product_id: 5, points: 300, order_id: NULL    ← Unpurchased
├─ id: 101, product_id: 3, points: 500, order_id: NULL    ← Unpurchased
└─ id: 102, product_id: 8, points: 200, order_id: NULL    ← Unpurchased
Total: 1000 points
```

**After Purchase:**
```
carts table:
├─ id: 100, product_id: 5, points: 300, order_id: 42      ← Linked to order
├─ id: 101, product_id: 3, points: 500, order_id: 42      ← Linked to order
└─ id: 102, product_id: 8, points: 200, order_id: 42      ← Linked to order
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
│  ▲ Welcome Section                                 │
│  └─ "Welcome, [Name]"                              │
│                                                    │
│  ▼ Stats Cards (4 columns)                         │
│  ├─ Available Points     │ Total Enrollments       │
│  ├─ Completed Orders     │ Member Since            │
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
│     ├─ Points Purchased Tab (wallet top-ups)       │
│     │  └─ Orders Table                             │
│     └─ Points Redeemed Tab (course enrollments)    │
│        └─ Orders Table                             │
└────────────────────────────────────────────────────┘
```

---

### 3.1 Stats Cards

Display 4 key metrics:

```blade
<div class="dashboard-stats">
    <div class="stat-card">
        <i class="fal fa-coins"></i>
        <span>Available Points</span>
        <span>{{ auth()->user()->points_balance ?? 0 }}</span>
    </div>
    
    <div class="stat-card">
        <i class="fal fa-book"></i>
        <span>Total Enrollments</span>
        <span>{{ count($redeemedOrders) }}</span>
    </div>
    
    <div class="stat-card">
        <i class="fal fa-check-circle"></i>
        <span>Completed</span>
        <span>{{ count($redeemedOrders->where('status', 'Completed')) }}</span>
    </div>
    
    <div class="stat-card">
        <i class="fal fa-user"></i>
        <span>Member Since</span>
        <span>{{ auth()->user()->created_at->format('M Y') }}</span>
    </div>
</div>
```

---

### 3.2 Sidebar Navigation

User profile and tab navigation:

```blade
<aside class="dashboard-sidebar">
    <div class="sidebar-header">
        <div class="sidebar-avatar">
            <i class="fal fa-user"></i>
        </div>
        <h4>{{ auth()->user()->name }}</h4>
        <p>{{ auth()->user()->email }}</p>
    </div>

    <nav class="sidebar-nav">
        <!-- Tab Navigation Links -->
        <a href="#points-purchased" class="nav-link active" data-tab="points-purchased">
            <i class="fal fa-wallet"></i>
            <span>Points Purchased</span>
        </a>
        
        <a href="#points-redeemed" class="nav-link" data-tab="points-redeemed">
            <i class="fal fa-graduation-cap"></i>
            <span>Points Redeemed</span>
        </a>
        
        <a href="{{ route('user.logout') }}" class="nav-link logout">
            <i class="fal fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </nav>
</aside>
```

---

### 3.3 Points Purchased Tab (Wallet Top-ups)

Shows orders where `product_id = 1000` (wallet top-up product)

#### Filter Logic

```php
@php
    $pointsPurchased = $purchasedOrders;  // Pre-filtered in controller
@endphp
```

The `HomeController::index()` passes `$purchasedOrders` which is already filtered for `product_id = 1000`.

#### Table Columns

| Column | Content | Example |
|--------|---------|---------|
| **Order Number** | Unique order ID | ORD-PTS-ABC123 |
| **Points Bought** | Quantity purchased | 1000 pts |
| **Price Paid** | Amount paid in currency | USD $29.99 |
| **Payment Status** | Status badge | Paid / Unpaid |
| **Date** | Purchase date | 15 May 2026 |
| **Action** | View details | [View] |

#### Display Code

```blade
<div id="points-purchased" class="dashboard-tab active">
    <h3>Points Purchased (Wallet Top-ups)</h3>
    
    @if($pointsPurchased->count() > 0)
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Points Bought</th>
                    <th>Price Paid</th>
                    <th>Payment Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pointsPurchased as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->cart_info->sum('points') }} pts</td>
                    <td>{{ Helper::getCurrencySymbol($order->currency) }}{{ number_format($order->total_amount, 2) }}</td>
                    <td><span class="badge badge-{{ strtolower($order->payment_status) }}">{{ ucfirst($order->payment_status) }}</span></td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td><a href="{{ route('user.order.show', $order->id) }}">View</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <h4>No wallet top-ups yet</h4>
            <p>You haven't purchased any points yet.</p>
        </div>
    @endif
</div>
```

---

### 3.4 Points Redeemed Tab (Course Enrollments)

Shows orders where `product_id < 1000` (actual course products)

#### Filter Logic

```php
@php
    $pointsRedeemed = $redeemedOrders;  // Pre-filtered in controller
@endphp
```

The `HomeController::index()` passes `$redeemedOrders` which is already filtered for `product_id < 1000`.

#### Table Columns

| Column | Content | Example |
|--------|---------|---------|
| **Order Number** | Unique order ID | ORD-PTS-XYZ789 |
| **Course Name** | Name of enrolled course | "React Advanced" |
| **Level** | Skill level enrolled | "Advanced" |
| **Points Used** | Total points redeemed | 500 pts |
| **Status** | Enrollment status | Redeemed |
| **Date** | Enrollment date | 14 May 2026 |

#### Display Code

```blade
<div id="points-redeemed" class="dashboard-tab">
    <h3>Points Redeemed (Course Enrollments)</h3>
    
    @if($pointsRedeemed->count() > 0)
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Course Name</th>
                    <th>Level</th>
                    <th>Points Used</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pointsRedeemed as $order)
                @php
                    $cartItem = $order->cart_info->first();
                    $level = \App\Models\ProductLevel::where('course_id', $cartItem->product_id)
                                 ->where('price_in_points', $cartItem->points)
                                 ->first();
                @endphp
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $cartItem->product->title }}</td>
                    <td>{{ $level ? $level->skill_level : 'N/A' }}</td>
                    <td>{{ $order->cart_info->sum('points') }} pts</td>
                    <td><span class="badge badge-success">Redeemed</span></td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td><a href="{{ route('user.order.show', $order->id) }}">View</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <h4>No course enrollments yet</h4>
            <p>You haven't redeemed any points for courses yet.</p>
        </div>
    @endif
</div>
```

---

### 3.5 Tab Switching (Vanilla JavaScript)

JavaScript for switching between tabs:

```javascript
document.addEventListener('DOMContentLoaded', function() {
    const tabLinks = document.querySelectorAll('.nav-link[data-tab]');

    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const tabId = this.getAttribute('data-tab');
            
            // Remove active class from all links
            tabLinks.forEach(l => l.classList.remove('active'));
            
            // Add active class to clicked link
            this.classList.add('active');
            
            // Hide all tabs
            document.querySelectorAll('.dashboard-tab').forEach(tab => {
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

**CSS:**
```css
.dashboard-tab {
    display: none !important;
}

.dashboard-tab.active {
    display: block !important;
}
```

---

## 🔗 Part 4: Data Flow Integration

### Complete Data Journey

```
COURSE DETAIL PAGE
├─ User selects a level (e.g., "Beginner")
├─ product_levels row with skill_level = "Beginner"
├─ price_in_points = 300
└─ Form submits to "Add to Cart"

    ↓ CartController::singleAddToCart()
    ↓ Saves: product_id, points (300), price, amount

COURSE CART PAGE ($cart variable)
├─ cart.product_id → product.id
├─ cart.points = 300
├─ cart.order_id = NULL (not yet purchased)
├─ Look up level via:
│  product_levels.where('course_id', cart.product_id)
│                 .where('price_in_points', cart.points)
│  → Returns skill_level = "Beginner"
└─ Display: Course Name | Level: Beginner | 300 PTS

    ↓ User clicks "Proceed to Checkout"
    ↓ PointsController::redeem()
    ↓ Points deducted, Order created

AFTER PURCHASE:
├─ users.points_balance -= 300
│
├─ point_transactions table (log)
│  ├─ user_id, amount: -300
│  ├─ type: 'debit'
│  └─ description: 'Course Enrollment via Points'
│
├─ orders table (NEW RECORD)
│  ├─ order_number = 'ORD-PTS-ABC123'
│  ├─ user_id
│  ├─ total_amount = 300
│  ├─ status = 'Completed'
│  ├─ payment_method = 'points'
│  └─ cart_info (relationship to cart_items)
│
└─ carts (UPDATED)
   ├─ order_id = new_order_id (no longer NULL)
   ├─ product_id, points (unchanged)
   └─ Now linked to order

    ↓ User redirected to dashboard

DASHBOARD PAGE
├─ Controller: HomeController::index()
│  ├─ $purchasedOrders = orders where cart_info.product_id = 1000
│  └─ $redeemedOrders = orders where cart_info.product_id < 1000
│
├─ Points Purchased Tab ($purchasedOrders)
│  └─ Shows wallet top-ups
│
└─ Points Redeemed Tab ($redeemedOrders)
   └─ Shows course enrollments
      ├─ Course Name: cart_info->product->title
      ├─ Level: Look up via product_levels match
      ├─ Points Used: cart_info->sum('points')
      └─ Status: 'Redeemed'
```

---

## 🧪 Part 5: Testing the Complete Flow

### Test Scenario: Enrolling in a Course

```
1. LOGIN
   └─ User logs in with credentials

2. BROWSE COURSES
   └─ View product details page
   └─ See available levels (Beginner, Advanced)

3. SELECT LEVEL & ADD TO CART
   └─ Click "Enroll Now" for a level (e.g., Beginner)
   └─ Cost shows: 300 pts
   └─ Added to cart

4. NAVIGATE TO COURSE CART
   └─ Route: /coursecart
   └─ Should see:
      ├─ Course title: "React Basics"
      ├─ Level badge: "Beginner"
      └─ Cost: 300 pts

5. VIEW CHECKOUT
   └─ Click "Proceed to Checkout"
   └─ Route: /checkout
   └─ Should show:
      ├─ Points needed: 300 pts
      ├─ User's balance: e.g., 1000 pts
      └─ Confirmation message

6. COMPLETE ENROLLMENT
   └─ Points deducted: 1000 → 700 pts
   └─ Order created in database
   └─ Cart items linked to order

7. REDIRECT TO DASHBOARD
   └─ Route: /user/dashboard (or /points/dashboard)
   └─ Available Points card shows: 700 pts
   └─ Total Enrollments: +1

8. VERIFY IN DASHBOARD "POINTS REDEEMED TAB"
   ✓ Shows new course enrollment
   ✓ Order Number: ORD-PTS-xxxxx
   ✓ Course Name: "React Basics"
   ✓ Level: "Beginner"
   ✓ Points Used: 300 pts
   ✓ Status: "Redeemed"
   ✓ Date: Today's date
   ✓ "View" button works
```

---

## 📝 Part 6: Implementation Checklist

Follow these steps in order:

1. ✅ Create `resources/views/frontend/pages/coursecart.blade.php`
   - [ ] Copy base structure from `cart.blade.php`
   - [ ] Add level lookup logic in card display
   - [ ] Style course cards with level badge
   - [ ] Add cart summary sidebar

2. ✅ Add route in `routes/web.php`
   - [ ] `Route::get('/coursecart', fn() => view('frontend.pages.coursecart'))->name('coursecart');`

3. ✅ Update `HomeController::index()`
   - [ ] Split `$orders` into `$purchasedOrders` and `$redeemedOrders`
   - [ ] Pass both to dashboard view

4. ✅ Update `dashboard.blade.php`
   - [ ] Add two tab navigation links
   - [ ] Create two tab pane containers
   - [ ] Points Purchased: show wallet top-ups
   - [ ] Points Redeemed: show course enrollments with level lookup
   - [ ] Add tab switching JavaScript

5. ✅ Test end-to-end flow
   - [ ] Add course to cart
   - [ ] View level name in cart
   - [ ] Complete checkout
   - [ ] Verify dashboard tabs show correct data
   - [ ] Check level name displays correctly

---

## 🔐 Part 7: Security & Access Control

### Authentication Requirements

**Course Cart:**
```blade
@auth
    <!-- Show cart -->
@else
    <!-- Redirect to login -->
@endauth
```

**Dashboard:**
```blade
@auth
    <!-- Dashboard content -->
@else
    <!-- Redirect to login -->
@endauth
```

### Data Isolation

```php
// Fetch only current user's orders
$orders = Order::where('user_id', auth()->id())->get();

// Fetch only current user's cart items
$cart = Cart::where('user_id', auth()->id())->where('order_id', null)->get();
```

- Users can only see their own cart
- Users can only see their own orders
- Database queries filter by `user_id`
- Cannot access other users' data

---

## 📊 Part 8: Key Database Tables

### product_levels Table
```sql
CREATE TABLE product_levels (
    id BIGINT PRIMARY KEY,
    course_id BIGINT FOREIGN KEY,      -- FK to products.id
    skill_level VARCHAR(191),           -- e.g., "Beginner"
    skill_level_jp VARCHAR(191),        -- Japanese translation
    purpose TEXT,
    purpose_jp TEXT,
    learn_info TEXT,
    learn_info_jp TEXT,
    outcome TEXT,
    outcome_jp TEXT,
    price DOUBLE(8,2),                  -- USD price
    price_jp DOUBLE(8,2),               -- JPY price
    price_hk DOUBLE(8,2),               -- HKD price
    price_in_points INT,                -- Points cost ← Used for lookup
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### carts Table
```sql
CREATE TABLE carts (
    id BIGINT PRIMARY KEY,
    user_id BIGINT FOREIGN KEY,
    product_id BIGINT,                  -- FK to products.id
    price DOUBLE(8,2),
    price_jp DOUBLE(8,2),
    price_hk DOUBLE(8,2),
    points INT,                         -- Points cost (from product_levels.price_in_points)
    amount DOUBLE(8,2),
    amount_jp DOUBLE(8,2),
    amount_hk DOUBLE(8,2),
    order_id BIGINT NULLABLE,           -- NULL = unpurchased, Value = purchased
    status VARCHAR(20) DEFAULT 'New',
    quantity INT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### orders Table
```sql
CREATE TABLE orders (
    id BIGINT PRIMARY KEY,
    order_number VARCHAR(50) UNIQUE,    -- ORD-PTS-XXXXX
    user_id BIGINT FOREIGN KEY,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    email VARCHAR(255),
    quantity INT,
    currency VARCHAR(10),
    total_amount INT,                   -- Total points spent
    status VARCHAR(50),                 -- 'Completed', 'Pending'
    payment_status VARCHAR(50),         -- 'paid', 'unpaid'
    payment_method VARCHAR(50),         -- 'points'
    trans_id VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### users Table (relevant fields)
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    points_balance INT,                 -- User's current points
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## 🔄 Part 9: Key Relationships

### Level Name Lookup

**In Cart:**
```php
$level = ProductLevel::where('course_id', $cart->product_id)
                      ->where('price_in_points', $cart->points)
                      ->first();

$skillLevel = $level?->skill_level ?? 'N/A';
```

**In Dashboard:**
```php
$cartItem = $order->cart_info->first();
$level = ProductLevel::where('course_id', $cartItem->product_id)
                      ->where('price_in_points', $cartItem->points)
                      ->first();

$skillLevel = $level?->skill_level ?? 'N/A';
```

### Why This Approach?

- `product_levels` stores all course level details including `skill_level`
- `carts` stores `product_id` (which course) and `points` (which level's price)
- By matching both fields, we identify the exact level without needing a `level_id` column
- Existing data structure, no migrations needed

---

## 🚀 Quick Reference

### Files Involved
- **Course Cart:** `resources/views/frontend/pages/coursecart.blade.php` (NEW)
- **Dashboard:** `resources/views/frontend/user/dashboard.blade.php` (MODIFIED)
- **Routes:** `routes/web.php` (ADD /coursecart route)
- **Controller:** `app/Http/Controllers/HomeController.php` (MODIFIED)

### Key Routes
- `route('coursecart')` → Course cart page
- `route('checkout')` → Checkout page (existing)
- `route('points.dashboard')` → Dashboard (existing)
- `route('user.order.show', $order->id)` → Order details

### Key Helpers
- `Helper::cartCount()` → Check if cart has items
- `Helper::getAllProductFromCart()` → Get all cart items
- `Helper::totalCartPoints()` → Calculate total points in cart
- `Helper::getCurrencySymbol($currency)` → Get currency symbol

---

## ✅ Verification Checklist

After implementation, verify these items:

- [ ] Course cart page displays at `/coursecart`
- [ ] Cart shows level name for each course (e.g., "Beginner")
- [ ] Cart shows points cost from `product_levels.price_in_points`
- [ ] Total points calculated correctly in sidebar
- [ ] Checkout redirects to `/checkout`
- [ ] Points deducted from user wallet after purchase
- [ ] Order created in database with correct status
- [ ] Dashboard shows two tabs: "Points Purchased" and "Points Redeemed"
- [ ] Points Redeemed tab shows enrolled courses with level name
- [ ] Points Purchased tab shows wallet top-ups
- [ ] Tab switching works without page reload
- [ ] Available Points stat card updated after purchase
- [ ] Level names display correctly in both English and Japanese locales
- [ ] Empty cart message shows when cart is empty
- [ ] Empty state messages show when no orders in tab
- [ ] Responsive design works on mobile/tablet

---

## 📞 Support

For issues or questions:
1. Verify cart items have `order_id = NULL` (unpurchased) or have an order_id (purchased)
2. Check that `product_levels` row exists for the selected course/level combination
3. Verify `points` matches `product_levels.price_in_points`
4. Check order was created with correct `user_id` and `total_amount`
5. Verify points were deducted from `users.points_balance`
6. Check browser console for JavaScript errors in tab switching
7. Clear browser cache if tab content doesn't display

---

**Last Updated:** 2026-05-22
**Status:** Complete Guide ✅
