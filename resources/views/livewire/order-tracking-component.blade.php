<div>
    <!-- Full Width Order Tracking Form -->
    <form wire:submit.prevent="trackOrder" class="w-full">
        <div class="flex flex-col sm:flex-row gap-2 items-stretch w-full max-w-full">
            <input
                type="text"
                wire:model.defer="tracking_number"
                placeholder="Enter your tracking number"
                class="w-full px-4 py-3 border border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-black"
                required
            >
            <button
                type="submit"
                class="px-6 py-3 bg-black text-white font-medium rounded-md shadow hover:bg-gray-900 transition w-full sm:w-auto"
            >
                Track Order
            </button>
        </div>
    </form>

    @if(count($errors) > 0)
        <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <strong class="font-bold">Please fix the following errors:</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($order)
        <!-- Order Summary Card -->
        <div class="bg-white shadow-lg rounded-2xl p-6 mt-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Order Summary</h2>

            <div class="space-y-2 text-sm text-gray-700">
                <p><span class="font-semibold">Tracking Number:</span> {{ $order['tracking_number'] }}</p>
                <p><span class="font-semibold">Customer Name:</span> {{ $order['customer_name'] }}</p>
                <p><span class="font-semibold">To be delivered to:</span> {{ $order['town'] }}</p>
                <p><span class="font-semibold">MPESA Number:</span> {{ $order['mpesa_number'] }}</p>
                <p><span class="font-semibold">Amount:</span> KES {{ $order['amount'] }}</p>
                <p><span class="font-semibold">Payment Status:</span> {{ ucfirst($order['payment_status']) }}</p>
                <p><span class="font-semibold">Order Status:</span> {{ ucfirst($order['status']) }}</p>
                <p><span
                        class="font-semibold">Created At:</span> {{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y, h:i A') }}
                </p>
            </div>
        </div>
    @endif
</div>
