# Silverstripe preview
Adds a preview options to a Dataobject.

## Installation
Composer is the recommended way of installing SilverStripe modules.
```
composer require gorriecoe/silverstripe-preview
```

## Requirements

- silverstripe/cms ^4.0
- gorriecoe/silverstripe-links ^1.0

## Maintainers

- [Gorrie Coe](https://github.com/gorriecoe)

## Usage
Adding preview to an Object

```yml
MyDataObject:
  extensions:
    - gorriecoe\Preview\Extensions\Previewable
```

Accessing preview data via template
```
<% loop MyDataObjects %>
    $Preview.Title
<% end_loop %>
```
