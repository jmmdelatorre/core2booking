
			<div class="row">
				<div class="col-lg-12">
					
					<div class="card mb-5">
						<div class="card-body">
						<div class=" h3"><i class="fas fa-bus"></i> Search travel schedule</div>
					

							<form action="<?php echo base_url() ?>ticket/check" method="post">
							<div class="form-group">
    <label>Trip Type</label>
    <div>
        <label class="radio-inline">
            <input type="radio"  class="trip_type" name="trip_type" value="oneway" required> One Way
        </label>
        <label class="radio-inline">
            <input type="radio" class="trip_type" name="trip_type" value="roundtrip" required> Round Trip
        </label>
    </div>
</div>
							
								<div class="form-group">
									<label for="exampleInputEmail1">Departure</label>
									<select name="departure"  class="form-control selCity" required>
										<option value="" selected disabled="">Choose Origin</option>
									</select>
								</div>
								<div class="form-group">
									<label for="exampleInputEmail1">Destination</label>
									<select name="arrival" class="form-control  selCity">
										<option value="" selected disabled="">Choose Destination</option>
										
									</select>
								</div>

								<div class="form-group">
									<label for="exampleInputEmail1">Departure date</label>
									<input placeholder="Enter date" type="date" class="form-control"
										name="depart_date" required="">
								</div>

								<div class="form-group return" hidden>
    <label for="exampleInputEmail1">Return date</label>
    <input placeholder="Enter date" type="datetime-local" class="form-control" name="return_date">
</div>

								<div class="form-group">
									<label for="exampleInputEmail1">No of Passenger</label>
									<input placeholder="No of Passenger" type="number" class="form-control"
										name="nopass" required="">
								</div>
								<a type="button" class="btn  btn-outline-primary pull-left" href="<?php echo base_url() ?>ticket/lookup"><i class="fas fa-file"></i>&nbsp;Find My Ticket</a>
								<button type="submit" class="btn  btn-outline-primary pull-right"><i class="fas fa-search"></i>&nbsp;Search </button>

							</form>
						</div>
					</div>
				</div>
			
			</div>
	</section>

	<script type="text/javascript">
	$(document).ready(function () {
    
    $(".selCity").select2({
        enabled: true,
        placeholder: "City",
     
        allowClear: true,
        ajax: {
            url: "DemographicsController/searchCity",
            dataType: "JSON",
            type: "POST",
            delay: 250,
            data: function (params) {
                return { searchCity: params.term };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return { id: item.ctycode, text: item.ctyname };
                    }),
                };
            },
        },
    });
    $(".trip_type").on("change", function () {
        var type = $(this).val();
        if (type === "oneway") {
            $(".return").prop("hidden", true);
            $(".return input").prop("required", false); 
        } else {
            $(".return").prop("hidden", false);
            $(".return input").prop("required", true); 
        }
    });
});

	</script>
	
	

