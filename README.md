# laravel-form-builder

A library for building & rendering forms in Laravel.

We originally developed this library for our internal systems which are based off of
[Bootstrap 4](https://getbootstrap.com) and [CoreUI](https://coreui.io/).  We've tried
to *not be too opinionated about markup*; however the library does generate
markup with Bootstrap 4 classes in mind.

If you're not using Bootstrap 4, or are using an older version, you'll need to add compatible CSS
classes to handle the styling of components.

*This library is in early release and is pending unit tests.*

## Table of Contents

* [Installation](#installation)
* [Creating a Form](#creating-a-form)
* [Filling a Form](#filling-a-form)
* [Form Validation](#form-validation)
    * [Controller Validation](#controller-validation)
    * [Form Request Validation](#form-request-validation)
* [Components](#components)
    * [Checkbox (Single)](#checkbox-single)
    * [Checkboxes (Multiple)](#checkboxes-multiple)
    * [DateInput](#dateinput)
    * [EmailInput](#emailinput)
    * [FieldSet](#fieldset)
    * [HiddenInput](#hiddeninput)
    * [MobileNumberInput](#mobilenumberinput)
    * [NumberInput](#numberinput)
    * [PasswordInput](#passwordinput)
    * [PhoneNumberInput](#phonenumberinput)
    * [RadioButtonGroup](#radiobuttongroup)
    * [RichTextEditor](#richtextarea)
    * [Row](#row)
    * [Select](#select)
    * [TextArea](#textarea)
    * [TextInput](#textinput)
    * [TimePicker](#timepicker)
    * [ToggleSwitch](#toggleswitch)

## Installation

```bash
composer require balfour/laravel-form-builder
```

## Creating a Form

You can either create your form on the fly by constructing a `Form`, or you can create
a custom class such as `CreateUserForm` which builds the components in the class constructor.

```php
namespace App\Forms;

use App\Models\Role;
use Balfour\LaravelFormBuilder\Form;
use Balfour\LaravelFormBuilder\Components\Checkboxes;
use Balfour\LaravelFormBuilder\Components\EmailInput;
use Balfour\LaravelFormBuilder\Components\MobileNumberInput;
use Balfour\LaravelFormBuilder\Components\NumberInput;
use Balfour\LaravelFormBuilder\Components\PhoneNumberInput;
use Balfour\LaravelFormBuilder\Components\Row;
use Balfour\LaravelFormBuilder\Components\TextInput;

class CreateUserForm extends Form
{
    public function __construct()
    {
        $this->route('post.create_user')
            ->button('Create')
            ->with([
                TextInput::build()
                    ->name('first_name')
                    ->required(),
                TextInput::build()
                    ->name('last_name')
                    ->required(),
                EmailInput::build()
                    ->required()
                    ->rule('unique:users'),
                Row::build()
                    ->with([
                        MobileNumberInput::build()
                            ->rule('unique:users'),
                        PhoneNumberInput::build()
                            ->name('office_number')
                            ->rule('unique:users'),
                    ]),
                Row::build()
                    ->with([
                        NumberInput::build()
                            ->name('phone_extension')
                            ->rule('unique:users'),
                        TextInput::build()
                            ->name('skype')
                            ->rule('unique:users'),
                    ]),
                Checkboxes::build()
                    ->name('roles')
                    ->options(Role::class)
                    ->setVisibility(auth()->user()->can('assign-role')),
            ]);
    }
}
```

You can create the form object in your controller and pass it through to your view.

```php
return view('create_user', ['form' => new CreateUserForm()])
```

In your view, you can then call the `render` method on the form.

```html
<html>
<head>
    <title>Create User</title>
</head>
<body>
{!! $form->render !!}
</body>
</html>
```

## Filling a Form

The `$form->fill()` method can be used to set the default values for all form components.

This method can either take an `array` or key => value pairs, or a `model`.

As an example, here is an `EditUserForm` which populates from an existing user model.

```php
namespace App\Forms;

use App\Models\Role;
use App\Models\User;
use Balfour\LaravelFormBuilder\Form;
use Balfour\LaravelFormBuilder\Components\Checkboxes;
use Balfour\LaravelFormBuilder\Components\EmailInput;
use Balfour\LaravelFormBuilder\Components\MobileNumberInput;
use Balfour\LaravelFormBuilder\Components\NumberInput;
use Balfour\LaravelFormBuilder\Components\PhoneNumberInput;
use Balfour\LaravelFormBuilder\Components\Row;
use Balfour\LaravelFormBuilder\Components\TextInput;
use Illuminate\Validation\Rule;

class EditUserForm extends Form
{
    public function __construct(User $user)
    {
        $this->route('post.edit_user', [$user])
            ->button('Save')
            ->with([
                TextInput::build()
                    ->name('first_name')
                    ->required(),
                TextInput::build()
                    ->name('last_name')
                    ->required(),
                EmailInput::build()
                    ->required()
                    ->disabled(),
                Row::build()
                    ->with([
                        MobileNumberInput::build()
                            ->rule(Rule::unique('users')->ignore($user)),
                        PhoneNumberInput::build()
                            ->name('office_number')
                            ->rule(Rule::unique('users')->ignore($user)),
                    ]),
                Row::build()
                    ->with([
                        NumberInput::build()
                            ->name('phone_extension')
                            ->rule(Rule::unique('users')->ignore($user)),
                        TextInput::build()
                            ->name('skype')
                            ->rule(Rule::unique('users')->ignore($user)),
                    ]),
                Checkboxes::build()
                    ->name('roles')
                    ->options(Role::class)
                    ->setVisibility(auth()->user()->can('assign-role'))
                    ->defaults(function () use ($user) {
                        return $user->roles
                            ->pluck('id')
                            ->toArray();
                    }),
                ToggleSwitch::build()
                    ->name('is_two_factor_auth_enforced')
                    ->label('2 Factor Authentication Enforced')
                    ->onLabel('Yes')
                    ->offLabel('No'),
                ToggleSwitch::build()
                    ->name('is_enabled')
                    ->label('Account Enabled')
                    ->onLabel('Yes')
                    ->offLabel('No'),
            ])->fill($user);
    }
}
```

When we construct the form, we just need to pass in a user model and all components
will be populated from the model.

```php
use App\Forms\EditUserForm;
use App\Models\User;

$user = User::find(3);
$form = new EditUserForm($user);

echo $form->render();
```

## Form Validation

The library will automagically generate validation rules for you based on the nested components
of the form.  The `$form->getValidationRules()` method can be called to generate the rules.

The validation of the actual form data is left up to you.

### Controller Validation

```php
use App\Forms\CreateUserForm;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function postCreate(Request $request)
    {
        $request->validate((new CreateUserForm())->getValidationRules());
    }
}
```

### Form Request Validation

```php
namespace App\Http\Requests;

use App\Forms\CreateUserForm;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return (new CreateUserForm())->getValidationRules();
    }
}
```

## Components

The following components are bundled into this package:

* [Checkbox (Single)](#checkbox-single)
* [Checkboxes (Multiple)](#checkboxes-multiple)
* [DateInput](#dateinput)
* [EmailInput](#emailinput)
* [FieldSet](#fieldset)
* [HiddenInput](#hiddeninput)
* [MobileNumberInput](#mobilenumberinput)
* [NumberInput](#numberinput)
* [PasswordInput](#passwordinput)
* [PhoneNumberInput](#phonenumberinput)
* [RadioButtonGroup](#radiobuttongroup)
* [RichTextEditor](#richtextarea)
* [Row](#row)
* [Select](#select)
* [TextArea](#textarea)
* [TextInput](#textinput)
* [TimePicker](#timepicker)
* [ToggleSwitch](#toggleswitch)

You can also create your own custom components by implementing `ComponentInterface`, or
`FormControlInterface` which extends `ComponentInterface`.

### Checkbox (single)

```php
use Balfour\LaravelFormBuilder\Components\Checkbox;

Checkbox::build()
    ->name('remember_me')
    ->label('Remember me for my next visit')
    ->defaults(1);
    
Checkbox::build()
    ->name('agree')
    ->label('I agree to the terms and conditions')
    ->rule('accepted');
```

### Checkboxes (multiple)

```php
use App\Models\Role;
use Balfour\LaravelFormBuilder\Components\Checkboxes;

$user = auth()->user();

// using an array of options
$roles = Role::pluck('name', 'id')
    ->toArray();

Checkboxes::build()
    ->name('roles')
    ->options($roles)
    ->defaults(function () use ($user) {
        return $user->roles
            ->pluck('id')
            ->toArray();
    });

// using a model, or options class
// the class must have a static listify() method which returns an array of key => value pairs
Checkboxes::build()
    ->name('roles')
    ->options(Role::class)
    ->setVisibility(auth()->user()->can('assign-role'))
    ->defaults(function () use ($user) {
        return $user->roles
            ->pluck('id')
            ->toArray();
    });
    
// using a callable to resolve options
Checkboxes::build()
    ->name('roles')
    ->options(function () {
        return Role::pluck('name', 'id')
            ->toArray();
    });
```

### DateInput

```php
use Balfour\LaravelFormBuilder\Components\DateInput;

// if no label is given, it's automagically generated from the component's name
DateInput::build()
    ->name('start_date');
   
// we can add a custom validation rule on top of the automagically generated ones
DateInput::build()
    ->name('start_date')
    ->rule('after:today');
```

### EmailInput

```php
use Balfour\LaravelFormBuilder\Components\EmailInput;

EmailInput::build()
    ->name('email');
    
// here's another custom validation rule on top of the 'email' one
EmailInput::build()
    ->name('email')
    ->rule('unique:users,email');
```

### FieldSet

```php
use Balfour\LaravelFormBuilder\Components\DateInput;
use Balfour\LaravelFormBuilder\Components\FieldSet;

FieldSet::build()
    ->legend('General')
    ->with([
        DateInput::build()
            ->name('start_date')
            ->required(),
        DateInput::build()
            ->name('end_date')
            ->required(),
    ]);
```

### HiddenInput

```php
use Balfour\LaravelFormBuilder\Components\HiddenInput;

HiddenInput::build()
    ->name('user_id')
    ->defaults(1);
```

### MobileNumberInput

```php
use Balfour\LaravelFormBuilder\Components\MobileNumberInput;

MobileNumberInput::build()
    ->defaults(auth()->user()->mobile_number);
```

### NumberInput

```php
use Balfour\LaravelFormBuilder\Components\NumberInput;

NumberInput::build()
    ->name('age');
```

### PasswordInput

```php
use Balfour\LaravelFormBuilder\Components\PasswordInput;

PasswordInput::build();

// if you want a custom label...
PasswordInput::build()
    ->name('Your Password');
```

### PhoneNumberInput

```php
use Balfour\LaravelFormBuilder\Components\PhoneNumberInput;

PhoneNumberInput::build()
    ->defaults(auth()->user()->phone_number);
```

### RadioButtonGroup

```php
use Balfour\LaravelFormBuilder\Components\RadioButtonGroup;

RadioButtonGroup::build()
    ->name('food_preference')
    ->options([
        [
            'key' => 'chicken',
            'value' => 'Chicken',
        ],
        [
            'key' => 'beef',
            'value' => 'Beef',
        ],
    ])
    ->defaults('chicken');
    
// you can also add icons
RadioButtonGroup::build()
    ->name('food_preference')
    ->options([
        [
            'key' => 'chicken',
            'value' => 'Chicken',
            'icon' => 'fas fa-egg',
        ],
        [
            'key' => 'beef',
            'value' => 'Beef',
            'icon' => 'fas fa-hamburger',
        ],
    ])
    ->defaults('chicken');
```

### RichTextEditor

```php
use Balfour\LaravelFormBuilder\Components\RichTextEditor;

// this will render a textarea with a 'wysiwyg' class
// it's up to you to instantiate a rich text editor on this element, such as with
// TinyMCE or Froala Editor
RichTextEditor::build()
    ->name('description')
    ->rows(10)
    ->required();
```

### Row

```php
use Balfour\LaravelFormBuilder\Components\DateInput;
use Balfour\LaravelFormBuilder\Components\Row;

Row::build()
    ->with([
        DateInput::build()
            ->name('start_date')
            ->required(),
        DateInput::build()
            ->name('end_date')
            ->required(),
    ]);
```

### Select

```php
use App\Models\Country;
use Balfour\LaravelFormBuilder\Components\Select;

// using an array of options, and include a default 'empty' option
Select::build()
    ->name('country_id')
    ->options([
        1 => 'South Africa',
        2 => 'Amsterdam',
        3 => 'Italy',
    ])
    ->hasEmptyOption();

// using a model, or options class
// the class must have a static listify() method which returns an array of key => value pairs
Select::build()
    ->name('country_id')
    ->options(Country::class)
    ->defaults(1);
    
// using a callable to resolve options
Select::build()
    ->name('country_id')
    ->options(function () {
        return [
            1 => 'South Africa',
            2 => 'Amsterdam',
            3 => 'Italy',
        ];
    });
```

### TextArea

```php
use Balfour\LaravelFormBuilder\Components\TextArea;

TextArea::build()
    ->name('description')
    ->rows(15)
    ->required()
    ->defaults('This is the default description.');
```

### TextInput

```php
use Balfour\LaravelFormBuilder\Components\TextInput;

TextInput::build()
    ->name('first_name')
    ->required()
    ->defaults(auth()->user()->first_name);
    
// you can show a placeholder message
TextInput::build()
    ->name('first_name')
    ->required()
    ->placeholder('Your First Name')
    ->defaults(auth()->user()->first_name);

// you can also customise the type, and add a custom validation rule
TextInput::build()
    ->name('email')
    ->type('email')
    ->required()
    ->defaults(auth()->user()->email)
    ->rule('unique:users,email');
```

### TimePicker

```php
use Balfour\LaravelFormBuilder\Components\TimePicker;

// the component is rendered as an input with a 'time-picker' class
// you'd need to use a timepicker js lib of your choice to render it
TimePicker::build()
    ->name('start_time')
    ->required()
    ->defaults('14:30');
```

### ToggleSwitch

```php
use Balfour\LaravelFormBuilder\Components\ToggleSwitch;

ToggleSwitch::build()
    ->name('two_factor_authentication_enabled')
    ->defaults(true);
    
// use custom on and off labels
ToggleSwitch::build()
    ->name('subscribe')
    ->onLabel('Yes')
    ->offLabel('No')
    ->defaults(true);
```