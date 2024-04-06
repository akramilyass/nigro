
// Access all elements with the class 'worker'
var workerNames = document.querySelectorAll('.worker');

// Iterate over each element and attach a click event listener
workerNames.forEach(function(workerName) {
    workerName.addEventListener('click', function() {
        // Access the data-id attribute value using dataset
        var dataIdValue = workerName.dataset.id;

        // Log the value to the console
        console.log(dataIdValue);
        document.cookie = `workerName=${dataIdValue}`;
       // window.history.pushState({}, '', 'workerinfos.php');
        window.location.href = 'workerinfos.php';
        
    });
});

