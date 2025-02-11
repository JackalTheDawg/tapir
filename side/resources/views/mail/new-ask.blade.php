<x-mail::message>
Новая заявка

VIN: {{$data["vin"]}}
PHONE: {{$data["phone"]}}

С уважением,<br>
{{ config('app.name') }}
</x-mail::message>
