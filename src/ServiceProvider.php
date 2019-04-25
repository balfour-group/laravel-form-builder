<?php

namespace Balfour\LaravelFormBuilder;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'form-builder');

        Blade::component('form-builder::checkbox', 'checkbox');
        Blade::component('form-builder::checkboxes', 'checkboxes');
        Blade::component('form-builder::error', 'formerror');
        Blade::component('form-builder::form', 'form');
        Blade::component('form-builder::hidden', 'hiddeninput');
        Blade::component('form-builder::input', 'input');
        Blade::component('form-builder::label', 'label');
        Blade::component('form-builder::password', 'passwordinput');
        Blade::component('form-builder::radio-button-group', 'radiobuttongroup');
        Blade::component('form-builder::radios', 'radios');
        Blade::component('form-builder::select', 'select');
        Blade::component('form-builder::switch', 'switchcontrol');
        Blade::component('form-builder::textarea', 'textarea');
        Blade::component('form-builder::timepicker', 'timepicker');
        Blade::component('form-builder::wysiwyg', 'wysiwyg');
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }
}
