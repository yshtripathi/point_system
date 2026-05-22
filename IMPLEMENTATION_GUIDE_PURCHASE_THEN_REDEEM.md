# Complete Implementation Guide: Purchase Points → Redeem on Products

## 📌 Overview

This guide explains how to implement a **two-step points system**:
1. **Step 1:** Users purchase points/wallet top-ups (product_id = 1000)
2. **Step 2:** Users use those points to redeem products (product_id < 1000)

This is the complete flow used in the website - anyone (person or AI) can implement it.

---

## 🏗️ Architecture Overview

```
┌─────────────────────────────────────────────────────────────────┐
│              TWO-STEP POINTS SYSTEM ARCHITECTURE                │
└─────────────────────────────────────────────────────────────────┘

STEP 1: PURCHASE POINTS
┌────────────────────────────────┐
│ User Buys Points Package       │
│ (product_id = 1000)            │
├────────────────────────────────┤
│ 1. Add to Cart                 │
│ 2. Process Payment             │
│ 3. Deduct Money from Account   │
│ 4. Add Points to User Balance  │
│ 5. Create Order Record         │
└────────────────────────────────┘
         ↓
User Balance: Points Increased
         ↓
STEP 2: REDEEM POINTS
┌────────────────────────────────┐
│ User Buys Products with Points │
│ (product_id < 1000)            │
├────────────────────────────────┤
│ 1. Add to Cart                 │
│ 2. Verify Points Balance       │
│ 3. Deduct Points from Balance  │
│ 4. Create Order Record         │
│ 5. Fulfill Order               │
└────────────────────────────────┘
         ↓
User Balance: Points Decreased
         ↓
USER DASHBOARD
Shows both purchase & redemption history
```

---

## 🗄️ Database Schema

### 1. Users Table

```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255),
    points INT DEFAULT 0,                    -- ← User's point balance
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Examples:
-- John has 500 points after purchase
-- John uses 350 points to buy product
-- John has 150 points remaining
```

### 2. Cart Items Table

```sql
CREATE TABLE cart_items (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    product_id INT NOT NULL,                 -- ← 1000 for points, <1000 for products
    quantity INT DEFAULT 1,
    hours DECIMAL(5,2) DEFAULT 0,            -- ← For training hours
    price DECIMAL(10,2),                     -- ← Base price
    price_jp DECIMAL(10,2),                  -- ← Japanese yen price
    price_hk DECIMAL(10,2),                  -- ← Hong Kong dollar price
    amount DECIMAL(10,2),                    -- ← Total (price × quantity)
    amount_jp DECIMAL(10,2),
    amount_hk DECIMAL(10,2),
    points INT DEFAULT 0,                    -- ← Points being purchased (if product_id = 1000)
    order_id BIGINT DEFAULT NULL,            -- ← NULL = unpurchased, VALUE = purchased
    status VARCHAR(50),                      -- ← 'Pending', 'Completed', 'Redeemed'
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

-- BEFORE PURCHASE:
-- product_id: 1000, points: 500, order_id: NULL
-- 
-- AFTER PURCHASE:
-- product_id: 1000, points: 500, order_id: 1 ← Linked to order

-- FOR PRODUCT REDEMPTION:
-- product_id: 5, amount: 350, order_id: NULL
-- 
-- AFTER REDEMPTION:
-- product_id: 5, amount: 350, order_id: 2 ← Linked to order
```

### 3. Orders Table

```sql
CREATE TABLE orders (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    order_number VARCHAR(50) UNIQUE,         -- ← ORD-XXXXXXXXXX
    user_id BIGINT NOT NULL,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    email VARCHAR(255),
    quantity INT,
    currency VARCHAR(10),                    -- ← USD, JPY, HKD
    sub_total DECIMAL(10,2),
    total_amount DECIMAL(10,2),              -- ← Amount deducted (points or money)
    status VARCHAR(50),                      -- ← 'new', 'Completed', 'Pending'
    payment_status VARCHAR(50),              -- ← 'Paid', 'Unpaid'
    payment_method VARCHAR(50),              -- ← 'credit_card', 'paypal', 'points'
    trans_id VARCHAR(255),                   -- ← Transaction ID
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### 4. Products Table

```sql
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),
    slug VARCHAR(255) UNIQUE,
    price DECIMAL(10,2),
    price_jp DECIMAL(10,2),
    price_hk DECIMAL(10,2),
    stock INT,
    discount DECIMAL(5,2),
    photo LONGTEXT,                          -- ← Comma-separated image paths
    summary TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Examples:
-- id: 1000, title: '500 Points Package', price: 29.99   ← POINTS PURCHASE
-- id: 5, title: 'Rank Boost Service', price: 250         ← PRODUCT (REDEEMABLE)
-- id: 8, title: 'Coaching Session', price: 350           ← PRODUCT (REDEEMABLE)
```

---

## 🔄 Complete Flow Explanation

### FLOW DIAGRAM

```
USER JOURNEY
├─ Home Page
├─ Browse Products / Points Packages
│
├─ STEP 1: PURCHASE POINTS
│  ├─ Add Points Package to Cart (product_id = 1000)
│  │  └─ Cart:
│  │     ├─ user_id: 1
│  │     ├─ product_id: 1000
│  │     ├─ price: 29.99 (USD)
│  │     ├─ points: 500 (points to receive)
│  │     └─ order_id: NULL
│  │
│  ├─ Go to Checkout
│  ├─ Process Payment (Credit Card / PayPal)
│  │  └─ Payment Gateway deducts $29.99
│  │
│  └─ CREATE ORDER (Payment Successful)
│     ├─ INSERT into orders table
│     │  ├─ order_number: 'ORD-ABC123XYZ'
│     │  ├─ user_id: 1
│     │  ├─ total_amount: 29.99
│     │  ├─ status: 'new' / 'Completed'
│     │  ├─ payment_status: 'Paid'
│     │  └─ payment_method: 'credit_card'
│     │
│     ├─ UPDATE cart_items
│     │  └─ SET order_id = [new_order_id]
│     │     WHERE product_id = 1000 AND user_id = 1
│     │
│     └─ UPDATE users (THIS IS CRITICAL!)
│        └─ SET points = points + 500
│           WHERE id = 1
│           Result: User now has 500 points
│
├─ REDIRECT TO DASHBOARD
│  └─ User sees:
│     ├─ Available Points: 500 ← Updated!
│     ├─ Points Purchased Tab: Shows points purchase order
│     └─ Can now purchase products with points
│
├─ STEP 2: REDEEM POINTS ON PRODUCTS
│  ├─ Browse Products
│  ├─ Add Products to Cart (product_id < 1000)
│  │  └─ Cart:
│  │     ├─ user_id: 1
│  │     ├─ product_id: 5 (Rank Boost)
│  │     ├─ amount: 250 (points cost)
│  │     └─ order_id: NULL
│  │
│  ├─ Go to Cart Page
│  ├─ See Cart Summary
│  │  └─ Total Points Needed: 250
│  │
│  └─ POINTS REDEMPTION (No payment, use balance)
│     ├─ User clicks "Redeem Points" button
│     │
│     ├─ VERIFY:
│     │  ├─ Check user has product_id 1000 in cart? NO → Cannot add products
│     │  ├─ Check user has enough points? 500 >= 250? YES → Proceed
│     │  └─ Check cart doesn't mix products with points? YES → Only products
│     │
│     ├─ DEDUCT POINTS from user balance
│     │  └─ UPDATE users
│     │     SET points = points - 250
│     │     WHERE id = 1
│     │     Result: User now has 250 points (500 - 250)
│     │
│     ├─ CREATE ORDER
│     │  ├─ INSERT into orders table
│     │  │  ├─ order_number: 'ORD-DEF456GHI'
│     │  │  ├─ user_id: 1
│     │  │  ├─ total_amount: 250 (points, not money!)
│     │  │  ├─ status: 'new'
│     │  │  ├─ payment_status: 'Paid'
│     │  │  └─ payment_method: 'points' ← Different from payment!
│     │  │
│     │  └─ UPDATE cart_items
│     │     SET order_id = [new_order_id]
│     │     WHERE product_id < 1000 AND user_id = 1
│     │
│     ├─ SEND CONFIRMATION EMAIL
│     │
│     └─ REDIRECT TO DASHBOARD
│        └─ User sees:
│           ├─ Available Points: 250 ← Updated!
│           ├─ Points Purchased Tab: Shows points purchase order
│           └─ Points Redeemed Tab: Shows product redemption order
│
└─ END JOURNEY
```

---

## 💻 Controller Implementation

### File: `app/Http/Controllers/CartController.php`

#### 1. Add to Cart Methods

**Method 1: Single Add to Cart (Products)**

```php
public function singleAddToCart(Request $request){ 
    $request->validate([
        'slug' => 'required',
        'quant' => 'required',
    ]);
    
    $product = Product::getProductBySlug($request->slug);
    $user_id = auth()->check() ? auth()->id() : session('guest');
    
    // KEY CHECK: Cannot mix points purchase with products
    $cartp = Cart::where('user_id', $user_id)
                  ->where('order_id', null)
                  ->pluck('product_id')
                  ->first();
    
    if(isset($cartp) && $cartp == 1000 && $product->id < 1000) {
        // If cart has points (1000), cannot add products
        return back()->with('error', __('common.purchase_existing_credits'));
    }
    
    // Check if already in cart
    $already_cart = Cart::where('user_id', $user_id)
                         ->where('order_id', null)
                         ->where('product_id', $product->id)
                         ->first();
    
    if($already_cart) {
        // Item exists, show error
        return back()->with('error', __('common.product_already_in_cart'));
    } else {
        // Calculate total price (product + training hours)
        $true_price = $product->price;
        if($request->hours > 0) {
            $true_price = $product->price + (20 * $request->hours);
        }
        
        // Create cart item
        $cart = new Cart;
        $cart->user_id = $user_id;
        $cart->product_id = $product->id;      // ← Product ID (< 1000)
        $cart->price = $true_price;
        $cart->quantity = $request->quant[1];
        $cart->hours = $request->hours;
        $cart->amount = $true_price * $request->quant[1];
        $cart->order_id = null;                 // ← Not yet purchased
        $cart->save();
        
        return back()->with('success', __('common.product_add'));
    }
}
```

**Method 2: Points Add to Cart (Wallet Top-Up)**

```php
public function pointsAddToCart(Request $request){
    $request->validate([
        'slug' => 'required',
        'quant' => 'required',
    ]);
    
    $user_id = auth()->user()->id ?? session('guest');
    
    // KEY CHECK: Cannot mix products with points
    $cartp = Cart::where('user_id', $user_id)
                  ->where('order_id', null)
                  ->pluck('product_id')
                  ->first();
    
    if(isset($cartp) && $cartp < 1000) {
        // If cart has products, cannot add points
        return back()->with('error', __('common.can_not_add'));
    }
    
    // Check if points package already in cart
    $already_cart = Cart::where('user_id', $user_id)
                         ->where('order_id', null)
                         ->where('product_id', 1000)
                         ->first();
    
    // Calculate actual points with bonus tier
    $truepoints = $request->points;
    
    if(session('currency') == 'USD') {
        $price = $request->price;
        
        // Bonus tier calculation
        switch (true) {
            case ($truepoints > 1 && $truepoints < 631):
                $truepoints = $truepoints;
                break;
            case ($truepoints > 630 && $truepoints < 1881):
                $truepoints = round($truepoints * 1.5);  // 50% bonus
                break;
            case ($truepoints > 1881 && $truepoints < 3126):
                $truepoints = round($truepoints * 2);    // 100% bonus
                break;
            case ($truepoints > 3125):
                $truepoints = round($truepoints * 5);    // 400% bonus
                break;
        }
    }
    
    if($already_cart) {
        // Update existing points package
        $already_cart->quantity = 1;
        $already_cart->amount = $price;
        $already_cart->points = $truepoints;
        $already_cart->save();
    } else {
        // Create new cart item for points
        $cart = new Cart;
        $cart->user_id = $user_id;
        $cart->product_id = 1000;              // ← Points purchase ID
        $cart->price = $price;
        $cart->quantity = 1;
        $cart->amount = $price;
        $cart->points = $truepoints;           // ← Points to receive
        $cart->order_id = null;                // ← Not yet purchased
        $cart->save();
    }
    
    return back()->with('success', __('common.product_add'));
}
```

#### 2. Checkout Method

```php
public function checkout(Request $request){
    if(!Auth::check()) {
        return redirect()->route('login.form');
    }
    
    $user_id = auth()->id();
    $cart = Cart::where('user_id', $user_id)
                ->where('order_id', null)
                ->get();
    
    $product_id_collection = $cart->pluck('product_id');
    
    // KEY LOGIC: If cart contains points (1000), redirect to checkout
    if($product_id_collection->contains(1000)) {
        // Points purchase: Remove any product items
        Cart::where('user_id', $user_id)
            ->where('order_id', null)
            ->where('product_id', '<', 1000)
            ->delete();
        
        return view('frontend.pages.checkout');
    } else {
        // Product purchase with points: Cannot proceed yet
        // User must use pointsredeem method
        return view('frontend.pages.gamecart');
    }
}
```

#### 3. Points Redemption Method (NO Payment)

```php
public function pointsredeem(Request $request){
    // This method DEDUCTS points from user balance
    // No payment processing needed
    
    $cart = Cart::where('user_id', auth()->user()->id)
                ->where('order_id', null)
                ->first();
    
    // Get total points to redeem
    $redeempoints = $cart->price;  // Points cost
    
    // Check user has enough points
    $avpoints = User::where('id', auth()->user()->id)
                    ->pluck('points')
                    ->first();
    
    if($redeempoints > $avpoints) {
        // Not enough points
        return back()->with('error', __('common.insufficient_credit_points'));
    }
    
    // CRITICAL: DEDUCT POINTS from user balance
    User::where('id', auth()->id())
        ->decrement('points', $redeempoints);
    
    // Generate order number
    $order_id = rand(100000, 999999);
    
    // Link cart items to order
    $cart->update([
        'order_id' => $order_id,
        'status' => 'Redeemed'
    ]);
    
    // Get redeemed order info
    $redeemed = Cart::where('user_id', auth()->user()->id)
                    ->where('order_id', $order_id)
                    ->with('product')
                    ->first();
    
    // Send confirmation email
    try {
        Mail::to(auth()->user()->email)
            ->send(new RedeemConfirmationMail($redeemed));
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
    }
    
    return back()->with('success', __('common.order_placed_success'));
}
```

### File: `app/Http/Controllers/OrderController.php`

#### Order Store Method (Payment Processing)

```php
public function store(Request $request){
    // Validate payment details
    $this->validate($request, [
        'first_name' => 'string|required',
        'last_name' => 'string',
        'email' => 'string|required',
        'card_number' => 'required|string',
        'expiry_month' => 'required|string',
        'expiry_year' => 'required|string',
        'cvv' => 'required|string',
        'terms' => 'required',
        'captcha' => 'required|captcha'
    ]);
    
    // Check cart is not empty
    if(empty(Cart::where('user_id', auth()->user()->id)
                  ->where('order_id', null)
                  ->first())) {
        return back()->with('error', __('common.cart_empty_msg'));
    }
    
    // Create order record
    $order = new Order();
    $order->order_number = 'ORD-' . strtoupper(Str::random(10));
    $order->user_id = $request->user()->id;
    $order->first_name = $request->first_name;
    $order->last_name = $request->last_name;
    $order->email = $request->email;
    $order->quantity = Helper::cartCount();
    $order->currency = session("currency");
    $order->total_amount = Helper::totalCartPrice();
    $order->status = "new";
    $order->payment_method = 'credit_card';
    $order->payment_status = 'pending';
    
    // Process payment through payment gateway
    // (Stripe, PayPal, etc.)
    $paymentProcessed = $this->processPayment($request);
    
    if($paymentProcessed['success']) {
        // Payment successful
        $order->payment_status = 'paid';
        $order->trans_id = $paymentProcessed['transaction_id'];
        $order->save();
        
        // CRITICAL: Link cart items to order
        Cart::where('user_id', auth()->user()->id)
            ->where('order_id', null)
            ->update(['order_id' => $order->id]);
        
        // Check if cart contains points package
        $cart_items = Cart::where('user_id', auth()->user()->id)
                          ->where('order_id', $order->id)
                          ->get();
        
        foreach($cart_items as $item) {
            if($item->product_id == 1000) {
                // CRITICAL: ADD POINTS to user balance
                User::where('id', auth()->user()->id)
                    ->increment('points', $item->points);
            }
        }
        
        // Send confirmation email
        Mail::to($request->email)
            ->send(new OrderConfirmationMail($order));
        
        return redirect()->route('user.dashboard')
                        ->with('success', __('common.order_placed_success'));
    } else {
        // Payment failed
        return back()->with('error', __('common.payment_failed'));
    }
}

private function processPayment($request){
    // Payment gateway integration (Stripe, PayPal, etc.)
    // This is simplified - actual implementation depends on gateway
    
    try {
        // Send payment to gateway
        $response = $paymentGateway->charge([
            'amount' => Helper::totalCartPrice(),
            'currency' => session('currency'),
            'card_number' => $request->card_number,
            'expiry_month' => $request->expiry_month,
            'expiry_year' => $request->expiry_year,
            'cvv' => $request->cvv
        ]);
        
        if($response['success']) {
            return [
                'success' => true,
                'transaction_id' => $response['transaction_id']
            ];
        } else {
            return ['success' => false];
        }
    } catch (\Exception $e) {
        return ['success' => false];
    }
}
```

---

## 🛣️ Routes Configuration

**File: `routes/web.php`**

```php
// Cart Management Routes
Route::post('/cart/add-to-cart', [CartController::class, 'addToCart'])->name('single-add-to-cart');
Route::post('/cart/single-add-to-cart', [CartController::class, 'singleAddToCart'])->name('single-add-item');
Route::post('/cart/points-add-to-cart', [CartController::class, 'pointsAddToCart'])->name('points-add-to-cart');
Route::get('/cart/delete/{id}', [CartController::class, 'cartDelete'])->name('cart-delete');

// Checkout Routes
Route::get('/checkout', [CartController::class, 'checkout'])->name('buygame');
Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');

// Redemption Route (Points only)
Route::post('/cart/points-redeem', [CartController::class, 'pointsredeem'])->name('points.redeem');

// Dashboard
Route::get('/user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
Route::get('/user/orders/{id}', [OrderController::class, 'show'])->name('user.order.show');
```

---

## 🎨 View Implementation

### Game Cart Page

**File: `resources/views/frontend/pages/gamecart.blade.php`**

```blade
<!-- Check if cart contains points or products -->
@php
    $cartItems = Helper::getAllProductFromCart();
    $hasPoints = $cartItems->contains('product_id', 1000);
    $hasProducts = $cartItems->contains(function($item) {
        return $item->product_id < 1000;
    });
@endphp

<!-- Only show purchase button for points -->
@if($hasPoints && !$hasProducts)
    <a href="{{ route('buygame') }}" class="btn btn-primary">
        Purchase Services
    </a>
@endif

<!-- Show redeem button for products (no points in cart) -->
@if($hasProducts && !$hasPoints)
    <form action="{{ route('points.redeem') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">
            Redeem Points
        </button>
    </form>
@endif

<!-- Show error if mixing -->
@if($hasPoints && $hasProducts)
    <p class="error">
        Cannot mix points purchase with products. Please clear cart.
    </p>
@endif
```

### Dashboard Implementation

**File: `resources/views/frontend/user/dashboard.blade.php`**

```blade
<!-- Get all user orders -->
@php
    $orders = Order::where('user_id', auth()->id())->get();
@endphp

<!-- Points Purchased Tab (product_id = 1000) -->
<div class="tab-pane active" id="points-purchased">
    <h3>Points Purchased</h3>
    
    @php
        $pointsPurchased = $orders->filter(function($order) {
            // Get first cart item for this order
            $cartItem = Cart::where('order_id', $order->id)
                           ->where('product_id', 1000)
                           ->first();
            return $cartItem !== null;
        });
    @endphp
    
    @if($pointsPurchased->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Points Bought</th>
                    <th>Price Paid</th>
                    <th>Payment Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pointsPurchased as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>
                        @php
                            $cart = Cart::where('order_id', $order->id)
                                       ->where('product_id', 1000)
                                       ->first();
                        @endphp
                        {{ $cart->points ?? 0 }} pts
                    </td>
                    <td>{{ $order->currency }} {{ $order->total_amount }}</td>
                    <td>{{ ucwords($order->payment_status) }}</td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No points purchased yet.</p>
    @endif
</div>

<!-- Points Redeemed Tab (product_id < 1000) -->
<div class="tab-pane" id="points-redeemed">
    <h3>Points Redeemed</h3>
    
    @php
        $pointsRedeemed = $orders->filter(function($order) {
            // Get first cart item for this order
            $cartItem = Cart::where('order_id', $order->id)
                           ->where('product_id', '<', 1000)
                           ->first();
            return $cartItem !== null;
        });
    @endphp
    
    @if($pointsRedeemed->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Product</th>
                    <th>Points Used</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pointsRedeemed as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>
                        @php
                            $cart = Cart::where('order_id', $order->id)
                                       ->where('product_id', '<', 1000)
                                       ->first();
                        @endphp
                        {{ $cart->product->title ?? 'N/A' }}
                    </td>
                    <td>{{ $cart->amount ?? 0 }} pts</td>
                    <td>{{ ucwords($order->status) }}</td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No products redeemed yet.</p>
    @endif
</div>
```

---

## 🔐 Security Checks

### Critical Validation Points

**1. Prevent Mixing Points + Products**

```php
// In CartController::singleAddToCart
$cartp = Cart::where('user_id', $user_id)
             ->where('order_id', null)
             ->pluck('product_id')
             ->first();

if(isset($cartp) && $cartp == 1000 && $product->id < 1000) {
    // Cannot add products if points already in cart
    return back()->with('error', 'Cannot mix with points');
}
```

**2. Verify Points Balance Before Redemption**

```php
// In CartController::pointsredeem
$avpoints = User::where('id', auth()->user()->id)->pluck('points')->first();

if($redeempoints > $avpoints) {
    return back()->with('error', 'Insufficient points');
}
```

**3. Prevent Unauthorized Access**

```php
// In DashboardController
@auth
    // Show dashboard
@else
    // Redirect to login
@endauth
```

**4. Verify Order Ownership**

```php
// In OrderController::show
$order = Order::where('id', $order_id)
              ->where('user_id', auth()->id())
              ->firstOrFail();
```

---

## 📊 Data Flow Examples

### Example 1: Purchase Points (Money → Points)

```
BEFORE:
┌──────────────────────────────────┐
│ User: John                       │
├──────────────────────────────────┤
│ Points Balance: 0                │
│ Money: $50 (in bank account)     │
└──────────────────────────────────┘

STEP 1: Add to Cart
┌──────────────────────────────────┐
│ Cart Item Created                │
├──────────────────────────────────┤
│ product_id: 1000 (Points)        │
│ price: 29.99 (USD)               │
│ points: 500 (to receive)         │
│ order_id: NULL                   │
└──────────────────────────────────┘

STEP 2: Checkout & Payment
┌──────────────────────────────────┐
│ Payment Processing               │
├──────────────────────────────────┤
│ Gateway: Stripe/PayPal           │
│ Amount: $29.99                   │
│ Status: Approved                 │
└──────────────────────────────────┘

STEP 3: Create Order
┌──────────────────────────────────┐
│ Order Created (order_id = 1)     │
├──────────────────────────────────┤
│ order_number: ORD-ABC123         │
│ user_id: 1 (John)                │
│ total_amount: 29.99              │
│ payment_status: Paid             │
└──────────────────────────────────┘

STEP 4: Update Cart Item
Cart Item:
  order_id: NULL → 1 (linked)

STEP 5: ADD POINTS TO USER
User.points: 0 → 500

AFTER:
┌──────────────────────────────────┐
│ User: John                       │
├──────────────────────────────────┤
│ Points Balance: 500 ← INCREASED! │
│ Money: $20.01 remaining          │
└──────────────────────────────────┘

Dashboard Shows:
├─ Points Purchased Tab
│  └─ Order: ORD-ABC123
│     ├─ Points Bought: 500
│     ├─ Price Paid: USD $29.99
│     ├─ Status: Paid
│     └─ Date: Today
```

### Example 2: Redeem Points (Points → Product)

```
BEFORE:
┌──────────────────────────────────┐
│ User: John                       │
├──────────────────────────────────┤
│ Points Balance: 500              │
│ Available Products: Yes          │
└──────────────────────────────────┘

STEP 1: Add Product to Cart
┌──────────────────────────────────┐
│ Cart Item Created                │
├──────────────────────────────────┤
│ product_id: 5 (Rank Boost)       │
│ amount: 350 (points cost)        │
│ quantity: 1                      │
│ order_id: NULL                   │
└──────────────────────────────────┘

STEP 2: Verify Points Balance
┌──────────────────────────────────┐
│ Balance Check                    │
├──────────────────────────────────┤
│ User Points: 500                 │
│ Required: 350                    │
│ Sufficient: YES ✓                │
└──────────────────────────────────┘

STEP 3: Deduct Points
User.points: 500 → 150

STEP 4: Create Order (NO Payment)
┌──────────────────────────────────┐
│ Order Created (order_id = 2)     │
├──────────────────────────────────┤
│ order_number: ORD-DEF456         │
│ user_id: 1 (John)                │
│ total_amount: 350 (points)       │
│ payment_status: Paid             │
│ payment_method: points ← No $ paid
└──────────────────────────────────┘

STEP 5: Update Cart Item
Cart Item:
  order_id: NULL → 2 (linked)

AFTER:
┌──────────────────────────────────┐
│ User: John                       │
├──────────────────────────────────┤
│ Points Balance: 150 ← DECREASED! │
│ Products: 1 ordered              │
└──────────────────────────────────┘

Dashboard Shows:
├─ Points Redeemed Tab
│  └─ Order: ORD-DEF456
│     ├─ Product: Rank Boost
│     ├─ Points Used: 350
│     ├─ Status: Completed
│     └─ Date: Today
└─ Available Points Updated: 150
```

---

## 🚀 Step-by-Step Implementation Guide

### For Someone New to This

#### Phase 1: Setup Database (Hour 1-2)

1. Create tables using migration files:
```bash
php artisan make:migration create_users_table
php artisan make:migration create_cart_items_table
php artisan make:migration create_orders_table
php artisan make:migration create_products_table
```

2. Run migrations:
```bash
php artisan migrate
```

#### Phase 2: Create Models (Hour 2-3)

```bash
php artisan make:model User
php artisan make:model Cart
php artisan make:model Order
php artisan make:model Product
```

Each model should have relationships:

**User Model:**
```php
public function orders() {
    return $this->hasMany(Order::class);
}

public function cart() {
    return $this->hasMany(Cart::class);
}
```

**Cart Model:**
```php
public function user() {
    return $this->belongsTo(User::class);
}

public function product() {
    return $this->belongsTo(Product::class);
}

public function order() {
    return $this->belongsTo(Order::class);
}
```

**Order Model:**
```php
public function user() {
    return $this->belongsTo(User::class);
}

public function cart_items() {
    return $this->hasMany(Cart::class, 'order_id');
}
```

#### Phase 3: Create Controllers (Hour 3-5)

```bash
php artisan make:controller CartController
php artisan make:controller OrderController
php artisan make:controller DashboardController
```

Copy the controller code from this guide into each file.

#### Phase 4: Create Routes (Hour 5-6)

```php
// In routes/web.php
Route::post('/cart/single-add-to-cart', [CartController::class, 'singleAddToCart']);
Route::post('/cart/points-add-to-cart', [CartController::class, 'pointsAddToCart']);
Route::post('/cart/points-redeem', [CartController::class, 'pointsredeem']);
Route::post('/order/store', [OrderController::class, 'store']);
Route::get('/user/dashboard', [DashboardController::class, 'index']);
```

#### Phase 5: Create Views (Hour 6-10)

1. Create cart page: `resources/views/frontend/pages/gamecart.blade.php`
2. Create checkout page: `resources/views/frontend/pages/checkout.blade.php`
3. Create dashboard: `resources/views/frontend/user/dashboard.blade.php`

#### Phase 6: Testing (Hour 10-12)

1. Test adding points to cart
2. Test purchasing points with payment
3. Test adding products to cart
4. Test redeeming points
5. Test dashboard display

---

## ✅ Testing Checklist

```
STEP 1: PURCHASE POINTS
[ ] User can add points package to cart
[ ] Cart shows correct price
[ ] Cart shows correct points amount
[ ] Cannot mix products with points
[ ] Payment process works
[ ] Order is created
[ ] Cart items are linked to order
[ ] User's points balance increased
[ ] Dashboard shows purchase in "Points Purchased" tab

STEP 2: REDEEM POINTS
[ ] User can add product to cart
[ ] Cannot mix with points
[ ] Cart shows correct points cost
[ ] Checkout page shows "Redeem Points" button
[ ] Validation checks points balance
[ ] Shows error if insufficient points
[ ] Points are deducted from balance
[ ] Order is created
[ ] Cart items are linked to order
[ ] Dashboard shows redemption in "Points Redeemed" tab
[ ] User's points balance decreased
[ ] Email confirmation sent

STEP 3: DASHBOARD
[ ] Available Points shows correct balance
[ ] Total Orders count correct
[ ] Completed Orders count correct
[ ] Points Purchased tab shows only product_id=1000 orders
[ ] Points Redeemed tab shows only product_id<1000 orders
[ ] Empty state message shows when no orders
[ ] Tab switching works smoothly
[ ] User can view order details
```

---

## 🐛 Common Issues & Solutions

### Issue 1: Points Not Increasing After Purchase

**Cause:** Points not being added in OrderController

**Solution:**
```php
// In OrderController::store, after payment succeeds:
foreach($cart_items as $item) {
    if($item->product_id == 1000) {
        User::where('id', auth()->id())
            ->increment('points', $item->points);  // ← ADD THIS
    }
}
```

### Issue 2: Cannot Add Products After Buying Points

**Cause:** Check for product_id 1000 in cart is working, but user session not updated

**Solution:**
```php
// In singleAddToCart, refresh cart data:
$cartp = Cart::where('user_id', $user_id)
             ->where('order_id', null)
             ->pluck('product_id')
             ->latest()  // ← Get latest
             ->first();
```

### Issue 3: Points Not Deducting on Redemption

**Cause:** pointsredeem method not called or decrement not working

**Solution:**
```php
// Verify in pointsredeem:
$result = User::where('id', auth()->id())
              ->decrement('points', $redeempoints);

if(!$result) {
    // Decrement failed, log error
    \Log::error('Points decrement failed for user: ' . auth()->id());
}
```

### Issue 4: Dashboard Shows Wrong Orders

**Cause:** Filter logic checking wrong product_id

**Solution:**
```php
// Points purchased:
$pointsPurchased = $orders->filter(function($order) {
    $cartItem = Cart::where('order_id', $order->id)
                   ->where('product_id', '==', 1000)  // ← Equal 1000
                   ->first();
    return $cartItem !== null;
});

// Points redeemed:
$pointsRedeemed = $orders->filter(function($order) {
    $cartItem = Cart::where('order_id', $order->id)
                   ->where('product_id', '<', 1000)   // ← Less than 1000
                   ->first();
    return $cartItem !== null;
});
```

---

## 📱 Mobile Considerations

### Responsive Cart
```css
/* Mobile */
@media (max-width: 768px) {
    .cart-summary {
        width: 100%;
        margin-top: 20px;
    }
    
    .cart-items {
        display: grid;
        grid-template-columns: 1fr;
    }
}
```

### Touch-Friendly Buttons
```css
.btn-redeem {
    min-height: 48px;
    padding: 16px 24px;
    font-size: 16px;
}
```

---

## 🔄 Production Checklist

Before going live:

- [ ] Payment gateway tested with real test cards
- [ ] All validation checks in place
- [ ] Error messages user-friendly
- [ ] Email templates customized
- [ ] Logging setup for debugging
- [ ] Database backups configured
- [ ] Rate limiting on payment endpoint
- [ ] HTTPS enabled
- [ ] PCI compliance verified
- [ ] User testing completed
- [ ] Documentation updated
- [ ] Monitoring setup

---

## 📞 Support & Troubleshooting

### Enable Debug Logging

```php
// In CartController methods
\Log::info('Points redeem started', [
    'user_id' => auth()->id(),
    'points_to_redeem' => $redeempoints,
    'available_points' => $avpoints
]);
```

### View Logs

```bash
tail -f storage/logs/laravel.log
```

---

**Last Updated:** 2026-05-22
**Status:** Complete Implementation Guide ✅
