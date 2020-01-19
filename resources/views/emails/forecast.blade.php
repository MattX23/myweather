@component('mail::message')
# {{ __('mails.this_week') }}

{{ __('mails.greeting') }} {{ $user->first_name }},

{{ __('mails.week_summary') }}

{{ $weather->weeklySummary }}

## {{ __('mails.days.sunday') }}

{{ __('mails.today_lead_in') }} {{ $weather->todayHigh }}° {{ __('mails.low_lead_in') }} {{ $weather->todayLow }}° {{ __('mails.with') }} {{ $weather->todayRain }} {{ __('mails.chance_of_rain') }}.

## {{ __('mails.days.monday') }}

{{ __('mails.days.monday') }}{{ __('mails.weekly_lead_in') }} {{ $weather->tomorrowHigh }}° {{ __('mails.low_lead_in') }} {{ $weather->tomorrowLow }}° {{ __('mails.with') }} {{ $weather->tomorrowRain }} {{ __('mails.chance_of_rain') }}.

## {{ __('mails.days.tuesday') }}

{{ __('mails.days.tuesday') }}{{ __('mails.weekly_lead_in') }} {{ $weather->dayThreeHigh }}° {{ __('mails.low_lead_in') }} {{ $weather->dayThreeLow }}° {{ __('mails.with') }} {{ $weather->dayThreeRain }} {{ __('mails.chance_of_rain') }}.

## {{ __('mails.days.wednesday') }}

{{ __('mails.days.wednesday') }}{{ __('mails.weekly_lead_in') }} {{ $weather->dayFourHigh }}° {{ __('mails.low_lead_in') }} {{ $weather->dayFourLow }}° {{ __('mails.with') }} {{ $weather->dayFourRain }} {{ __('mails.chance_of_rain') }}.

## {{ __('mails.days.thursday') }}

{{ __('mails.days.thursday') }}{{ __('mails.weekly_lead_in') }} {{ $weather->dayFiveHigh }}° {{ __('mails.low_lead_in') }} {{ $weather->dayFiveLow }}° {{ __('mails.with') }} {{ $weather->dayFiveRain }} {{ __('mails.chance_of_rain') }}.

## {{ __('mails.days.friday') }}

{{ __('mails.days.friday') }}{{ __('mails.weekly_lead_in') }} {{ $weather->daySixHigh }}° {{ __('mails.low_lead_in') }} {{ $weather->daySixLow }}° {{ __('mails.with') }} {{ $weather->daySixRain }} {{ __('mails.chance_of_rain') }}.

## {{ __('mails.days.saturday') }}

{{ __('mails.days.saturday') }}{{ __('mails.weekly_lead_in') }} {{ $weather->daySevenHigh }}° {{ __('mails.low_lead_in') }} {{ $weather->daySevenLow }}° {{ __('mails.with') }} {{ $weather->daySevenRain }} {{ __('mails.chance_of_rain') }}.

@component('mail::button', ['url' => route('home')])
{{ __('mails.more_details') }}
@endcomponent

{{ __('mails.thanks') }},<br>
{{ config('app.name') }}
@endcomponent
