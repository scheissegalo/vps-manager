//JavaFile

//alert("Hello! I am an alert box!!");

jQuery(function($){
	$('#loading').show();
	$.ajax({
		url:'/wp-admin/admin-ajax.php',
		data:{action: "myfilter", serviceType: "none", filterLetter: "none"},
		type: "post", // POST
		beforeSend:function(xhr){
			$(".button_B").attr("disabled", true);
			$('#results').html('Please Wait....');
		},
		success:function(data){
			$('#response').html(data); // insert data
			$(".button_B").attr("disabled", false);
			$('#results').html('Ready');
			$('#loading').hide();
		},
		error: function(xhr) { // if error occured
			//alert("Error occured.please try again");
			$(".button_B").attr("disabled", false);
			$('#results').html('Error!');
			$('#loading').hide();
		}
	});
});
