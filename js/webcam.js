(function() {
  // The width and height of the captured photo. We will set the
  // width to the value defined here, but the height will be
  // calculated based on the aspect ratio of the input stream.

  var width = 320;    // We will scale the photo width to this
  var height = 0;     // This will be computed based on the input stream

  // |streaming| indicates whether or not we're currently streaming
  // video from the camera. Obviously, we start at false.

  var streaming = false;

  // The various HTML elements we need to configure or control. These
  // will be set by the startup() function.

  var video = null;
  var canvas = null;
  var photo = null;
  var startbutton = null;

function startup() {
	video = document.getElementById('video');
	canvas = document.getElementById('canvas');
	photo = document.getElementById('photo');
	startbutton = document.getElementById('startbutton');

	navigator.getMedia = ( navigator.getUserMedia ||
	                       navigator.webkitGetUserMedia ||
	                       navigator.mozGetUserMedia ||
	                       navigator.msGetUserMedia);

	navigator.getMedia(
		{
			video: true,
			audio: false
		},

		function(stream) {
			if (navigator.mozGetUserMedia) {
				video.mozSrcObject = stream;
			}
			else {
				var vendorURL = window.URL || window.webkitURL;
				video.src = vendorURL.createObjectURL(stream);
			}
			video.play();
			},

		function(err) {
			console.log("An error occured! " + err);
		}
	);

	video.addEventListener('canplay', function(ev){
	  if (!streaming) {
	    height = video.videoHeight / (video.videoWidth/width);

	    // Firefox currently has a bug where the height can't be read from
	    // the video, so we will make assumptions if this happens.

	    if (isNaN(height)) {
	      height = width / (4/3);
	    }

	    video.setAttribute('width', width);
	    video.setAttribute('height', height);
	    canvas.setAttribute('width', width);
	    canvas.setAttribute('height', height);
	    streaming = true;
	  }
	}, false);

	startbutton.addEventListener('click', function(ev){
		var filtre = document.getElementById('filtreactive').src;
		if (/filtre1.png/.test(filtre) || /filtre2.png/.test(filtre) || /filtre3.png/.test(filtre) || /filtre4.png/.test(filtre))
		{
			takepicture();
			ev.preventDefault();
		}
		else
		{
			alert("Vous n'avez pas selectionné de filtre.")
		}
	}, false);

	clearphoto();
}

  // Fill the photo with an indication that none has been
  // captured.

  function clearphoto() {
    var context = canvas.getContext('2d');
    context.fillStyle = "#AAA";
    context.fillRect(0, 0, canvas.width, canvas.height);

    var data = canvas.toDataURL('image/png');
    photo.setAttribute('src', data);
  }

  // Capture a photo by fetching the current contents of the video
  // and drawing it into a canvas, then converting that to a PNG
  // format data URL. By drawing it on an offscreen canvas and then
  // drawing that to the screen, we can change its size and/or apply
  // other changes before drawing it.

  function getXMLHttpRequest() {
	  var xhr = null;

	  if (window.XMLHttpRequest || window.ActiveXObject) {
		  if (window.ActiveXObject) {
			  try {
				  xhr = new ActiveXObject("Msxml2.XMLHTTP");
			  } catch(e) {
				  xhr = new ActiveXObject("Microsoft.XMLHTTP");
			  }
		  } else {
			  xhr = new XMLHttpRequest();
		  }
	  } else {
		  alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
		  return null;
	  }

	  return xhr;
  }

	function takepicture()
	{
		var context = canvas.getContext('2d');
		if (width && height)
		{
			canvas.width = width;
			canvas.height = height;
			context.drawImage(video, 0, 0, width, height);

			var data = canvas.toDataURL('image/png');

			localStorage.canvasImage = canvas.toDataURL();

			photo.setAttribute('src', data);

			for (var i = 0; i < document.armures.armure.length; i++)
			{
				if (document.armures.armure[i].checked)
				{
					var rad_val = document.armures.armure[i].value;
				}
			}

			var xhr = getXMLHttpRequest();
			xhr.open("POST", "mounting.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("image="+ encodeURIComponent(data)+"&checkbox="+ rad_val);
		}
		else
		{
			clearphoto();
		}
	}

	// Set up our event listener to run the startup process
	// once loading is complete.
	window.addEventListener('load', startup, false);
})();

function displayImage(armure) {
	var contenuImage = "";
	if (armure == "armure1")
		contenuImage = "images/filtre1.png";
	else if (armure == "armure2")
		contenuImage = "images/filtre2.png";
	else if (armure == "armure3")
		contenuImage = "images/filtre3.png";
	else if (armure == "armure4")
		contenuImage = "images/filtre4.png";
	if (contenuImage == "")
	{
		document.getElementById('startbutton').style.display = 'none';
		document.getElementById('photo').style.display = 'none';
		document.getElementById('filtreactive').style.display = 'none';
	}
	else
	{
		document.getElementById('startbutton').style.display = 'block';
		document.getElementById('photo').style.display = 'block';
		document.getElementById('filtreactive').style.display = 'block';
	}
	document.getElementById('filtreactive').src = contenuImage;
}
