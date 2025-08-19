<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public array $statusColumns = [
        'pending' => [
            'title' => 'Todo',
            'subtitle' => 'Pending',
            'color' => 'bg-slate-100 border-slate-200',
            'icon' => '📝'
        ],
        'processing' => [
            'title' => 'In Progress',
            'subtitle' => 'Processing',
            'color' => 'bg-blue-50 border-blue-200',
            'icon' => '⚡'
        ],
        'completed' => [
            'title' => 'Complete',
            'subtitle' => 'Finished',
            'color' => 'bg-green-50 border-green-200',
            'icon' => '✅'
        ]
    ];

    public $draggedOrder = null;
    public $dragOverColumn = null;

    protected $listeners = [
        'orderDragged' => 'handleOrderDragged',
        'orderDropped' => 'handleOrderDropped',
        'dragOver' => 'handleDragOver',
        'dragLeave' => 'handleDragLeave'
    ];

    public function handleOrderDragged($orderUuid)
    {
        $this->draggedOrder = $orderUuid;
    }

    public function handleDragOver($status)
    {
        $this->dragOverColumn = $status;
    }

    public function handleDragLeave()
    {
        $this->dragOverColumn = null;
    }

    public function handleOrderDropped($orderUuid, $newStatus)
    {
        try {
            $order = Order::where('uuid', $orderUuid)->firstOrFail();

            if ($order->status !== $newStatus) {
                $order->update(['status' => $newStatus]);

                $this->dispatch('order-updated', [
                    'message' => "Order moved to {$this->statusColumns[$newStatus]['title']}",
                    'type' => 'success'
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('order-updated', [
                'message' => 'Failed to update order status',
                'type' => 'error'
            ]);
        } finally {
            $this->draggedOrder = null;
            $this->dragOverColumn = null;
        }
    }

    public function getStatusColor($status)
    {
        $colors = [
            'pending' => 'slate',
            'processing' => 'blue',
            'review' => 'amber',
            'completed' => 'green'
        ];

        return $colors[$status] ?? 'slate';
    }

    public function render()
    {
        $orders = collect();
        foreach ($this->statusColumns as $status => $config) {
            $orders[$status] = $this->getOrdersByStatus($status);
        }

        $statusColors = [
            'pending' => 'slate',
            'processing' => 'blue',
            'review' => 'amber',
            'completed' => 'green'
        ];

        return view('livewire.orders.index', [
            'orders' => $orders,
            'statusColumns' => $this->statusColumns, // Use the public property
            'statusColors' => $statusColors
        ]);
    }

    public function getOrdersByStatus($status)
    {
        return Order::where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
