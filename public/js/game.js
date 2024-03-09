window.onload = function () {
    var chrono = document.getElementById('chrono');
    var debut_chrono = document.getElementById('debut_chrono').innerText;
    var mitemps_chrono = document.getElementById('mitemps_chrono').innerText;


    if (debut_chrono !== '') {

        debut_chrono = new Date(debut_chrono);
        debut_chrono.setHours(debut_chrono.getHours());
    }

    if (mitemps_chrono !== '') {
        mitemps_chrono = new Date(mitemps_chrono);
        mitemps_chrono.setHours(mitemps_chrono.getHours());
    }

   

    // Update the display every 1 second
    setInterval(function () {
        // Create a new Date object representing the current date and time
        var now = new Date();

        if (mitemps_chrono !== '') {
            var duree_mitemps = parseInt(document.getElementById('duree_mitemps').value);
            var difference = now.getTime() - mitemps_chrono.getTime();
            var totalSeconds = Math.floor(difference / 1000); // Total seconds elapsed
            var additionalMinutes = Math.floor(totalSeconds / 60); // Additional minutes after full minutes
            var seconds = totalSeconds % 60; // Calculate remaining seconds
            var adjustedMinutes = additionalMinutes + duree_mitemps; // Add additional minutes
            // Display the result
            chrono.innerHTML = (adjustedMinutes < 10 ? '0' : '') + adjustedMinutes + ":" + (seconds < 10 ? '0' : '') + seconds;
        }

        else {
            // if debut_chrono empty, show 00:00 in chrono.innerHTML
            if (debut_chrono === '') {
                chrono.innerHTML = '00:00';
            }
            else {
                var difference = now.getTime() - debut_chrono.getTime();
                var minutes = Math.floor(difference / 60000);
                var seconds = ((difference % 60000) / 1000).toFixed(0);
                // Display the result
                chrono.innerHTML = minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
            }
        }
    }, 1000);


    // get the minute in the chrono display, add 1 to it and store it in the hidden input
    // var minute = document.getElementById('minute');
    setInterval(function () {
        var chrono = document.getElementById('chrono').innerText;
        var minute = chrono.split(':')[0];
        minute = parseInt(minute) + 1;
        document.getElementById('minute').value = minute;
    }, 1000);


    // ajout d'evenement

    var addEvent = document.getElementById('add-event');
    addEvent.addEventListener('click', function () {
        var formEvent = document.getElementById('form-event');
        formEvent.style.display = 'block';
    });


    // gestion des icones

    var pitch = document.getElementById('pitch');
    var iconsContainer = document.getElementById('icons-container');

    // Event listener for clicking on the pitch to add icons
    pitch.addEventListener('click', function (event) {
        // Get mouse coordinates relative to the pitch
        var rect = pitch.getBoundingClientRect();
        var mouseX = event.clientX;
        var mouseY = event.clientY;

        // Create new icon element
        var icon = document.getElementById('cj');
        var newIcon = icon.cloneNode(true);
        newIcon.style.position = 'absolute';
        newIcon.style.left = mouseX + 'px';
        newIcon.style.top = mouseY + 'px';

        // Append icon to icons container
        iconsContainer.appendChild(newIcon);
    });

    // Event listener for saving icons (to be implemented)
    // document.getElementById('save-icons').addEventListener('click', function () {
    //     // Get all icon positions
    //     var icons = document.querySelectorAll('.icon');
    //     var iconPositions = [];
    //     icons.forEach(function (icon) {
    //         iconPositions.push({
    //             x: parseInt(icon.style.left),
    //             y: parseInt(icon.style.top)
    //         });
    //     });

    //     // Send icon positions to the server for saving (to be implemented)
    //     console.log(iconPositions);
    // });
};