<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
#  Leave Request {{$status}},

Hello {{$username}},

Your **{{$leave_type}}** request for {{$days}} days from {{$start}} to {{$end}} has been {{$status}}  
    
@if ($status === 'Rejected')
The reason of rejection is: {{$reason}}
@endif

Regards  
**{{$approved_by}}**  
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