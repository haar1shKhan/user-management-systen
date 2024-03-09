<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
#  Welcome to Ansee Nails Care,

Hello {{$employee_name}},

I'm thrilled to welcome you to Ansee Nails Care! We're excited to have you on board. 
Your expertise and energy will undoubtedly contribute to our success.

Here are a few quick details to help you get started:

Regards  
**{{$sender_name}}**  
Ansee Nails Care

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>