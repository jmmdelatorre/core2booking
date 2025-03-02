<!DOCTYPE html>
<html>
<head>
  <title>Bus Seat Selection</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
 
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    .seat {
      width: 50px;
      height: 50px;
    }
    .aisle {
      background-color: #e2e8f0;
      border: none;
      cursor: default;
    }
    .available {
      background-color: #d1d5db;
      border: 1px solid #ccc;
    }
    .selected {
      background-color: #34d399;
      color: white;
    }
  </style>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body class=" bg-primary container py-4">
	
		<section class="service-area section-gap relative">
			<div class="overlay overlay-bg"></div>
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<!-- Default Card Example -->
						<div class="card mb-3">
							<div class="card-body">
							<div class=" h4 mb-3"><i class="fas fa-info-circle"></i> Schedule Information</div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><b>Bus information</b>:<?php echo $schedule->bus_id;?> </li>
                                    <li class="list-group-item"><b>Terminal Origin</b>:<?php echo $schedule->terminal_origin;?>&nbsp;(<?php echo $schedule->origin;?>) </li>
                                    <li class="list-group-item"><b>Terminal Destination</b>:<?php echo $schedule->terminal_arrival;?>&nbsp;(<?php echo $schedule->destination;?>)</li>
                                    <li class="list-group-item"><b>Departure time </b>:<?php echo $schedule->departure_time;?></li>
                                    <li class="list-group-item"><b>Arrival time</b>:<?php echo $schedule->arrival_time;?></li>
                                    <li class="list-group-item"><b>Fare Price</b>:<input type="number" class="form-control" readonly id="farePrice"  value="<?php echo $schedule->price;?>"></li>
                                    <li class="list-group-item"><b>No of person</b>:<input type="number" id="passengerLimit"  value="<?php echo $no_pass;?>"></li>
                                    <div class="mt-4">
                                         <h5>Total Fare: <span class="totalFare">0</span></h5>
                                         <input  type="hidden" class="totalFare"  >
                                    </div>    
                                </ul>
							</div>
						</div>
					</div>
                </div>	
         
                <div class="row">
					<div class="col-lg-4">
						<!-- Default Card Example -->
                        <div class="card mb-3">
                        <div class="card-body">
							<div class=" h4 mb-3"><i class="fas fa-bus"></i>&nbsp;Seat Selection</div>
                            <input type="hidden" id="capacity"  value="<?php echo $schedule->bus_capacity;?>">
                            <?php $this->load->view('frontend/bus_seat');?>
							</div>
                           
                            </div>
					</div>
                    <div class="col-lg-8">
				
                        <div class="card mb-3">
                        <div class="card-body">
							<div class=" h4 mb-3"><i class="fas fa-bus"></i>&nbsp;Passenger Information</div>
                            <form id="passengerForm" method="POST">
                                    <div id="seatContainer" class="d-grid" style="grid-template-columns: repeat(6, 60px);"></div>
                                    <div class="mb-2">
                                    <label>Email Addres:</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                    </div>
                                    <div id="passengerFormContainer" class="mt-4"></div>
                                    
                                    <input type="hidden" id ="scheduleID" name="scheduleID"  value="<?php echo $schedule->schedule_id;?>">
                                    <input type="hidden" id ="totAmount" name="totAmount">
                                    <div class="mt-4">
                                    <h5>Total Fare: <span class="totalFare">0</span></h5>
                                    </div>
                            <button type="submit" class="btn btn-success">Submit</button>
                            </form>
					</div>
                </div>			
        </section>
  </div>

  <script>
   $(document).ready(function() {
    let selectedSeats = 0;

    function updateTotalFare() {
        const farePrice = parseFloat($('#farePrice').val()) || 0;
        $('.totalFare').text((selectedSeats * farePrice).toFixed(2));
        $('#totAmount').val((selectedSeats * farePrice).toFixed(2));
      }
      function generateSeats() {
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
              const button = $('<button>', {
                class: 'btn seat available',
                text: seatNumber,
                type: 'button',
                click: function() {
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
                          <input type="number" name="age[]" class="form-control" placeholder="Enter age" min="1" required>
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
                          <input type="tel" name="contact[]" class="form-control" placeholder="Enter contact number"  required>
                        </div>
                      </div>`;
                      passengerFormContainer.append(form);
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
        var totalAmount = $('.totalFare').val();
        formData += '&farePrice=' + encodeURIComponent(farePrice);
        formData += '&nopass=' + encodeURIComponent(passenger);
        formData += '&totalFare=' + encodeURIComponent(totalAmount);
        $.ajax({
          url: <?php base_url();?>'/TicketController/booking2',
          method: 'POST',
          data: formData,
          success: function(response) {
            if (response.redirect_url) {
            window.location.href = response.redirect_url;
        } else {
            console.error('No redirect URL found in response');
        } 
         /*    $('#passengerForm')[0].reset();
            $('#seatContainer').empty();
            $('#passengerFormContainer').empty();
            $('#totalFare').text('0'); */
          },
          error: function(response) {
            console.log(response);
            swal('Error', 'Failed to submit booking.', 'error');
          }
        });
        return false;
      });


      $('#generateSeats').on('click', generateSeats);
      generateSeats();
    });
  </script>	

  </body>
  </html>