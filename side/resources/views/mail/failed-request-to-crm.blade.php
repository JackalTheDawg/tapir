<x-mail::message>
Ошибка отправки данных в CRM

Телеофн: {{$data["phone"]}}
vin: {{$data["vin"]}}

Свяжитесь с покупателем или отправьте запрос повторно!

С уважением,<br>
{{ config('app.name') }}
</x-mail::message>
