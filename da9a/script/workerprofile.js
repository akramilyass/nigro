

//_______________Task done cookie___________________________________________________________________
var taskdonebtns = document.querySelectorAll('.taskdonebtn');

// Iterate over each element and attach a click event listener
taskdonebtns.forEach(function(taskdonebtn) {
    taskdonebtn.addEventListener('click', function() {
        // Access the data-Task attribute value using dataset
        var dataTaskValue = taskdonebtn.dataset.task;
        var encodedVariable = encodeURIComponent(dataTaskValue);
        // Log the value to the console
        console.log(dataTaskValue);
        var url = 'workerprofile.php?myVariable=' + encodedVariable;
        // window.history.pushState({}, '', 'workerinfos.php');
        window.location.href = url;
    });
});


//_______________indecatorplacment_____________________________________________________________________
/*
var list = document.querySelectorAll('.list');
function activlink(){
    list.forEach((item)=>item.classList.remove('active'));
    this.classList.add('active')
    dash.style.left="-100vw"
    nav.style.left="-100vw"

}
list.forEach((item)=>item.addEventListener('click',activlink))

*/
//--check in GET 
var checkin = document.querySelector('#checkin');

checkin.addEventListener('click', function() {

    var encodedVariable = 'chekin';
    // Log the value to the console
    console.log('chekin');
    var url = 'workerprofile.php?chekin=' + encodedVariable;
    // window.history.pushState({}, '', 'workerinfos.php');
    window.location.href = url;
});




//____________________________________________________________________________________________________________
let mainDashLabel = document.querySelector('.main-dash-label');
let DashLabel = document.querySelector('.dash-label');
let dash = document.querySelector('.dash');
mainDashLabel.addEventListener('click', () => {
    nav.style.left="-100vw"
    dash.style.left="0vw"
    
});


let mainNavLabel = document.querySelector('.main-nav-label');
let NavLabel = document.querySelector('.nav-label');
let nav = document.querySelector('nav');
mainNavLabel.addEventListener('click', () => {

    nav.style.left="0vw"
    dash.style.left="-100vw"
    
});

let maingroup = document.querySelector('.maingroup');
let maingroupcontact = document.querySelector('.main');

let secondgroup = document.querySelector('.secondgroup');
let secondgroupcontact = document.querySelector('.second');


maingroup.addEventListener('click', () => {
    dash.style.left="-100vw"
    nav.style.left="-100vw"
    maingroupcontact.classList.remove('show'); 
    if (secondgroupcontact) {
        secondgroupcontact.classList.add('show');
    }
});




secondgroup.addEventListener('click', () => {
    dash.style.left="-100vw"
    nav.style.left="-100vw"
    if (secondgroupcontact) {
        secondgroupcontact.classList.remove('show');
    }
    maingroupcontact.classList.add('show');
});

//____________________________________________________________________




/*

document.addEventListener('DOMContentLoaded', function() {
    var button = document.getElementById('checkin');
    let startingTime =document.querySelector('#groupin').textContent;
    let endingTime =document.querySelector('#groupout').textContent;
    function showHideButton() {
        var now = new Date();
        var hours = now.getHours();

        // Show the button between 5pm and 7pm
        if (hours >= startingTime && hours < endingTime) {
            button.style.display = 'block';
        } else {
            button.style.display = 'none';
        }
    }

    // Initial check when the page loads
    showHideButton();

    // Check every minute (you can adjust the interval as needed)
    setInterval(showHideButton, 60000);
});
*/

var TaskStates = document.querySelectorAll('.TaskState');

TaskStates.forEach(function(TaskState) {
   let TaskStateValue = TaskState.textContent;
   if(TaskStateValue=='done'){
    TaskState.style.color="green";
   }else if(TaskStateValue=='on progress'){
    TaskState.style.color="red"
   }
});










let  btnformaingroup= document.querySelector('.btnformaingroup');
let btnforsecondgroup = document.querySelector('.btnforsecondgroup');


maingroup.addEventListener('click', () => {
    btnformaingroup.classList.add('activee'); // Use parentheses to call the method
    btnforsecondgroup.classList.remove('activee');
});




btnforsecondgroup.addEventListener('click', () => {
    btnformaingroup.classList.remove('activee'); // Use parentheses to call the method
    btnforsecondgroup.classList.add('activee');
});
//_______group in adn out ading AM and PM
/*

let groupin = document.querySelector('#groupin');


if (groupin.textContent > 12) {
    groupinTime = groupin.textContent - 12 + "PM";
    console.log(groupinTime);
     groupin.textContent = groupinTime;
}else{
    groupinTime = groupin.textContent + "AM";
    groupin.textContent = groupinTime;
}

let groupout = document.querySelector('#groupout');


if (groupout.textContent > 12) {
    groupinTime = groupout.textContent - 12 + "PM";
    console.log(groupinTime);
     groupout.textContent = groupinTime;
}else{
    groupinTime = groupout.textContent + "AM";
    groupout.textContent = groupinTime;
}

*/

/*
function checkForUpdates() {
    $.ajax({
        url: 'workerprofile.php', // Adjust the path to your server-side endpoint
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data.newDataAvailable) {
                // Reload the messages if new data is available
                $('.msg-display').load(location.href + ' .msg-display > *');
            }
        },
        complete: function () {
            // Schedule the next check after a certain interval (e.g., every 5 seconds)
            setTimeout(checkForUpdates, 5000);
        }
    });
}

// Start checking for updates when the page loads
$(document).ready(function () {
    checkForUpdates();
});*/

function checkForTaskUpdates() {
    $.ajax({
        url: 'check-tasks.php', // Adjust the path to your server-side endpoint
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data.newTasks) {
                // Reload the tasks if new tasks are available
                $('.tasks-form').load(location.href + ' .tasks-form > *');
            } else {
                // Check if there are tasks in the database that are not displayed
                checkUnseenTasks();
            }
        },
        complete: function () {
            // Schedule the next check after a certain interval (e.g., every 5 seconds)
            setTimeout(checkForTaskUpdates, 5000);
        }
    });
}

// Function to check for tasks in the database that are not displayed
function checkUnseenTasks() {
    $('.displayed').each(function () {
        var taskName = $(this).data('task-name');
        // Check if the task with this name is in the data received from the server
        if (dataFromServer.indexOf(taskName) === -1) {
            // Send a notification and refresh the page
            alert('New task available: ' + taskName);
            location.reload();
        }
    });
}

// Start checking for updates when the page loads
$(document).ready(function () {
    checkForTaskUpdates();
});


//________Leader add tasks directot_______________________________________________________________________________
var leaderaddtaskbtn = document.querySelector('.leaderaddtaskbtn');

// Check if the button element exists
if (leaderaddtaskbtn) {
    // If it exists, add the click event listener
    leaderaddtaskbtn.addEventListener('click', function() {
        // Access the data-Task attribute value using dataset
        var dataGroupValue = leaderaddtaskbtn.dataset.group;
        var encodedVariable = encodeURIComponent(dataGroupValue);
        
        // Log the value to the console
        console.log(dataGroupValue);

        var url = 'leaderaddtask.php?myGroup=' + encodedVariable;
        
        // Uncomment the following lines to navigate to the new URL
        // window.history.pushState({}, '', 'workerinfos.php');
        window.location.href = url;
    });
}


//__Creatur___________________________________________________
/*
// Function to add and remove the 'vibr' class
function addAndRemoveClass() {
    var element = document.querySelector('.active');
    let state = element.querySelector('.icon').dataset.state;

    // Add the 'vibr' class
    element.classList.add('vibr');

    // Create a new <p> element
    var newParagraph = document.createElement('p');
    newParagraph.textContent = state;

    // Append the new <p> element to the element with the 'vibr' class
    element.appendChild(newParagraph);

    // Use the Web Speech API to read the content of the new paragraph
    var speechSynthesis = window.speechSynthesis;
    var utterance = new SpeechSynthesisUtterance(newParagraph.textContent);
    speechSynthesis.speak(utterance);

    // Wait for 10 seconds (10000 milliseconds)
    setTimeout(function () {
        // Remove the 'vibr' class after 10 seconds
        element.classList.remove('vibr');
        // Remove the <p> element
        element.removeChild(newParagraph);
    }, 10000);
}

// Add an event listener to run the function when the page loads
window.addEventListener('load', addAndRemoveClass);

// Execute the function every 1 minute (60,000 milliseconds)
setInterval(addAndRemoveClass, 60000);
*/


function addAndRemoveClass() {
    var element = document.querySelector('.active');
    let state = element.querySelector('.icon').dataset.state;

    // Add the 'vibr' class
    element.classList.add('vibr');

    // Create a new <p> element
    var newParagraph = document.createElement('p');
    newParagraph.textContent = state;

    // Append the new <p> element to the element with the 'vibr' class
    element.appendChild(newParagraph);

    // Use the Web Speech API to read the content of the new paragraph
    var speechSynthesis = window.speechSynthesis;

    // Log available voices
    console.log(speechSynthesis.getVoices());

    // Set the language to Arabic
    var utterance = new SpeechSynthesisUtterance(newParagraph.textContent);
    utterance.lang = 'ar';

    speechSynthesis.speak(utterance);

    // Wait for 10 seconds (10000 milliseconds)
    setTimeout(function () {
        // Remove the 'vibr' class after 10 seconds
        element.classList.remove('vibr');
        // Remove the <p> element
        element.removeChild(newParagraph);
    }, 10000);
}

// Add an event listener to run the function when the page loads
window.addEventListener('load', addAndRemoveClass);

// Execute the function every 1 minute (60,000 milliseconds)
setInterval(addAndRemoveClass, 60000);
