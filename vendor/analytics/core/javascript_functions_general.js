


function addElementClass(element, theClassName)
{
    var newClassName = "";
    var classes = element.className.split(" ");
    for(var i = 0; i < classes.length; i++)
    {
        if(classes[i] !== theClassName)
        {
            newClassName += classes[i] + " ";
        }
    }
    newClassName += theClassName + " ";
    element.className = newClassName;
}

function removeElementClass(element, theClassName)
{
    var newClassName = "";
    var classes = element.className.split(" ");
    for(var i = 0; i < classes.length; i++)
    {
        if(classes[i] !== theClassName)
        {
            newClassName += classes[i] + " ";
        }
    }
    element.className = newClassName;
}



function setMultiSelectSelection(selectElement, selectedValues)
{
    for(var i = 0; i < selectElement.options.length; i++)
    {
        selectElement.options[i].selected = false;
    }
    
    for(var i = 0; i < selectElement.options.length; i++)
    {
        for(var count = 0; count < selectedValues.length; count++)
        {
            if(selectElement.options[i].value === selectedValues[count])
            {
                selectElement.options[i].selected = true;
                break;
            }
        }
    }
}






