
// Tastr Option
toastr.options = {
	"timeOut": "5000",
	"positionClass" : "toast-top-right",
	"progressBar": true,
};

// Values get from body
var aId = document.getElementById("aId").value;

//
var socket = io.connect(CURRENT_PORT);


$('#notificationsMenu li ').on('click', function (e) {
	e.preventDefault();
	console.log($(this).attr('id'));
	Notification.Seen({role : $('#mr').val(), notification_id : $(this).attr('id'), location : $(this).find('a:first').attr('href')});
	//window.location = $(this).find('a:first').attr('href');
});
