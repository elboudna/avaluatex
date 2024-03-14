window.onload = function () {
    var chrono = document.getElementById('chrono');
    var debut_chrono = document.getElementById('debut_chrono').innerText;
    var mitemps_chrono = document.getElementById('mitemps_chrono').innerText;
    var btnPause = document.getElementById('btn-pause');
    var btnPM = document.getElementById('btn-pm');
    var btnSM = document.getElementById('btn-sm');
    var btnFin = document.getElementById('btn-fin');
    var timeline = document.getElementById('timeline').innerText;

    var scoreRec = document.getElementById('score-rec');
    var scoreVis = document.getElementById('score-vis');


    // avant match
    if (timeline === 'ini') {
        btnPause.style.display = 'none';
        btnPM.style.display = 'block';
        btnSM.style.display = 'none';
        btnFin.style.display = 'none';
        scoreRec.style.display = 'none';
        scoreVis.style.display = 'none';
    }

    //  1ere periode
    if (timeline === "1") {
        btnPM.style.display = 'none';
        btnSM.style.display = 'none';
        btnPause.style.display = 'block';
        btnFin.style.display = 'none';
        scoreRec.style.display = 'block';
        scoreVis.style.display = 'block';
    }

    //2eme periode
    if (timeline === "2") {
        btnSM.style.display = 'none';
        btnPM.style.display = 'none';
        btnPause.style.display = 'none';
        btnFin.style.display = 'block';
        scoreRec.style.display = 'block';
        scoreVis.style.display = 'block';
    }

    //mitemps
    if (timeline === "0") {
        btnPause.style.display = 'none';
        btnPM.style.display = 'none';
        btnSM.style.display = 'block';
        btnFin.style.display = 'none';
        scoreRec.style.display = 'none';
        scoreVis.style.display = 'none';
    }

    //fin match
    if (timeline === "fin") {
        btnPause.style.display = 'none';
        btnPM.style.display = 'none';
        btnSM.style.display = 'none';
        btnFin.style.display = 'none';
        scoreRec.style.display = 'none';
        scoreVis.style.display = 'none';
    }

    if (debut_chrono !== '') {
        debut_chrono = new Date(debut_chrono);
        debut_chrono.setHours(debut_chrono.getHours());
    }

    if (mitemps_chrono !== '') {
        mitemps_chrono = new Date(mitemps_chrono);
        mitemps_chrono.setHours(mitemps_chrono.getHours());
    }

    if (timeline !== '0' && timeline !== 'fin') {
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
    }
    else if (timeline === '0') {
        chrono.innerHTML = '45:00';
    }
    else if (timeline === 'fin') {
        chrono.innerHTML = '90:00';
    }



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
    var mouseX, mouseY; // Declare variables outside the event listener

    // Event listener for clicking on the pitch to get mouse coordinates
    pitch.addEventListener('click', function (event) {
        // Get mouse coordinates relative to the pitch
        mouseX = event.clientX;
        mouseY = event.clientY;

    });


    document.querySelectorAll('#icon-change img').forEach(function (icon) {
        icon.addEventListener('click', function () {

            // get the form of the same icon row
            var form = icon.parentElement.nextElementSibling.querySelector('form');

            var num = icon.parentElement.parentElement.firstElementChild.innerText;
            var iconMapSrc = icon.getAttribute('src');
            let newIcon = document.createElement('img');
            newIcon.src = iconMapSrc; // Set the src attribute of the new icon
            newIcon.alt = num; // Set the alt attribute of the new icon
            newIcon.title = num; // Set the title attribute of the new icon
            newIcon.classList.add('newIcon');


            //get the position_x and position_y and image_url and put mouseX and mouseY in the hidden input
            form.querySelector('input[name="position_x"]').value = mouseX;
            form.querySelector('input[name="position_y"]').value = mouseY;
            form.querySelector('input[name="image_url"]').value = iconMapSrc;
            form.querySelector('input[name="numero_evenement"]').value = num;



            // Set position of the new icon
            newIcon.style.position = 'absolute';
            newIcon.style.zIndex = '1000';
            newIcon.style.left = mouseX + 'px'; // Use mouseX from the outer scope
            newIcon.style.top = mouseY + 'px'; // Use mouseY from the outer scope

            // i wanna add a class to the newIcon

            // Append the new icon to the pitch
            document.body.appendChild(newIcon);

            // one the icon is added to the pitch, clear the mouse coordinates so nothing is added to the pitch when the user clicks on the pitch
            mouseX = '';
            mouseY = '';
        });
    });


};