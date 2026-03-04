<x-mail::message>
    # You're Invited! 🎉

    Hello there,

    You've been invited to join **{{ $projectName }}**. We're excited to have you on board and can't wait to see what we build
    together!

    <x-mail::panel>
        Click the button below to accept your invitation and get started.
    </x-mail::panel>

    <x-mail::button :url="$signedUrl" color="success">
        Accept Invitation
    </x-mail::button>

    If you weren't expecting an invitation, you can safely ignore this email.

    <x-slot:subcopy>
        For security, this invitation link will expire in 7 days.
    </x-slot:subcopy>

    Thanks,<br>
    The {{ config('app.name') }} Team
</x-mail::message>