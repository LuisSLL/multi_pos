@extends('layouts.app')

@section('title', 'Point of Sale')

@section('breadcrumb')
<li class="breadcrumb-item active">POS</li>
@endsection

@section('content')
<div class="row">
    <!-- Product Search and Categories -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-search mr-1"></i>
                    Product Search
                </h3>
            </div>
            <div class="card-body">
                <!-- Search Bar -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <input type="text" id="product-search" class="form-control" 
                               placeholder="Search products by name or code...">
                    </div>
                    <div class="col-md-4">
                        <select id="category-filter" class="form-control">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Products Grid -->
                <div id="products-grid" class="row">
                    <div class="col-12 text-center">
                        <p class="text-muted">Search for products to display here</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shopping Cart -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-shopping-cart mr-1"></i>
                    Shopping Cart
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-sm btn-outline-danger" id="clear-cart">
                        <i class="fas fa-trash"></i> Clear
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Customer Selection -->
                <div class="form-group">
                    <label for="customer-select">Customer (Optional)</label>
                    <select id="customer-select" class="form-control">
                        <option value="">Walk-in Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Cart Items -->
                <div id="cart-items" class="mb-3">
                    <div class="text-center text-muted">
                        <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                        <p>Cart is empty</p>
                    </div>
                </div>

                <!-- Cart Totals -->
                <div id="cart-totals" class="border-top pt-3" style="display: none;">
                    <div class="d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <span id="subtotal">$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Tax:</span>
                        <span id="tax">$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Discount:</span>
                        <span id="discount">$0.00</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between h5">
                        <strong>Total:</strong>
                        <strong id="total">$0.00</strong>
                    </div>
                </div>

                <!-- Payment Section -->
                <div id="payment-section" style="display: none;">
                    <hr>
                    <div class="form-group">
                        <label for="payment-method">Payment Method</label>
                        <select id="payment-method" class="form-control" required>
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="transfer">Bank Transfer</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="paid-amount">Amount Paid</label>
                        <input type="number" id="paid-amount" class="form-control" 
                               step="0.01" min="0" placeholder="0.00" required>
                    </div>
                    <div class="form-group">
                        <label for="sale-notes">Notes (Optional)</label>
                        <textarea id="sale-notes" class="form-control" rows="2" 
                                placeholder="Additional notes..."></textarea>
                    </div>
                    <div id="change-amount" class="alert alert-info" style="display: none;">
                        <strong>Change: $<span id="change-value">0.00</span></strong>
                    </div>
                    <button type="button" id="process-sale" class="btn btn-success btn-block btn-lg">
                        <i class="fas fa-credit-card"></i> Process Sale
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sale Complete Modal -->
<div class="modal fade" id="sale-complete-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h4 class="modal-title text-white">
                    <i class="fas fa-check-circle"></i> Sale Completed!
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h5>Invoice #: <span id="modal-invoice-number"></span></h5>
                <p>Total Amount: $<span id="modal-total-amount"></span></p>
                <p>Change: $<span id="modal-change-amount"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="print-receipt" class="btn btn-primary">
                    <i class="fas fa-print"></i> Print Receipt
                </button>
                <button type="button" id="new-sale" class="btn btn-success">
                    <i class="fas fa-plus"></i> New Sale
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let cart = [];
let products = [];

$(document).ready(function() {
    // Search products
    $('#product-search, #category-filter').on('input change', searchProducts);
    
    // Clear cart
    $('#clear-cart').click(clearCart);
    
    // Calculate change
    $('#paid-amount').on('input', calculateChange);
    
    // Process sale
    $('#process-sale').click(processSale);
    
    // Modal actions
    $('#new-sale').click(function() {
        location.reload();
    });
    
    $('#print-receipt').click(function() {
        const saleId = $(this).data('sale-id');
        window.open(`/sales/${saleId}/print`, '_blank');
    });
});

function searchProducts() {
    const search = $('#product-search').val();
    const categoryId = $('#category-filter').val();
    
    if (search.length < 2 && !categoryId) {
        $('#products-grid').html('<div class="col-12 text-center"><p class="text-muted">Search for products to display here</p></div>');
        return;
    }
    
    $.ajax({
        url: '{{ route("pos.search-products") }}',
        method: 'GET',
        data: { search, category_id: categoryId },
        success: function(data) {
            products = data;
            displayProducts(data);
        }
    });
}

function displayProducts(products) {
    const grid = $('#products-grid');
    grid.empty();
    
    if (products.length === 0) {
        grid.html('<div class="col-12 text-center"><p class="text-muted">No products found</p></div>');
        return;
    }
    
    products.forEach(product => {
        const productCard = `
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card product-card h-100" data-product-id="${product.id}" style="cursor: pointer;">
                    <div class="card-body text-center">
                        <h6 class="card-title">${product.name}</h6>
                        <p class="card-text">
                            <small class="text-muted">${product.category.name}</small><br>
                            <strong>$${parseFloat(product.selling_price).toFixed(2)}</strong><br>
                            <small>Stock: ${product.stock_quantity}</small>
                        </p>
                    </div>
                </div>
            </div>
        `;
        grid.append(productCard);
    });
    
    // Add click event to product cards
    $('.product-card').click(function() {
        const productId = $(this).data('product-id');
        const product = products.find(p => p.id === productId);
        addToCart(product);
    });
}

function addToCart(product) {
    const existingItem = cart.find(item => item.product_id === product.id);
    
    if (existingItem) {
        if (existingItem.quantity < product.stock_quantity) {
            existingItem.quantity++;
        } else {
            alert('Insufficient stock!');
            return;
        }
    } else {
        cart.push({
            product_id: product.id,
            name: product.name,
            price: parseFloat(product.selling_price),
            quantity: 1,
            stock: product.stock_quantity
        });
    }
    
    updateCartDisplay();
}

function removeFromCart(productId) {
    cart = cart.filter(item => item.product_id !== productId);
    updateCartDisplay();
}

function updateQuantity(productId, change) {
    const item = cart.find(item => item.product_id === productId);
    if (item) {
        const newQuantity = item.quantity + change;
        if (newQuantity <= 0) {
            removeFromCart(productId);
        } else if (newQuantity <= item.stock) {
            item.quantity = newQuantity;
            updateCartDisplay();
        } else {
            alert('Insufficient stock!');
        }
    }
}

function updateCartDisplay() {
    const cartContainer = $('#cart-items');
    const totalsContainer = $('#cart-totals');
    const paymentSection = $('#payment-section');
    
    if (cart.length === 0) {
        cartContainer.html(`
            <div class="text-center text-muted">
                <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                <p>Cart is empty</p>
            </div>
        `);
        totalsContainer.hide();
        paymentSection.hide();
        return;
    }
    
    let html = '';
    let subtotal = 0;
    
    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;
        
        html += `
            <div class="cart-item border-bottom pb-2 mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>${item.name}</strong><br>
                        <small>$${item.price.toFixed(2)} each</small>
                    </div>
                    <div class="text-right">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary" onclick="updateQuantity(${item.product_id}, -1)">-</button>
                            <button class="btn btn-outline-secondary">${item.quantity}</button>
                            <button class="btn btn-outline-secondary" onclick="updateQuantity(${item.product_id}, 1)">+</button>
                        </div>
                        <br>
                        <strong>$${itemTotal.toFixed(2)}</strong>
                        <button class="btn btn-sm btn-outline-danger ml-2" onclick="removeFromCart(${item.product_id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
    
    cartContainer.html(html);
    
    const tax = 0; // You can add tax calculation here
    const discount = 0; // You can add discount logic here
    const total = subtotal + tax - discount;
    
    $('#subtotal').text(`$${subtotal.toFixed(2)}`);
    $('#tax').text(`$${tax.toFixed(2)}`);
    $('#discount').text(`$${discount.toFixed(2)}`);
    $('#total').text(`$${total.toFixed(2)}`);
    
    totalsContainer.show();
    paymentSection.show();
    
    calculateChange();
}

function calculateChange() {
    const total = parseFloat($('#total').text().replace('$', ''));
    const paid = parseFloat($('#paid-amount').val()) || 0;
    const change = Math.max(0, paid - total);
    
    $('#change-value').text(change.toFixed(2));
    
    if (paid > 0 && change >= 0) {
        $('#change-amount').show();
    } else {
        $('#change-amount').hide();
    }
}

function clearCart() {
    if (cart.length > 0 && confirm('Are you sure you want to clear the cart?')) {
        cart = [];
        updateCartDisplay();
    }
}

function processSale() {
    if (cart.length === 0) {
        alert('Cart is empty!');
        return;
    }
    
    const total = parseFloat($('#total').text().replace('$', ''));
    const paidAmount = parseFloat($('#paid-amount').val()) || 0;
    
    if (paidAmount < total) {
        alert('Paid amount is insufficient!');
        return;
    }
    
    const saleData = {
        items: cart,
        customer_id: $('#customer-select').val() || null,
        payment_method: $('#payment-method').val(),
        paid_amount: paidAmount,
        notes: $('#sale-notes').val()
    };
    
    $('#process-sale').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
    
    $.ajax({
        url: '{{ route("pos.process-sale") }}',
        method: 'POST',
        data: saleData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                $('#modal-invoice-number').text(response.invoice_number);
                $('#modal-total-amount').text(response.total_amount.toFixed(2));
                $('#modal-change-amount').text(response.change_amount.toFixed(2));
                $('#print-receipt').data('sale-id', response.sale_id);
                $('#sale-complete-modal').modal('show');
            }
        },
        error: function(xhr) {
            const response = xhr.responseJSON;
            alert(response.message || 'An error occurred while processing the sale.');
        },
        complete: function() {
            $('#process-sale').prop('disabled', false).html('<i class="fas fa-credit-card"></i> Process Sale');
        }
    });
}
</script>
@endpush

@push('styles')
<style>
.product-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: all 0.2s;
}

.cart-item {
    font-size: 0.9em;
}

.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>
@endpush