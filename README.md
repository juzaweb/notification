# Juzaweb CMS Notification Module

This package provides notification management functionality with support for registering and managing different recipient types.

## Features

- Singleton `NotificationManager` service for managing recipient types
- Facade for easy access
- Register custom recipient types with labels and descriptions
- Query registered recipient types

## Installation

The package is auto-registered via Laravel's service provider discovery.

## Usage

### Registering Recipient Types

You can register recipient types in your service provider's `boot()` method or anywhere in your bootstrap code:

```php
use Juzaweb\Modules\Notification\Facades\Notification;
use Juzaweb\Modules\Notification\RecipientTypes\RecipientType;

// Register a recipient type using the default RecipientType class
Notification::registerRecipientType(
    new RecipientType('all_users', 'All Users', 'Send to all registered users')
);

Notification::registerRecipientType(
    new RecipientType('premium_users', 'Premium Users', 'Send to users with premium subscription')
);

Notification::registerRecipientType(
    new RecipientType('specific_user', 'Specific User', 'Send to a specific user by ID')
);

Notification::registerRecipientType(
    new RecipientType('user_group', 'User Group', 'Send to a group of users')
);
```

### Creating Custom Recipient Types

You can create your own custom recipient type classes by implementing `RecipientTypeInterface`:

```php
use Juzaweb\Modules\Notification\Contracts\RecipientTypeInterface;

class PremiumUsersRecipientType implements RecipientTypeInterface
{
    public function getKey(): string
    {
        return 'premium_users';
    }

    public function getLabel(): string
    {
        return __('Premium Users');
    }

    public function getDescription(): ?string
    {
        return __('Send to users with active premium subscription');
    }

    public function toArray(): array
    {
        return [
            'key' => $this->getKey(),
            'label' => $this->getLabel(),
            'description' => $this->getDescription(),
        ];
    }

    // You can add custom methods
    public function getRecipients(): array
    {
        // Custom logic to get recipients
        return User::where('is_premium', true)->get();
    }
}

// Register the custom type
Notification::registerRecipientType(new PremiumUsersRecipientType());
```

### Getting Recipient Types

```php
use Juzaweb\Modules\Notification\Facades\Notification;

// Get all registered recipient types (as objects)
$recipientTypes = Notification::getRecipientTypes();
/*
Returns array of RecipientTypeInterface objects:
[
    'all_users' => RecipientType object,
    'premium_users' => PremiumUsersRecipientType object,
    // ...
]
*/

// Get all registered recipient types as arrays
$recipientTypesArray = Notification::getRecipientTypesArray();
/*
Returns:
[
    'all_users' => [
        'key' => 'all_users',
        'label' => 'All Users',
        'description' => 'Send to all registered users'
    ],
    'premium_users' => [
        'key' => 'premium_users',
        'label' => 'Premium Users',
        'description' => 'Send to users with premium subscription'
    ],
    // ...
]
*/

// Get a specific recipient type (as object)
$type = Notification::getRecipientType('all_users');
// Returns RecipientTypeInterface object or null

// Access properties
if ($type) {
    echo $type->getLabel(); // "All Users"
    echo $type->getDescription(); // "Send to all registered users"
}
```

### Checking Recipient Type Existence

```php
use Juzaweb\Modules\Notification\Facades\Notification;

if (Notification::hasRecipientType('all_users')) {
    // Recipient type exists
}
```

### Removing Recipient Types

```php
use Juzaweb\Modules\Notification\Facades\Notification;

// Unregister a recipient type
Notification::unregisterRecipientType('specific_user');
```

### Using in Views

In your controller:

```php
use Juzaweb\Modules\Notification\Facades\Notification;

public function create()
{
    // Get as array for easier use in views
    $recipientTypes = Notification::getRecipientTypesArray();

    return view('notification::create', compact('recipientTypes'));
}
```

In your Blade view:

```blade
<select name="recipient_type" class="form-control">
    @foreach($recipientTypes as $key => $type)
        <option value="{{ $key }}">
            {{ $type['label'] }}
            @if(!empty($type['description']))
                - {{ $type['description'] }}
            @endif
        </option>
    @endforeach
</select>
```

## API Reference

### NotificationManager Methods

#### `registerRecipientType(RecipientTypeInterface $recipientType): self`

Register a new recipient type.

**Parameters:**

- `$recipientType` - An instance implementing `RecipientTypeInterface`

**Returns:** `self` for method chaining

**Example:**

```php
use Juzaweb\Modules\Notification\RecipientTypes\RecipientType;

Notification::registerRecipientType(
    new RecipientType('all_users', 'All Users', 'Send to all users')
);
```

---

#### `getRecipientTypes(): array<string, RecipientTypeInterface>`

Get all registered recipient types as objects.

**Returns:** Array of `RecipientTypeInterface` objects indexed by key

**Example:**

```php
$types = Notification::getRecipientTypes();
foreach ($types as $key => $type) {
    echo $type->getLabel();
}
```

---

#### `getRecipientTypesArray(): array<string, array>`

Get all registered recipient types as arrays (useful for views).

**Returns:** Array of arrays with `key`, `label`, and `description` for each type

**Example:**

```php
$typesArray = Notification::getRecipientTypesArray();
/*
[
    'all_users' => [
        'key' => 'all_users',
        'label' => 'All Users',
        'description' => 'Send to all users'
    ]
]
*/
```

---

#### `getRecipientType(string $key): ?RecipientTypeInterface`

Get a specific recipient type by key.

**Parameters:**

- `$key` - The recipient type key

**Returns:** `RecipientTypeInterface` object or `null` if not found

**Example:**

```php
$type = Notification::getRecipientType('all_users');
if ($type) {
    echo $type->getLabel();
}
```

---

#### `hasRecipientType(string $key): bool`

Check if a recipient type is registered.

**Parameters:**

- `$key` - The recipient type key

**Returns:** `true` if exists, `false` otherwise

---

#### `unregisterRecipientType(string $key): self`

Remove a recipient type.

**Parameters:**

- `$key` - The recipient type key to remove

**Returns:** `self` for method chaining

---

### RecipientTypeInterface

Interface that all recipient type classes must implement.

#### `getKey(): string`

Get the unique key for the recipient type.

---

#### `getLabel(): string`

Get the display label for the recipient type.

---

#### `getDescription(): ?string`

Get the description for the recipient type (optional).

---

#### `toArray(): array`

Convert the recipient type to an array representation.

**Returns:** Array with `key`, `label`, and `description` keys

## License

Same as the main application license.
