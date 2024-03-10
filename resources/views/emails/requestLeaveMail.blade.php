<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
#  طلب إجازة جديد,

مرحباً,

لقد تم استلام طلب إجازة جديد من {{ $username }}.
    
**نوع الإجازة:** {{$leave_type}} \
**من:** {{$start_date}} \
**إلى:** {{$end_date}} \
**مدة الإجازة:** {{$days}} \
**السبب:** {{$reason}}

يرجى الموافقة على/رفض طلب الإجازة هذا من خلال المتابعة:

@component('mail::button', ['url' => route('admin.leave.requests'), 'color' => 'success'])
    عرض الطلب
@endcomponent

شكرًا.
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