# WP-dayTime
finance-calculator WordPress shortcode

Simple WordPress snippet for rendering content based on day and time.

## Installation

`1.` Copy `daytime.php` inside your theme folder. Ideally, this file will reside
inside a subfolder like: `wp-content/themes/my-theme/components/daytime.php`

`2.` Open your theme's `function.php` and add the following row at the very
bottom of the file:

```php
include_once( 'daytime.php' );
```

or

```php
include_once( 'components/daytime.php' );
```

`3.` Log inside your WP panel and reach your `Appearance` section

`4.` Click on `customize`

`5.` You should now being able to see a DayTime menu from where customize
your dayTime settings

## Usage

In your WordPress page/post you can simply use a shortcode to define the content
you want to show/hide according to the day time/match

```php
[daytime]My business is open right now![/daytime]
[daytime when="close"]Sorry, we're close at this time[/daytime]
```

## Attributes

#### when

type: String

Optional: true

Default: "open"

Description: The content between the shortcode will be shown/hide according to
the theme's dayTime settings.
The only acceptable values are `open` and `close`
