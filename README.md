# Juzaweb CMS Notification Module

This package provides notification management functionality with support for registering and managing different recipient types and notification channels.

## Features

- Singleton `NotificationManager` service for managing recipient types and notification channels
- Facade for easy access
- Register custom recipient types and channels with callback pattern
- Query registered recipient types and channels

## Installation

The package is auto-registered via Laravel's service provider discovery.

## Usage

### Registering Notification Channels

You can register notification channels in your service provider's `boot()` method:

```php
use Juzaweb\Modules\Notification\Facades\Notification;
use Juzaweb\Modules\Notification\Channels\EmailChannel;

// Register using a class
Notification::registerChannel('email', fn() => new EmailChannel());

// Or register using anonymous class
Notification::registerChannel('sms', function () {
    return new class implements NotificationChannelInterface {
        public function getLabel(): string {
            return 'SMS';
        }

        public function getDescription(): ?string {
            return 'Send notifications via SMS';
        }

        public function toArray(): array {
            return [
                'label' => $this->getLabel(),
                'description' => $this->getDescription(),
            ];
        }
    };
});
```

### Registering Recipient Types

You can register recipient types in your service provider's `boot()` method:

```php
use Juzaweb\Modules\Notification\Facades\Notification;

// Register recipient types with callback pattern
Notification::registerRecipientType('all_users', function () {
    return new class implements RecipientTypeInterface {
        public function getLabel(): string {
            return 'All Users';
        }

        public function getDescription(): ?string {
            return 'Send to all registered users';
        }

        public function toArray(): array {
            return [
                'label' => $this->getLabel(),
                'description' => $this->getDescription(),
            ];
        }
    };
});

Notification::registerRecipientType('premium_users', function () {
    return new class implements RecipientTypeInterface {
        public function getLabel(): string {
            return 'Premium Users';
        }

        public function getDescription(): ?string {
            return 'Send to users with premium subscription';
        }

        public function toArray(): array {
            return [
                'label' => $this->getLabel(),
                'description' => $this->getDescription(),
            ];
        }
    };
});
```

### Creating Custom Recipient Types

You can create your own custom recipient type classes by implementing `RecipientTypeInterface`:

```php
use Juzaweb\Modules\Notification\Contracts\RecipientTypeInterface;

class PremiumUsersRecipientType implements RecipientTypeInterface
{
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
Notification::registerRecipientType('premium_users', fn() => new PremiumUsersRecipientType());
```

### Creating Custom Notification Channels

Create notification channels by implementing `NotificationChannelInterface`:

```php
use Juzaweb\Modules\Notification\Contracts\NotificationChannelInterface;

class PushNotificationChannel implements NotificationChannelInterface
{
    public function getLabel(): string
    {
        return __('Push Notification');
    }

    public function getDescription(): ?string
    {
        return __('Send push notifications to mobile devices');
    }

    public function toArray(): array
    {
        return [
            'label' => $this->getLabel(),
            'description' => $this->getDescription(),
        ];
    }
}

// Register the custom channel
Notification::registerChannel('push', fn() => new PushNotificationChannel());
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
        'label' => 'All Users',
        'description' => 'Send to all registered users'
    ],
    'premium_users' => [
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

### Getting Notification Channels

```php
use Juzaweb\Modules\Notification\Facades\Notification;

// Get all registered channels (as objects)
$channels = Notification::getChannels();

// Get all registered channels as arrays
$channelsArray = Notification::getChannelsArray();
/*
Returns:
[
    'email' => [
        'label' => 'Email',
        'description' => 'Send notifications via email'
    ],
    'sms' => [
        'label' => 'SMS',
        'description' => 'Send notifications via SMS'
    ],
    // ...
]
*/

// Check if a channel exists
if (Notification::hasChannel('email')) {
    // Channel exists
}
```

### Using in Views

In your controller:

```php
use Juzaweb\Modules\Notification\Facades\Notification;

public function create()
{
    // Get as array for easier use in views
    $recipientTypes = Notification::getRecipientTypesArray();
    $channels = Notification::getChannelsArray();

    return view('notification::create', compact('recipientTypes', 'channels'));
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

<select name="channels[]" class="form-control" multiple>
    @foreach($channels as $key => $channel)
        <option value="{{ $key }}">
            {{ $channel['label'] }}
            @if(!empty($channel['description']))
                - {{ $channel['description'] }}
            @endif
        </option>
    @endforeach
</select>
```

## API Reference

### NotificationManager Methods

#### `registerRecipientType(string $key, callable $callback): self`

Register a new recipient type.

**Parameters:**

- `$key` - The unique key for the recipient type
- `$callback` - Callback that returns a `RecipientTypeInterface` instance

**Returns:** `self` for method chaining

**Example:**

```php
Notification::registerRecipientType('all_users', fn() => new AllUsersRecipientType());
```

---

#### `registerChannel(string $key, callable $callback): self`

Register a new notification channel.

**Parameters:**

- `$key` - The unique key for the channel
- `$callback` - Callback that returns a `NotificationChannelInterface` instance

**Returns:** `self` for method chaining

**Example:**

```php
Notification::registerChannel('email', fn() => new EmailChannel());
```

---

#### `getRecipientTypes(): array<string, RecipientTypeInterface>`

Get all registered recipient types as objects.

**Returns:** Array of `RecipientTypeInterface` objects indexed by key

---

#### `getRecipientTypesArray(): array<string, array>`

Get all registered recipient types as arrays (useful for views).

**Returns:** Array of arrays with `label` and `description` for each type

---

#### `getRecipientType(string $key): ?RecipientTypeInterface`

Get a specific recipient type by key.

**Parameters:**

- `$key` - The recipient type key

**Returns:** `RecipientTypeInterface` object or `null` if not found

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

#### `getChannels(): array<string, NotificationChannelInterface>`

Get all registered channels as objects.

**Returns:** Array of `NotificationChannelInterface` objects indexed by key

---

#### `getChannelsArray(): array<string, array>`

Get all registered channels as arrays (useful for views).

**Returns:** Array of arrays with `label` and `description` for each channel

---

#### `hasChannel(string $key): bool`

Check if a channel is registered.

**Parameters:**

- `$key` - The channel key

**Returns:** `true` if exists, `false` otherwise

---

#### `unregisterChannel(string $key): self`

Remove a channel.

**Parameters:**

- `$key` - The channel key to remove

**Returns:** `self` for method chaining

---

### RecipientTypeInterface

Interface that all recipient type classes must implement.

#### `getLabel(): string`

Get the display label for the recipient type.

---

#### `getDescription(): ?string`

Get the description for the recipient type (optional).

---

#### `toArray(): array`

Convert the recipient type to an array representation.

**Returns:** Array with `label` and `description` keys

---

### NotificationChannelInterface

Interface that all notification channel classes must implement.

#### `getLabel(): string`

Get the display label for the notification channel.

---

#### `getDescription(): ?string`

Get the description for the notification channel (optional).

---

#### `toArray(): array`

Convert the notification channel to an array representation.

**Returns:** Array with `label` and `description` keys

## License

Same as the main application license.
