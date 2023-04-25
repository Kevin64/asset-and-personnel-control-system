function f(selectedOption, arrayOfTypes) {
    var oldRadioInput, oldRadioLabel, oldSubmitInput, i;
    var getOldRadioInputs = document.getElementsByName("radioSearch");
    var getOldSubmitInput = document.getElementById("searchButton");
    if(getOldRadioInputs.length != 0) {
        for(i = arrayOfTypes.length; i > 0; i--) {
            //oldSubmitInput = getOldSubmitInput.remove();
            oldRadioInput = getOldRadioInputs[i - 1].remove();
            oldRadioLabel = document.querySelector("label[for=\'" + arrayOfTypes[i - 1] + "\']");
            oldRadioLabel.remove();
        }
    }

    var mainTd = document.getElementById('testRadioInput');
    //var txtSearchBox = mainTd.getElementsByTagName('input')[0];
    //txtSearchBox.type = 'hidden';
    for(i = 0; i < arrayOfTypes.length; i++) {
        
        var radioInput = document.createElement('input');
        radioInput.type = "radio";
        radioInput.name = "radioSearch";
        radioInput.id = arrayOfTypes[i];
        radioInput.value = i;
        mainTd.appendChild(radioInput);
        var radioLabel = document.createElement('label');
        radioLabel.htmlFor = arrayOfTypes[i];
        radioLabel.innerHTML = arrayOfTypes[i];
        mainTd.appendChild(radioLabel);
    }
};

function getOption(){
    var option = document.querySelector('input[name="radioSearch"]:checked').value;
    if(!option){
      alert('No score was selected. Try again.');
      return false;
    }
    else{
      alert(option + ' was selected!');
      return option;
    }
  }