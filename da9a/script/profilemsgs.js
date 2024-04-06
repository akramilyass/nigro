var groupName = document.querySelector('.groupName');
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