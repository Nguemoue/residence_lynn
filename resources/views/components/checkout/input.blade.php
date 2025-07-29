@props([
    'field',
    'label',
    'type'     => 'text',
    'required' => false,
])

@php
    $id = 'f_'.$field;
@endphp

<div class="form-control">
    <label for="{{ $id }}" class="label py-1">
        <span class="label-text">
            {{ $label }}@if($required) <span class="text-error">*</span>@endif
        </span>
    </label>

    <input  id="{{ $id }}"
            name="{{ $field }}"
            type="{{ $type }}"
            x-model="form.{{ $field }}"
            x-on:blur="validateField('{{ $field }}')"
            :class="errors.{{ $field }} ? 'input input-bordered input-error w-full' : 'input input-bordered w-full'"
        {{ $required ? 'required' : '' }}>

    <!-- message d’erreur Alpine -->
    <p class="mt-1 text-xs text-error" x-text="errors.{{ $field }}" x-show="errors.{{ $field }}"></p>

    <!-- message d’erreur back-end (au rechargement) -->
    @error($field)
    <p class="mt-1 text-xs text-error">{{ $message }}</p>
    @enderror
</div>
