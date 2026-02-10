# Juzaweb CMS Blog Module

A comprehensive blog management module for [Juzaweb CMS](https://cms.juzaweb.com). This module provides a full suite of features to manage your blog content, including posts, categories, tags, and comments.

## Features

- **Posts Management**:
    - Create, edit, and delete blog posts with a rich text editor.
    - Multi-language support for global reach.
    - SEO optimization fields (meta title, description, keywords).
    - Thumbnail image management.
    - Tagging system for better content organization.
    - Bulk actions for efficient management.
- **Category Management**:
    - Organize posts into hierarchical categories.
    - Multi-language support for category names and descriptions.
- **Comment Management**:
    - Manage user comments on your blog posts.
    - Moderation tools to delete inappropriate comments.
- **Sitemap Integration**:
    - Automatically adds posts and categories to the sitemap for better SEO.

## Requirements

- PHP ^8.2
- Juzaweb CMS Core

## Installation

You can install the package via composer:

```bash
composer require juzaweb/blog
```

## Configuration

To publish the configuration file, run:

```bash
php artisan vendor:publish --tag=blog-config
```

To publish the views for customization, run:

```bash
php artisan vendor:publish --tag=blog-module-views
```

## Usage

Once installed, the module will automatically register its service provider. You can access the blog management features from the Juzaweb Admin Panel.

1.  Log in to your Juzaweb Admin Panel.
2.  Navigate to the **Blog** menu item in the sidebar.
3.  You will see sub-menus for **Posts**, **Categories**, and **Comments**.

### Managing Posts

- Go to **Blog > Posts**.
- Click **Add New** to create a new post.
- Fill in the title, content, select categories, add tags, and set a thumbnail.
- Click **Save** to publish or save as a draft.

### Managing Categories

- Go to **Blog > Categories**.
- You can add new categories, edit existing ones, or delete them.
- Categories can be nested to create a hierarchy.

### Managing Comments

- Go to **Blog > Comments**.
- You can view all comments made on your posts.
- Use the available actions to delete unwanted comments.

## Testing

To run the tests, use the following command:

```bash
composer test
```

Or directly via PHPUnit:

```bash
vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
