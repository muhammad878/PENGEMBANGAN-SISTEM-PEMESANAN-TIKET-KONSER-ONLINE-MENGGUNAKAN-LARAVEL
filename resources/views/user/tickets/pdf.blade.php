<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .ticket {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            max-width: 800px;
            margin: 0 auto;
        }
        .ticket-header {
            background-color: #f43f5e;
            color: white;
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }
        .ticket-body {
            padding: 20px;
        }
        .event-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .event-details {
            margin-bottom: 20px;
        }
        .event-info {
            margin-bottom: 5px;
        }
        .ticket-code {
            font-size: 24px;
            font-weight: bold;
            margin: 25px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 4px;
            text-align: center;
            font-family: monospace;
            letter-spacing: 2px;
        }
        .ticket-footer {
            border-top: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .centered {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="ticket-header">
            KonserKUY E-Ticket
        </div>
        
        <div class="ticket-body">
            <div class="logo centered">
                <!-- Logo placeholder -->
                <strong>KonserKUY</strong>
            </div>
            
            <div class="event-title centered">
                @if ($ticket->order && $ticket->order->event)
                    {{ $ticket->order->event->title }}
                @else
                    Unknown Event
                @endif
            </div>
            
            <div class="event-details centered">
                @if ($ticket->order && $ticket->order->event)
                    <div class="event-info">
                        <strong>Location:</strong> {{ $ticket->order->event->location }}
                    </div>
                    <div class="event-info">
                        <strong>Date & Time:</strong> {{ $ticket->order->event->date->format('j F Y, H:i') }}
                    </div>
                @endif
            </div>
            
            <table>
                <tr>
                    <th>Ticket Code</th>
                    <td>{{ $ticket->code }}</td>
                </tr>
                <tr>
                    <th>Attendee</th>
                    <td>{{ $ticket->user->name }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if ($ticket->is_used)
                            Used
                        @elseif ($ticket->event_date && $ticket->event_date < now())
                            Expired
                        @else
                            Active
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Purchased On</th>
                    <td>{{ $ticket->created_at->format('j F Y, H:i') }}</td>
                </tr>
            </table>
            
            <div class="ticket-code">
                {{ $ticket->code }}
            </div>
        </div>
        
        <div class="ticket-footer">
            <p>This ticket is for personal use only and cannot be transferred. Please bring a valid ID to the event.</p>
            <p>For assistance, please contact support@konserkuy.com</p>
        </div>
    </div>
</body>
</html> 