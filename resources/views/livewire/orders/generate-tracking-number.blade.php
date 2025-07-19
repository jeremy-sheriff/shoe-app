<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}

    @if($showTrackingNumber)
        Your Tracking number is: {{$tracking_number}}
    @endif


    <div wire:offline>
        You are now offline.
    </div>
</div>
