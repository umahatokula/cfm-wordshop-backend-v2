
# Wordshop

The Laravel Audio Store is a web application that allows users to browse and purchase audio files. Users can make payments using either a credit/debit card or a PIN. The application integrates a payment gateway to handle the payment transactions securely.

## Features

- Browse and search for audio files
- User registration and authentication
- User profile management
- Add audio files to a shopping cart
- Checkout using a credit/debit card or a PIN
- Integration with a payment gateway for secure transactions

## Requirements

- PHP >= 7.4
- Laravel >= 8.x
- Composer
- MySQL, PostgreSQL, SQLite, or SQL Server

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/umahatokula/cfm-wordshop-backend-v2.git
   ```

2. Navigate to the project directory:

   ```bash
   cd cfm-wordshop-backend-v2
   ```

3. Install the dependencies using Composer:

   ```bash
   composer install
   ```

4. Create a copy of the `.env.example` file and rename it to `.env`:

   ```bash
   cp .env.example .env
   ```

5. Generate a new application key:

   ```bash
   php artisan key:generate
   ```

6. Configure the database connection by modifying the `.env` file:

   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

7. Run the database migrations to create the necessary tables:

   ```bash
   php artisan migrate
   ```

8. Start the development server:

   ```bash
   php artisan serve
   ```

9. Access the application by visiting `http://localhost:8000` in your browser.

## Configuration

To integrate the payment gateway, you'll need to obtain the necessary credentials from the payment gateway provider. Once you have the credentials, follow these steps to configure the application:

1. Open the `.env` file.

2. Update the following variables with your payment gateway credentials:

   ```dotenv
   PAYSTACK_API_SECRET=your_paystack_gateway_api_secret
   ```

3. Save the changes to the `.env` file.

## Payment Gateway Integration

The Wordshop integrates with a payment gateway to handle payment transactions. The payment gateway handles the encryption, security, and processing of card payments.

The necessary endpoints and methods for payment processing can be found in the application's controllers and routes.

## License

This project is not open-source. All rights reserved. Unauthorized copying or distribution of this project or its source code is strictly prohibited.

## Contributing

Contributions to the Laravel Audio Store project are welcome! If you find a bug or want to add a new feature, please submit a pull request. Make sure to follow the coding standards and include relevant tests with your changes.

To contribute, follow these steps:

1. Fork the repository on GitHub.

2. Clone your forked repository to your local machine.

3. Create a new branch for your feature or bug fix.

4. Make the necessary changes and commit them.

5. Push your branch to your forked repository on GitHub.

6. Submit a pull request to the `main` branch of the main repository.

## Support

If you encounter any issues or have any questions or suggestions, please [open an issue](https://github.com/your-username/laravel-audio-store/issues) on GitHub.

## Acknowledgments

The Laravel Audio Store was inspired by the need for a platform to sell audio files securely. We would like to acknowledge the Laravel community for their amazing work and the payment gateway provider for their integration support.
