var groupNames = document.querySelectorAll('.secondarygroupname');

// Iterate over each element and attach a click event listener
groupNames.forEach(function(groupName) {
    groupName.addEventListener('click', function() {
        // Access the data-id attribute value using dataset
        var dataIdValue = groupName.dataset.id;
        document.cookie = `secondarygroupName=${dataIdValue}`;
       // window.history.pushState({}, '', 'workerinfos.php');
        window.location.href = 'secondarygroupName.php';
        
    });
});




var TaskStates = document.querySelectorAll('.TaskState');

TaskStates.forEach(function(TaskState) {
   let TaskStateValue = TaskState.textContent;
   if(TaskStateValue=='done'){
    TaskState.style.color="green";
   }else if(TaskStateValue=='on progress'){
    TaskState.style.color="red"
   }
});



var workerStates = document.querySelectorAll('.subworkername');

workerStates.forEach(function(workerstate) {
   let workerstateValue = workerstate.textContent;
   if(workerstateValue=='Present'){
    workerstate.style.color="white";
   }else if(workerstateValue=='not yet'){
    workerstate.style.color="red"
   }
});



