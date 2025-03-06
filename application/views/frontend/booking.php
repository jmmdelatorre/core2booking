<!DOCTYPE html>
<html>
<head>
    <title>Bus Seat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        body {
            background-color: #f8fafc;
        }
        .seat {
            width: 35px;
            height: 35px;
            margin: 2px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s, background-color 0.2s;
        }
        .aisle {
            background-color: #e2e8f0;
            border: none;
            cursor: default;
        }
        .available {
            background-color: #d1d5db;
            cursor: pointer;
        }
        .selected {
            background-color: #34d399;
            color: white;
            border-color: #10b981;
        }
        .occupied {
            background-color: #b91c1c;
            color: white;
            border-color: #991b1b;
            cursor: not-allowed;
        }
        .seat:hover:not(.occupied):not(.selected) {
            background-color: #cbd5e1;
            transform: scale(1.1);
        }
        .card-header {
            background-color: #1e3a8a;
            color: white;
        }
        .btn-success {
            background-color: #10b981;
            border-color: #10b981;
        }
        .btn-success:hover {
            background-color: #059669;
            border-color: #059669;
        }
    </style>
</head>
<body class="container py-4">

<section class="my-4">
    <div class="row">
        <div class="col-lg-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Schedule Information
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>Bus:</b> <?= $schedule->bus_id; ?></li>
                        <li class="list-group-item"><b>From:</b> <?= $schedule->terminal_origin; ?> (<?= $schedule->origin; ?>)</li>
                        <li class="list-group-item"><b>To:</b> <?= $schedule->terminal_arrival; ?> (<?= $schedule->destination; ?>)</li>
                        <li class="list-group-item"><b>Departure:</b> <?= $schedule->departure_time; ?></li>
                        <li class="list-group-item"><b>Arrival:</b> <?= $schedule->arrival_time; ?></li>
                        <li class="list-group-item"><b>Fare Price:</b>
                            <input type="number" class="form-control form-control-sm" readonly id="farePrice" value="<?= $schedule->price; ?>">
                        </li>
                        <li class="list-group-item"><b>No of Passengers:</b>
                            <input type="number" class="form-control form-control-sm" id="passengerLimit" value="<?= $no_pass; ?>">
                        </li>
                    </ul>
                    <div class="mt-2">
                        <h6>Total Fare: <span class="totalFare">0</span></h6>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8 mb-3">
            <div class="card shadow-sm">
                <div class="card-header">
                    <i class="fa-solid fa-steering-wheel"></i> Passenger Information & Seat Selection
                </div>
                <div class="card-body">
                    <form id="passengerForm" method="POST">
                        <div id="seatContainer" class="d-grid mb-3" style="grid-template-columns: repeat(6, 40px);"></div>
                        <div class="mb-2">
                            <label>Email Address:</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div id="passengerFormContainer"></div>
                        
                        <input type="hidden" id="scheduleID" name="scheduleID" value="<?= $schedule->schedule_id; ?>">
                        <input type="hidden" id="totAmount" name="totAmount">

                        <div class="mt-3">
                            <h6>Total Fare: <span class="totalFare">0</span></h6>
                        </div>
                        <button type="submit" class="btn btn-success mt-3 w-100">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
  </div>
  <input type="hidden" id="occupied" name="occupied" value="<?php echo implode(',', array_column($occupied, 'seat_number')); ?>">
  <script>
   $(document).ready(function() {
    let selectedSeats = 0;

    function updateTotalFare() {
        const farePrice = parseFloat($('#farePrice').val()) || 0;
        let totalFare = 0;
    
        $('#passengerFormContainer .mb-3').each(function() {
            const age = parseInt($(this).find('input[name="age[]"]').val()) || 0;
            const isEligibleForDiscount = age >= 60 || $(this).find('input[name="discountEligible[]"]').is(':checked');
            let fare = farePrice;
    
            // Apply 20% discount if eligible
            if (isEligibleForDiscount) {
                fare = farePrice * 0.8;
            }
    
            totalFare += fare;
    
            // Update the individual fare display (always visible)
            $(this).find('.individualFare').val(fare.toFixed(2));
        });
    
        $('.totalFare').text(`₱${totalFare.toFixed(2)}`);
        $('#totAmount').val(totalFare.toFixed(2));
    }
    
    function generateSeats(occupiedSeats = []) {
        const capacity = parseInt($('#capacity').val()) || 40;
        const passengerLimit = parseInt($('#passengerLimit').val()) || capacity;
        const columns = 6;
        const rows = Math.ceil(capacity / 5);
        const seatContainer = $('#seatContainer');
        const passengerFormContainer = $('#passengerFormContainer');
        seatContainer.empty();
        passengerFormContainer.empty();
        selectedSeats = 0;
    
        let seatNumber = 1;
        for (let r = 0; r < rows; r++) {
            for (let c = 0; c < columns; c++) {
                const isLastRow = r === rows - 1;
                const isAisle = (c === 3 && !isLastRow);
                const isSeat = !isAisle;
    
                if (isSeat) {
                    const isOccupied = occupiedSeats.includes(seatNumber.toString());
                    const button = $('<button>', {
                        class: `btn seat ${isOccupied ? 'occupied' : 'available'}`,
                        text: seatNumber,
                        type: 'button',
                        disabled: isOccupied,
                        click: function () {
                            const currentSeatNumber = $(this).text();
                            if ($(this).hasClass('selected')) {
                                $(this).removeClass('selected');
                                selectedSeats--;
                                passengerFormContainer.find(`#passengerForm${currentSeatNumber}`).remove();
                            } else {
                                if (selectedSeats < passengerLimit) {
                                    $(this).addClass('selected');
                                    selectedSeats++;
                                    const form = `<div id="passengerForm${currentSeatNumber}" class="mb-3">
                                        <h5>Passenger ${selectedSeats} (Seat ${currentSeatNumber})</h5>
                                        <input type="hidden" name="seats[]" value="${currentSeatNumber}" />
                                        <div class="mb-2">
                                            <label>Name:</label>
                                            <input type="text" name="name[]" class="form-control" placeholder="Enter name" required>
                                        </div>
                                        <div class="mb-2">
                                            <label>Age:</label>
                                            <input type="number" name="age[]" class="form-control age-input" placeholder="Enter age" min="1" required>
                                        </div>
                                        <div class="mb-2">
                                            <label>Gender:</label>
                                            <select name="gender[]" class="form-select" required>
                                                <option value="">Select gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label>Contact Number:</label>
                                            <input type="tel" name="contact[]" class="form-control" placeholder="Enter contact number" required>
                                        </div>
                                        <div class="mb-2">
                                            <label>
                                                <input type="checkbox" name="discountEligible[]" class="discount-checkbox"> Senior Citizen (60+) or PWD
                                            </label>
                                        </div>
                                        <div class="mb-2 id-number-container" style="display:none;">
                                            <label>ID Number:</label>
                                            <input type="text" name="id_number[]" class="form-control" placeholder="Enter ID number">
                                        </div>
                                        <div class="mt-2">
                                            <label>Individual Fare:</label>
                                            <input type="text" name="individualFare[]" class="form-control individualFare" placeholder="Calculated fare" readonly>
                                        </div>
                                    </div>`;
                                    
                                    passengerFormContainer.append(form);
    
                                    // Attach an event listener to the new age input
                                    passengerFormContainer.find(`#passengerForm${currentSeatNumber} input[name="age[]"]`).on('input', function() {
                                        const age = parseInt($(this).val()) || 0;
                                        const idContainer = $(this).closest('.mb-3').find('.id-number-container');
                                        if (age >= 60) {
                                            idContainer.show();
                                            $(this).closest('.mb-3').find('.discount-checkbox').prop('checked', true);
                                        } else {
                                            idContainer.hide();
                                            $(this).closest('.mb-3').find('.discount-checkbox').prop('checked', false);
                                        }
                                        updateTotalFare();
                                    });
    
                                    // Attach an event listener to the discount checkbox
                                    passengerFormContainer.find(`#passengerForm${currentSeatNumber} input[name="discountEligible[]"]`).on('change', function() {
                                        const idContainer = $(this).closest('.mb-3').find('.id-number-container');
                                        if ($(this).is(':checked')) {
                                            idContainer.show();
                                        } else {
                                            idContainer.hide();
                                        }
                                        updateTotalFare();
                                    });
    
                                } else {
                                    swal({
                                        title: 'Limit Reached',
                                        text: 'You have reached the maximum number of selected seats!',
                                        icon: 'warning',
                                        button: 'OK'
                                    });
                                }
                            }
                            updateTotalFare();
                        }
                    });
                    seatContainer.append(button);
                    seatNumber++;
                } else {
                    seatContainer.append('<div class="seat aisle"></div>');
                }
            }
        }
    }
    
    
      $('#passengerForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var farePrice = $('#farePrice').val();
        var passenger = $('#passengerLimit').val();
        var totalAmount = $('.totalFare').text();
        formData += '&farePrice=' + encodeURIComponent(farePrice);
        formData += '&nopass=' + encodeURIComponent(passenger);
        formData += '&totalFare=' + encodeURIComponent(totalAmount);
        $.ajax({
          url: '<?php echo base_url();?>/TicketController/booking2',
          method: 'POST',
          data: formData,
          success: function(response) {
            if (response.redirect_url) {
              window.location.href = response.redirect_url;
            } else {
              console.error('No redirect URL found in response');
            } 
          },
          error: function(response) {
            console.log(response);
            swal('Error', 'Failed to submit booking.', 'error');
          }
        });
        return false;
      });
    
    
      const occupiedSeats = $('#occupied').val().split(',').map(seat => seat.trim());
      generateSeats(occupiedSeats);
    });
  </script>	
  
  </body>
  </html>
