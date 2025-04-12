# Laravel Filament Password Manager

Laravel Filament Password Manager is a secure, user-friendly application for storing and managing passwords. Built with Laravel and Filament, it provides an elegant interface for organizing passwords by domains and record types with robust security features.

![Screenshot: Domains](/public/images/screenshots/domains.png?raw=true)

![Screenshot: Records](/public/images/screenshots/records.png?raw=true)

![Screenshot: Record Types](/public/images/screenshots/records_type.png?raw=true)

## About

This application provides a secure way to store and manage passwords with the following features:

* **Domain Organization**: Group passwords by domains (websites, applications, etc.)
* **Record Types**: Categorize passwords by custom types (e.g., personal, work, financial)
* **Secure Storage**: All passwords are encrypted using Laravel's Crypt facade
* **User-Specific Data**: Each user can only access their own domains and passwords
* **Password Generation**: Built-in secure password generator
* **Copy to Clipboard**: Easily copy usernames and passwords without revealing them
* **Responsive Interface**: Built with Filament for a clean, modern UI that works on all devices

The application is ideal for:

* Individuals wanting to securely store personal passwords
* Small teams needing to share access credentials
* Developers managing multiple client credentials
* Anyone looking for a self-hosted password management solution

## Requirements

* PHP >= 8.2
* PHP extensions:
    * pdo
    * zip
    * mysqli
    * curl
    * mbstring
    * intl
* MySQL Server 8 OR MariaDB 10
* Apache >= 2.4
* Composer
* NPM

## Installation

### From a ZIP file

* Download .zip file from GitHub
* Unzip it to a folder of your choice

### From a GIT repository

* Open terminal and navigate to the folder where you want the application to be installed
* Run command `git clone https://github.com/milenmk/Laravel-Filament-Password-Manager.git`
* Using your terminal, navigate to the folder of the app
* Rename .env.example to .env
* Fill the database data (server, port, database, user and password)
* Change the `APP_URL` to the actual value
* Optional: change the `APP_NAME`

Create your database and database user with the credentials specified in the .env file. Then run following commands:

```
php artisan key:generate
composer install
npm install
php artisan migrate
```

After completing the above setup, you can start the application with:

```
php artisan serve
```

The application should now be accessible at http://localhost:8000

### Alternative Installation

You can use [Laragon](https://laragon.org/download/), an application similar to XAMPP but more powerful, for a simpler setup experience.

## Usage

### Basic Usage

#### Managing Domains

Domains represent websites, applications, or services where you have accounts. To add a new domain:

1. Navigate to the "Domains" section in the sidebar
2. Click the "New Domain" button
3. Enter the domain name (e.g., "Google", "GitHub", "Netflix")
4. Click "Create" to save the domain

#### Managing Record Types

Record types help you categorize your passwords. To add a new record type:

1. Navigate to the "Record Types" section in the sidebar
2. Click the "New Record Type" button
3. Enter the record type name (e.g., "Personal", "Work", "Financial")
4. Click "Create" to save the record type

#### Adding Password Records

To add a new password record:

1. Navigate to the "Records" section in the sidebar or click on a specific domain
2. Click the "New Record" button
3. Fill in the form:
    * Select a record type
    * Enter the URL
    * Enter the username
    * Enter the password (or use the "Generate" button for a secure random password)
    * Select the domain
4. Click "Create" to save the record

#### Viewing and Using Password Records

To view and use your stored passwords:

1. Navigate to the "Records" section or a specific domain
2. Your records will be displayed in a table with the following information:
    * Record Type
    * URL (clickable to open the website)
    * Username (with copy button)
    * Password (with copy button)
    * Domain

### Advanced Usage

#### Password Generation

When creating or editing a record, you can generate a secure random password:

1. Click in the password field
2. Click the "Generate" button that appears
3. A 16-character secure password will be generated automatically

#### Password Security

All passwords are encrypted in the database using Laravel's Crypt facade, ensuring that even if your database is compromised, your passwords remain secure.

#### User-Specific Data

The application implements a user scope, ensuring that each user can only see and manage their own domains, record types, and password records.

## Data Models

### Domain Model

The Domain model represents websites or services where you have accounts:

```php
class Domain extends Model
{
    use HasFactory;
    use UserTrait;

    protected $fillable = [
        'name',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function records(): HasMany
    {
        return $this->hasMany(Record::class)->with('domain');
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'date',
            'updated_at' => 'date',
        ];
    }
}
```

### Record Model

The Record model stores the actual password entries:

```php
class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_type_id',
        'url',
        'username',
        'password',
        'domain_id',
    ];

    public function recordType(): BelongsTo
    {
        return $this->belongsTo(RecordType::class);
    }

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'date',
            'updated_at' => 'date',
        ];
    }
}
```

### RecordType Model

The RecordType model allows for categorization of password records:

```php
class RecordType extends Model
{
    use HasFactory;
    use UserTrait;

    protected $fillable = [
        'name',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'date',
            'updated_at' => 'date',
        ];
    }
}
```

## Security Considerations

### Password Encryption

All passwords are encrypted in the database using Laravel's Crypt facade:

```php
// When displaying a password
TextColumn::make('password')
    ->copyable()
    ->icon('heroicon-s-document-duplicate')
    ->formatStateUsing(fn (string $state): string => Crypt::decryptString($state)),

// When saving a password
TextInput::make('password')
    ->required()
    ->formatStateUsing(function ($state) {
        if ($state) {
            return Crypt::decryptString($state);
        }
        return null;
    })
    ->dehydrateStateUsing(fn ($state) => Crypt::encryptString($state))
    ->dehydrated(fn ($state) => filled($state)),
```

### User Scope

The application implements a user scope to ensure that users can only access their own data:

```php
#[ScopedBy(UserScope::class)]
class Domain extends Model
{
    use UserTrait;
    // ...
}
```

### Best Practices

1. **Use HTTPS**: Always configure your server to use HTTPS to encrypt data in transit
2. **Regular Backups**: Implement regular database backups to prevent data loss
3. **Update Regularly**: Keep the application and its dependencies up to date
4. **Strong Master Password**: Use a strong password for your application account
5. **Limited Access**: Restrict server access to authorized personnel only

## Disclaimer

This software and its code are provided AS IS. Do not use it if you don't know what you are doing. The author(s) assumes no responsibility or liability for any errors or omissions. It is NOT recommended to use it on a publicly accessible server!

ALL CONTENT IS "AS IS" AND "AS AVAILABLE" BASIS WITHOUT ANY REPRESENTATIONS OR WARRANTIES OF ANY KIND INCLUDING THE WARRANTIES OF MERCHANTABILITY, EXPRESS OR IMPLIED TO THE FULL EXTENT PERMISSIBLE BY LAW. THE AUTHORS MAKE NO WARRANTIES THAT THE SOFTWARE WILL PERFORM OR OPERATE TO MEET YOUR REQUIREMENTS OR THAT THE FEATURES PRESENTED WILL BE COMPLETE, CURRENT OR ERROR-FREE.

## License

This software is released under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version (GPL-3+).
