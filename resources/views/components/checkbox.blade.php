@props(['checked' => false])
<div>
    <input {{ $attributes->merge([
                    'class' => "rounded border-gray-300  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500",
                    'type' => "checkbox",
                ])
           }}
        @checked($checked)
    />
    {{$checked}}
</div>
