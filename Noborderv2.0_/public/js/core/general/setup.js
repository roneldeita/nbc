
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