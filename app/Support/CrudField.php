<?php

namespace App\Support;

/**
 * Lightweight value object describing a single form field. Generic CRUD
 * Blade templates introspect these to render labels, inputs, validation
 * helpers and the "show" view automatically.
 */
class CrudField
{
    public function __construct(
        public string $name,
        public string $label,
        public string $type = 'text',
        public bool $required = false,
        public ?array $options = null,
        public ?string $help = null,
        public ?string $placeholder = null,
        public mixed $default = null,
        public bool $multiple = false,
        public ?int $rows = null,
        public ?string $accept = null,
    ) {}

    public static function text(string $name, string $label, bool $required = false): self
    {
        return new self($name, $label, 'text', $required);
    }

    public static function email(string $name, string $label, bool $required = false): self
    {
        return new self($name, $label, 'email', $required);
    }

    public static function password(string $name, string $label, bool $required = false): self
    {
        return new self($name, $label, 'password', $required);
    }

    public static function number(string $name, string $label, bool $required = false): self
    {
        return new self($name, $label, 'number', $required);
    }

    public static function decimal(string $name, string $label, bool $required = false): self
    {
        return new self($name, $label, 'decimal', $required);
    }

    public static function date(string $name, string $label, bool $required = false): self
    {
        return new self($name, $label, 'date', $required);
    }

    public static function datetime(string $name, string $label, bool $required = false): self
    {
        return new self($name, $label, 'datetime', $required);
    }

    public static function time(string $name, string $label, bool $required = false): self
    {
        return new self($name, $label, 'time', $required);
    }

    public static function textarea(string $name, string $label, bool $required = false, int $rows = 3): self
    {
        return new self($name, $label, 'textarea', $required, rows: $rows);
    }

    public static function select(string $name, string $label, array $options, bool $required = false): self
    {
        return new self($name, $label, 'select', $required, options: $options);
    }

    public static function selectMultiple(string $name, string $label, array $options): self
    {
        return new self($name, $label, 'select', false, options: $options, multiple: true);
    }

    public static function checkbox(string $name, string $label): self
    {
        return new self($name, $label, 'checkbox');
    }

    public static function file(string $name, string $label, ?string $accept = null): self
    {
        return new self($name, $label, 'file', accept: $accept);
    }
}
