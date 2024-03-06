<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
## Hi {{ $admin }},
                        
#### {{ $username }} has requested {{$leave_type}},
    
    
| Type          | {{$leave_type}}  |
| -             |-                   |
| Start Date:   | {{$start_date}}  |
| End Date:     | {{$end_date}}    |
| Reason        | {{$reason}}      |
    
    
#### Please click the button below and update the leave status in the system

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