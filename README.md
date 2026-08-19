# Askeva WhatsApp Laravel Package

A Laravel package to seamlessly integrate with the AskEva WhatsApp API. This package provides a fluent API client to send various types of WhatsApp messages (Text, Image, Video, Document, Carousel, Authentication) and a built-in webhook receiver to automatically handle and store incoming WhatsApp webhooks.

## Installation

You can install the package via composer (assuming it is published to Packagist or a custom repository):

```bash
composer require askeva/whatsapp
```

### Publish the Configuration

Publish the package configuration file to your application's `config` directory:

```bash
php artisan vendor:publish --tag=askeva-config
```

This will create a `config/askeva.php` file where you can define your API base URL, Token, and Webhook Verify Token.

### Run Migrations

This package includes a database migration to store incoming webhooks. Run the migrations to create the `askeva_webhooks` table:

```bash
php artisan migrate
```

## Configuration

Add the necessary environment variables to your `.env` file:

```env
# Your AskEva API Token (Required)
ASKEVA_TOKEN=your_askeva_api_token

# Your AskEva API Base URL (Optional, defaults to the production endpoint)
ASKEVA_BASE_URL=https://backend.askeva.io/v1/message/send-message

# Your custom webhook verify token (Optional, defaults to ASKEVA_TOKEN if not set)
ASKEVA_WEBHOOK_VERIFY_TOKEN=your_custom_webhook_verify_token
```

## Webhooks

The package automatically registers the following routes to handle WhatsApp webhooks:

- `GET /askeva/webhook` - Used by the Meta/WhatsApp dashboard to verify your webhook URL.
- `POST /askeva/webhook` - Used to receive actual webhook events (messages, status updates).

When configuring your webhook URL in the WhatsApp/Meta dashboard, point it to:
`https://your-domain.com/askeva/webhook`

Incoming payloads are automatically saved to the `askeva_webhooks` database table. You can retrieve them using the provided Eloquent Model:

```php
use Askeva\WhatsApp\Models\AskevaWebhook;

$webhooks = AskevaWebhook::latest()->get();
```

## Usage

You can use the `AskEva` Facade to easily send messages. 

### 1. Send a Text Template
```php
use Askeva\WhatsApp\Facades\AskEva;

AskEva::sendTextTemplate('919876543210', 'hello_world_template', 'en');
```

### 2. Send a Text Template with Variables
```php
AskEva::sendTextWithVariables('919876543210', 'welcome_template', ['John Doe', 'Monday'], 'en');
```

### 3. Send an Image Template with Variables
```php
AskEva::sendImageWithVariables(
    '919876543210', 
    'monthly_report_template', 
    'https://example.com/report-image.jpg', 
    ['John'], 
    'en'
);
```

### 4. Send a Video Template with Variables
```php
AskEva::sendVideoWithVariables(
    '919876543210', 
    'promo_video_template', 
    'https://example.com/promo.mp4', 
    ['50% Discount'], 
    'en'
);
```

### 5. Send a Document Template with Variables
```php
AskEva::sendDocumentWithVariables(
    '919876543210', 
    'invoice_template', 
    'https://example.com/invoice_123.pdf', 
    'Invoice_123.pdf', 
    ['John Doe', '$150.00'], 
    'en'
);
```

### 6. Send an Authentication/OTP Template
```php
AskEva::sendAuthenticationTemplate('919876543210', 'auth_otp_template', '123456', 'en');
```

## License
The MIT License (MIT). Please see License File for more information.
