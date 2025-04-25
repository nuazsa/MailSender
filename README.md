# MailSender

MailSender is a custom framework-based project designed to simplify the process of sending emails programmatically. It provides a streamlined interface for configuring email settings and sending messages using its built-in mail functionality.

## Features

- Easy configuration of SMTP settings.
- Support for sending plain text and HTML emails.
- Attachment support.
- Error handling and logging.

## Requirements

- PHP (version 8.0 or higher)
- Composer

## Installation

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd MailSender
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Create a `.env` file**:
   Copy the example `.env` file and configure it:
   ```bash
   cp .env.example .env
   ```

4. **Configure mail settings**:
   Update the following variables in the `.env` file:
   ```
   MAIL_HOST=<your-smtp-host>
   MAIL_PORT=<your-smtp-port>
   MAIL_USERNAME=<your-smtp-username>
   MAIL_PASSWORD=<your-smtp-password>
   MAIL_ENCRYPTION=<tls/ssl>
   MAIL_FROM_ADDRESS=<your-email-address>
   MAIL_FROM_NAME="MailSender"
   ```

5. **Run migrations** (if applicable):
   ```bash
   php mailsender migrate
   ```

6. **Start the development server**:
   ```bash
   php -S localhost:8000 -t public_html
   ```

## Usage

1. **Send an email**:
   Use the framework's built-in mail functionality:
   ```php
   use MailSender\Mail;

   Mail::send([
       'to' => 'recipient@example.com',
       'subject' => 'Test Email',
       'body' => 'This is a test email.',
       'html' => '<p>This is a test email.</p>',
   ]);
   ```

2. **Advanced use case**:
   Create a custom mail template and pass it to the `Mail` class.

## Example

Here is an example of sending an email with a custom template:
```php
use MailSender\Mail;

$template = '<h1>Hello, {{name}}</h1><p>This is a test email.</p>';
$data = ['name' => 'John Doe'];

Mail::send([
    'to' => 'recipient@example.com',
    'subject' => 'Personalized Email',
    'body' => strtr($template, $data),
]);
```

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request.

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.