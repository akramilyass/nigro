//_______header btns________________________
let countgroups = document.querySelector('.countgroups');
let infoTitle = document.querySelector('.info-title');
let infoData = document.querySelector('.info-data');
countgroups.addEventListener('click', ()=>{
    let number = document.querySelector('.groupnumber').textContent;
    infoData.innerHTML =number;
    infoTitle.innerHTML ='Groups';
    
});
let workersCount = document.querySelector('.workers-count');
workersCount.addEventListener('click', ()=>{
    let number = document.querySelector('.workernumber').textContent;
    infoData.innerHTML =number;
    infoTitle.innerHTML ='Members';
    
});
let tasksCount = document.querySelector('.tasks-count');
tasksCount.addEventListener('click', ()=>{
    let number = document.querySelector('.tasknumber').textContent;
    infoData.innerHTML =number;
    infoTitle.innerHTML ='Tasks';
    
});
//___________nav window direction_________________________________________________________________________

let addmemberbtn = document.querySelector('.addmemberbtn');
addmemberbtn.addEventListener('click', ()=>{
    window.location.href = 'addworker.php';
    
});

let addgroupbtn = document.querySelector('.addgroupbtn');
addgroupbtn.addEventListener('click', ()=>{
    window.location.href = 'addgroup.php';
    
});

let addtaskbtn = document.querySelector('.addtaskbtn');
addtaskbtn.addEventListener('click', ()=>{
    window.location.href = 'addtask.php';
    
});
//__________random bg color__________________________________________________________________________
document.addEventListener("DOMContentLoaded", function() {
    // Array of predefined colors
    var colors = ["#005C9A", "#22BC3B", "#005C9A","#6B20E5", "#27922C", "#8C870F", "#BC5A22"];

    function getRandomColor() {
      var randomIndex = Math.floor(Math.random() * colors.length);
      return colors[randomIndex];
    }

    function setRandomBackgroundColor(element) {
      var randomColor = getRandomColor();
      element.style.backgroundColor = randomColor;
    }

    var elements = document.querySelectorAll(".group");

    // Set random background color for each element
    elements.forEach(function(element) {
      setRandomBackgroundColor(element);
    });

    // Optional: Change background color every 5 seconds (5000 milliseconds)
    setInterval(function() {
      elements.forEach(function(element) {
        setRandomBackgroundColor(element);
      });
    }, 60000);
  });

//_______________indecatorplacment_____________________________________________________________________
var list = document.querySelectorAll('.list');
function activlink(){
    list.forEach((item)=>item.classList.remove('active'));
    this.classList.add('active')
}
list.forEach((item)=>item.addEventListener('click',activlink))
//____________________________togle_________________________________________________________________

let setingsbtn = document.querySelector('.setings');
let header = document.querySelector('header');
let taskswraper = document.querySelector('.taskswraper');
let workerswraper = document.querySelector('.workerswraper');
let workerdelletswraper = document.querySelector('.workerdelletswraper');
let msg = document.querySelector('.msgs');
let homesection= document.querySelector('.nav');

setingsbtn.addEventListener('click', ()=>{
    header.classList.add('left0')
    
});

let home = document.querySelector('.home');
home.addEventListener('click', ()=>{
    header.classList.remove('left0')
    taskswraper.classList.remove('show');
    workerswraper.classList.remove('show');
    homesection.classList.add('show');
    workerdelletswraper.classList.remove('show');
    msg.classList.remove('show');

    homesection.classList.remove('hide');
    workerswraper.classList.add('hide');
    taskswraper.classList.add('hide');
    workerdelletswraper.classList.add('hide');
    msg.classList.add('hide');
});

let members = document.querySelector('.members');
members.addEventListener('click', ()=>{
    header.classList.remove('left0')

    taskswraper.classList.remove('show');
    workerswraper.classList.add('show');
    homesection.classList.remove('show');
    workerdelletswraper.classList.remove('show');
    msg.classList.remove('show');
    homesection.classList.add('hide');
    workerswraper.classList.remove('hide');
    taskswraper.classList.add('hide');
    workerdelletswraper.classList.add('hide');
    msg.classList.add('hide');
    
});

let call = document.querySelector('.call');

call.addEventListener('click', ()=>{
    header.classList.remove('left0')
    taskswraper.classList.add('show');
    workerswraper.classList.remove('show');
    homesection.classList.remove('show');
    workerdelletswraper.classList.remove('show');    
    msg.classList.remove('show');    


    homesection.classList.add('hide');
    workerswraper.classList.add('hide');
    taskswraper.classList.remove('hide');
    workerdelletswraper.classList.add('hide');
    msg.classList.add('hide');
    
});
let delletworker = document.querySelector('.delletworker');

delletworker.addEventListener('click', ()=>{
    header.classList.remove('left0')
    taskswraper.classList.remove('show');
    workerswraper.classList.remove('show');
    homesection.classList.remove('show');
    msg.classList.remove('show');
    workerdelletswraper.classList.add('show');

    homesection.classList.add('hide');
    workerswraper.classList.add('hide');
    taskswraper.classList.add('hide');
    msg.classList.add('hide');
    workerdelletswraper.classList.remove('hide');
    
});


let msgbtn = document.querySelector('.msgbtn');

msgbtn.addEventListener('click', ()=>{
  console.log(msg)
    msg.classList.add('show');
    msg.classList.remove('hide');

    header.classList.remove('left0')
    taskswraper.classList.remove('show');
    workerswraper.classList.remove('show');
    homesection.classList.remove('show');
    workerdelletswraper.classList.remove('show');
    workerdelletswraper.classList.add('hide');
    homesection.classList.add('hide');
    workerswraper.classList.add('hide');
    taskswraper.classList.add('hide');
    
    
});
//______________________________________________________________________________________

var task = document.querySelectorAll('.task');

task.forEach(function(Task) {
  var TaskState = Task.querySelector('.TaskState');
  let TaskStateValue = TaskState.textContent;
   if(TaskStateValue=='done'){
    Task.style.backgroundColor="green";
   }else if(TaskStateValue=='on progress'){
    Task.style.backgroundColor="red"
   }
});

var task = document.querySelectorAll('.task');

task.forEach(function(Task) {
  var TaskState = Task.querySelector('.TaskState');
  let TaskStateValue = TaskState.textContent;
   if(TaskStateValue=='done'){
    Task.style.backgroundColor="green";
   }else if(TaskStateValue=='on progress'){
    Task.style.backgroundColor="red"
   }
});


//______________________________________________________________________________________
/*
var TaskStates = document.querySelectorAll('.TaskState');

TaskStates.forEach(function(TaskState) {
   let TaskStateValue = TaskState.textContent;
   if(TaskStateValue=='done'){
    TaskState.style.color="green";
   }else if(TaskStateValue=='on progress'){
    TaskState.style.color="red"
   }
});
*/

var RulerFills = document.querySelectorAll('.ruler-fill');

RulerFills.forEach(function(RulerFill) {
   let RulerFillWidth = RulerFill.textContent;
   RulerFill.style.width=RulerFillWidth;

});




var groups = document.querySelectorAll('.group');

groups.forEach(function(group) {
  group.addEventListener('click', function() {
    // Extract data-id attribute value
    var dataId = group.getAttribute('data-id');

    // Set the value as a cookie named groupName
    document.cookie = 'groupName=' + dataId;

    // You can also log the value for testing purposes
    window.location.href = 'groupinfos.php';

  });
});


var workers = document.querySelectorAll('.worker');

workers.forEach(function(worker) {
  worker.addEventListener('click', function() {
    // Extract data-id attribute value
    var dataId = worker.getAttribute('data-id');

    // Set the value as a cookie named groupName
    document.cookie = 'workerName=' + dataId;

    // You can also log the value for testing purposes
    window.location.href = 'workerinfos.php';

  });
});



var groupNames = document.querySelectorAll('.groupName');

groupNames.forEach(function(groupName) {
  let groupNameContent =groupName.textContent
  if (groupNameContent.startsWith("aktoilmsgroup")) {
    // Remove the first 13 characters
    var stringWithoutFirst13Chars = groupNameContent.slice(13);

    // Remove the last 15 characters
    var finalResult = stringWithoutFirst13Chars.slice(0, -15);

    // Display the result

    console.log(finalResult); // Output: RemoveFirst13Chars
    groupName.textContent = finalResult +'ثانوي'
} else {
    var stringWithoutFirst13Chars = groupNameContent.slice(15);
    // Display the result
    console.log(stringWithoutFirst13Chars);
    groupName.textContent = stringWithoutFirst13Chars
}
  // Display the result
  groupName.addEventListener('click', function() {
    // Extract data-id attribute value
    var datamsgsgroupname = groupName.getAttribute('data-groupname');

    // Set the value as a cookie named groupName
    document.cookie = 'msgsgroupName=' + datamsgsgroupname;

    // You can also log the value for testing purposes
    window.location.href = 'profilemsgs.php';

  });
});

