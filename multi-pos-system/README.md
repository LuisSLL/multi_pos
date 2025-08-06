# Multi POS System

A comprehensive Point of Sale (POS) system built with Laravel and AdminLTE that allows multiple stores to manage their business operations through a modern web interface.

## Features

### 🏪 Multi-Store Management
- Each store owner can register and manage their own store
- Isolated data per store with secure access controls
- Store setup wizard for new registrations
- Store profile management with logo upload

### 🔐 Authentication & Authorization
- **Google OAuth Integration** - Quick sign-up with Google accounts
- **Traditional Email/Password** - Standard authentication method
- **Role-based Access Control** - Store owners, employees, and super admin roles
- **Secure Middleware** - Protected routes with proper authorization

### 📦 Inventory Management
- **Product Management** - Add, edit, delete products with images
- **Category Organization** - Organize products by categories
- **Stock Tracking** - Real-time inventory with low stock alerts
- **Batch Operations** - Manage multiple products efficiently

### 💰 Point of Sale (POS)
- **Modern POS Interface** - Clean, responsive design for quick sales
- **Product Search** - Quick product lookup by name or barcode
- **Shopping Cart** - Add/remove items with quantity adjustments
- **Multiple Payment Methods** - Cash, card, bank transfer, and others
- **Customer Management** - Optional customer assignment to sales
- **Real-time Calculations** - Automatic totals, tax, and change calculation

### 🧾 Sales & Reporting
- **Sales History** - Complete transaction records
- **Receipt Generation** - Print or PDF receipts
- **Analytics Dashboard** - Sales trends, top products, and KPIs
- **Filtering & Search** - Find specific sales by date, customer, or product
- **Export Options** - Generate reports for analysis

### 👥 Customer Management
- **Customer Database** - Store customer information
- **Purchase History** - Track customer buying patterns
- **Contact Management** - Email, phone, and address records

### 🎛️ Admin Panel (Super Admin)
- **Store Monitoring** - View all registered stores
- **Payment Management** - Track subscription payments
- **Store Suspension** - Suspend/activate stores based on payment status
- **System Analytics** - Overall platform statistics

### 🎨 Modern UI/UX
- **AdminLTE Integration** - Professional dashboard interface
- **Bootstrap Framework** - Responsive and mobile-friendly
- **Interactive Components** - Modern JavaScript interactions
- **Chart.js Integration** - Beautiful data visualizations
- **FontAwesome Icons** - Comprehensive icon library

## Technology Stack

- **Backend**: Laravel 11 (PHP 8.4)
- **Frontend**: AdminLTE 3, Bootstrap 5, jQuery
- **Database**: SQLite (easily configurable for MySQL/PostgreSQL)
- **Authentication**: Laravel Socialite (Google OAuth)
- **PDF Generation**: DOMPDF
- **File Storage**: Laravel Storage with public disk
- **Charts**: Chart.js for analytics visualization

## Installation

### Prerequisites
- PHP 8.4 or higher
- Composer
- Node.js and NPM
- SQLite (or MySQL/PostgreSQL)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd multi-pos-system
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure Google OAuth** (Optional but recommended)
   - Go to [Google Cloud Console](https://console.cloud.google.com/)
   - Create a new project or select existing one
   - Enable Google+ API
   - Create OAuth 2.0 credentials
   - Update `.env` file:
   ```
   GOOGLE_CLIENT_ID=your_google_client_id
   GOOGLE_CLIENT_SECRET=your_google_client_secret
   GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
   ```

6. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed --class=SuperAdminSeeder
   ```

7. **Storage Link**
   ```bash
   php artisan storage:link
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

## Default Credentials

### Super Admin
- **Email**: admin@multipos.com
- **Password**: admin123

The super admin can access the admin panel to manage all stores and monitor the system.

## Usage Guide

### For Store Owners

1. **Registration**
   - Register with email/password or Google OAuth
   - Complete store setup form
   - Start adding products and categories

2. **Product Management**
   - Navigate to Products section
   - Create categories first
   - Add products with details, pricing, and stock quantities
   - Upload product images

3. **Making Sales**
   - Go to POS System
   - Search and add products to cart
   - Select customer (optional)
   - Choose payment method
   - Process sale and print receipt

4. **Analytics**
   - View dashboard for daily/monthly sales
   - Check inventory alerts
   - Review sales history
   - Generate reports

### For Super Admin

1. **Store Management**
   - Access admin panel
   - View all registered stores
   - Monitor payment status
   - Suspend/activate stores as needed

2. **System Monitoring**
   - Track overall platform usage
   - Monitor store activities
   - Generate system-wide reports

## API Endpoints

### Public Routes
- `GET /` - Redirect to login
- `GET /login` - Login page
- `GET /register` - Registration page
- `GET /auth/google` - Google OAuth redirect
- `GET /auth/google/callback` - Google OAuth callback

### Protected Routes (Authenticated Users)
- `GET /dashboard` - Main dashboard
- `GET /store/setup` - Store setup form
- `POST /store/setup` - Process store setup

### Store Management Routes
- `GET /store` - View store details
- `GET /store/edit` - Edit store form
- `PUT /store` - Update store details

### Product Management
- `GET /products` - List products
- `POST /products` - Create product
- `GET /products/{id}` - View product
- `PUT /products/{id}` - Update product
- `DELETE /products/{id}` - Delete product

### POS System
- `GET /pos` - POS interface
- `GET /pos/search-products` - Search products (AJAX)
- `POST /pos/process-sale` - Process sale (AJAX)

### Sales & Reports
- `GET /sales` - Sales history
- `GET /sales/{id}` - View sale details
- `GET /sales/{id}/print` - Print receipt
- `GET /sales/{id}/pdf` - Download PDF receipt
- `GET /reports` - Reports dashboard

### Admin Routes (Super Admin Only)
- `GET /admin/dashboard` - Admin dashboard
- `GET /admin/stores` - List all stores
- `POST /admin/stores/{id}/suspend` - Suspend store
- `POST /admin/stores/{id}/activate` - Activate store

## File Structure

```
multi-pos-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/GoogleController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── ProductController.php
│   │   │   ├── PosController.php
│   │   │   ├── StoreController.php
│   │   │   └── Admin/AdminController.php
│   │   ├── Middleware/
│   │   │   ├── CheckStoreAccess.php
│   │   │   └── SuperAdminMiddleware.php
│   │   └── Policies/ProductPolicy.php
│   └── Models/
│       ├── User.php
│       ├── Store.php
│       ├── Product.php
│       ├── Category.php
│       ├── Customer.php
│       ├── Sale.php
│       └── SaleItem.php
├── database/
│   ├── migrations/
│   └── seeders/SuperAdminSeeder.php
├── resources/
│   └── views/
│       ├── layouts/app.blade.php
│       ├── dashboard/
│       ├── store/
│       ├── pos/
│       └── auth/
└── routes/web.php
```

## Security Features

- **CSRF Protection** - All forms protected against CSRF attacks
- **SQL Injection Prevention** - Eloquent ORM with parameter binding
- **XSS Protection** - Blade template escaping
- **Store Isolation** - Users can only access their own store data
- **Role-based Access** - Proper authorization checks
- **File Upload Security** - Image validation and secure storage

## Customization

### Adding New Payment Methods
Edit the payment method enum in the Sale model and update the POS interface dropdown.

### Implementing Tax Calculation
Modify the POS controller's `processSale` method to include tax logic based on your requirements.

### Custom Receipt Templates
Create custom views for receipt printing in `resources/views/sales/` directory.

### Additional Reports
Add new report methods to controllers and create corresponding views.

## Support & Maintenance

### Database Maintenance
- Regular backups recommended
- Monitor disk space for uploaded images
- Archive old sales data as needed

### Performance Optimization
- Enable query caching for production
- Optimize images and assets
- Consider CDN for static assets
- Database indexing for large datasets

### Scaling Considerations
- Move to MySQL/PostgreSQL for larger datasets
- Implement Redis for session management
- Use queue workers for heavy operations
- Consider microservices architecture for enterprise use

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## Changelog

### Version 1.0.0
- Initial release with core POS functionality
- Multi-store support
- Google OAuth integration
- AdminLTE interface
- Product and inventory management
- Sales processing and reporting
- Admin panel for system management

---

**Multi POS System** - Empowering businesses with modern point-of-sale technology.
