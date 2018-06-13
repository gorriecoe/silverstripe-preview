# Silverstripe preview
Adds preview options to a Dataobject or SiteTree.  Basically provides more advanced options to summary content.

## Installation
Composer is the recommended way of installing SilverStripe modules.
```
composer require gorriecoe/silverstripe-preview
```

## Requirements

- silverstripe/cms ^4.0

## Suggestion

- [silverstripe/silverstripe-action](https://github.com/gorriecoe/silverstripe-action)

## Maintainers

- [Gorrie Coe](https://github.com/gorriecoe)

## Usage
Adding preview to a DataObject

```yml
MyDataObject:
  extensions:
    - gorriecoe\Preview\Extensions\Previewable
```
Note that Previewable automatically extends SiteTree

### Default preview fields
Adding default fields to a DataObject or SiteTree

```yml
SilverStripe\CMS\Model\SiteTree:
  extensions:
    - gorriecoe\Preview\Extensions\PreviewDefaultFields
```
This will add Image, Title, Content and Label fields to a summary tab.

### Defining your own preview data
By default preview data will inherit from the DataObject.  For example `$MyDataObject.Preview.Image` will use `$MyDataObject.Image`.
However if you want the preview image to have fallback options, you can define it in your DataObject with the following static variable define.

```php
class MyDataObject extends DataObject
{
    private static $has_one = [
        'PreviewImage' => Image::class,
        'HeaderImage' => Image::class
    ];

    private static $preview_data = [
        'Image' => [
            'PreviewImage',
            'HeaderImage'
        ]
    ];
}
```
In the example above `$MyDataObject.Preview.Image` will return the Image from `PreviewImage` first, if that doesn't exist then return `HeaderImage` and finally if that doesn't exist then return null.

### Template
Access preview data via template simply change the scope of the data using one of the following methods.
```
<% loop MyDataObjects %>
    <h2>
        {$Preview.Title}
    </h2>
<% end_loop %>
```

```
<% loop MyDataObjects %>
    <% with Preview %>
        <h2>
            {$Title}
        </h2>
    <% end_with %>
<% end_loop %>
```

### Advanced Usage
Check out [silverstripe/silverstripe-action](https://github.com/gorriecoe/silverstripe-action) code for an example of advanced usage.  In it you will see you can prepend additional fallback options from another dataobject.
