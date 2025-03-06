<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print ticket</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f3f4f6;
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        .tickets-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            padding: 10px;
        }
        .ticket {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            width: 200px;
            text-align: center;
            transition: transform 0.2s;
            position: relative;
        }
        .ticket:hover {
            transform: scale(1.05);
        }
        h2 {
            margin-top: 0;
            font-size: 20px;
            color: #333;
        }
        p {
            margin: 3px 0;
            font-size: 12px;
            color: #555;
        }
        .print-btn, .print-individual-btn {
            margin: 8px;
            padding: 8px 16px;
            border: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
        }
        .print-btn:hover, .print-individual-btn:hover {
            background-color: #45a049;
        }
        img.qr-code {
            margin: 5px 0;
            width: 100px;
            height: 100px;
        }
        @media print {
            .print-btn, .print-individual-btn {
                display: none;
            }
            .ticket {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<?php include 'assets/phpqrcode/qrlib.php'; ?>
<body >
    <div class="tickets-container" id="tickets">
        <?php foreach ($tickets as $ticket) : ?>
            <div class="ticket" id="ticket-<?= $ticket['ticket_no']; ?>">
                <h2>Bus Ticket</h2>
                <?php 
                    ob_start();
                    QRcode::png($ticket['ticket_no'], null, 'Q', 8, 1);
                    $imageData = base64_encode(ob_get_contents());
                    ob_end_clean();
                ?>
                <img src="data:image/png;base64,<?= $imageData; ?>" class="qr-code" alt="QR Code">
                <small> <?= $ticket['ticket_no']; ?></small>
                <p><strong>Order id:</strong> <?= $ticket['order_code']; ?></p>
                <p><strong>Terminal:</strong> <?= $ticket['terminal_origin']; ?></p>
                <p><strong>Bus:</strong> <?= $ticket['bus_name']; ?></p>
                <p><strong>Passenger:</strong> <?= $ticket['name']; ?></p>
                <p><strong>From:</strong> <?= $ticket['origin']; ?></p>
                <p><strong>To:</strong> <?= $ticket['destination']; ?></p>
                <p><strong>Date:</strong> <?= $ticket['departure_date']; ?></p>
                <p><strong>Seat:</strong> <?= $ticket['seat_number']; ?></p>
                <p><strong>Fare:</strong> PHP <?= $ticket['amount']; ?></p>
                <button class="print-individual-btn" onclick="printIndividualTicket('ticket-<?= $ticket['ticket_no']; ?>')">Print This Ticket</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="print-btn" onclick="printTickets()">Print All Tickets</button>
    <script>
        function printTickets() {
            const ticketContent = document.getElementById('tickets').outerHTML;
            const originalContent = document.body.innerHTML;
            document.body.innerHTML = ticketContent;
            window.print();
            document.body.innerHTML = originalContent;
            window.location.reload();
        }

        function printIndividualTicket(ticketId) {
            const ticketElement = document.getElementById(ticketId);
            const originalContent = document.body.innerHTML;
            document.body.innerHTML = ticketElement.outerHTML;
            window.print();
            document.body.innerHTML = originalContent;
            window.location.reload();
        }
    </script>
</body>
</html>
