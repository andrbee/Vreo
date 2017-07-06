// ------------------- Functions Convert CPV
function convertPriceCPV(elem, event, role) {
    var e = event;
    var value = elem.value;
    var reg = /^[.]/g;
    console.log(e);
    if ((e.which > 95 && e.which < 106) || (e.which > 47 && e.which < 58) || e.key === "." && !((value).indexOf('.') + 1 )) { // Проверка на ввод только цифр и одной "."
        if (reg.exec(value + e.key)) { // Проверка на ввод первого символа только цифры, а потом уже "."
            return false;
        } else {
            var price = Number(value + e.key);
            var role = role;
            var label = elem.previousElementSibling;
            if (role === 'developer') {
                var cpv = (Number(price) * Number(0.75)).toFixed(2);
                // label.innerHTML = cpv;
            } else {
                var cpv = (Number(price) * Number(1.33)).toFixed(2);
                // label.innerHTML = cpv;
            }
            return;
        }
    } else if (e.which == 8) {

        var price = Number(value.substring(0, value.length - 1));
        var role = role;
        var label = elem.previousElementSibling;
        if (role === 'developer') {
            var cpv = (Number(price) * Number(0.75)).toFixed(2);
            // label.innerHTML = cpv;
        } else {
            var cpv = (Number(price) * Number(1.33)).toFixed(2);
            // label.innerHTML = cpv;
        }
        return;
    } else {
        return false;
    }
}

function iterCostPerView(el) {
    var cpv = 0;
    var classElement = el.className;
    var costEl = document.getElementById('cost-campaign');
    var costValue = Number(costEl.value);
    var label = costEl.previousElementSibling;
    switch (classElement) {
        case 'iter_up':
            cpv = (costValue + Number(0.05)).toFixed(2);
            costEl.value = cpv;
            cpv = (cpv * Number(0.75)).toFixed(2);
            // label.innerHTML = cpv;
            break;
        case 'iter_down':
            if (costValue > 0.05) {
                if (costValue - Number(0.05) >= 0.05) {
                    cpv = (costValue - Number(0.05)).toFixed(2);
                    costEl.value = cpv;
                    cpv = (cpv * Number(0.75)).toFixed(2);
                    // label.innerHTML = cpv;
                } else {
                    console.log('else');
                    console.log(costEl.value);
                    costEl.value = 0.05;
                    cpv = (Number(costEl.value)).toFixed(2);
                    cpv = (cpv * Number(0.75)).toFixed(2);
                    // label.innerHTML = cpv;
                }
            } else {
                costEl.value = 0.05;
                cpv = (0.05).toFixed(2);
                cpv = (cpv * Number(0.75)).toFixed(2);
                // label.innerHTML = cpv;
            }
            break;
        default:
            break
    }

}

// ------------------- Functions Convert Budget
function convertPriceBudget(elem, event, role) {
    var e = event;
    var value = elem.value;
    if ((e.which > 95 && e.which < 106) || (e.which > 47 && e.which < 58)) { // Проверка на ввод только цифр

        var price = Number(value + e.key);
        var role = role;
        var label = elem.previousElementSibling;
        if (role === 'developer') {
            var cpv = (Number(price) * Number(0.75)).toFixed(2);
            // label.innerHTML = cpv;
        } else {
            var cpv = (Number(price) * Number(1.33)).toFixed(2);
            // label.innerHTML = cpv;
        }
        return;

    } else if (e.which == 8) {

        var price = Number(value.substring(0, value.length - 1));
        var role = role;
        var label = elem.previousElementSibling;
        if (role === 'developer') {
            var cpv = (Number(price) * Number(0.75)).toFixed(2);
            // label.innerHTML = cpv;
        } else {
            var cpv = (Number(price) * Number(1.33)).toFixed(2);
            // label.innerHTML = cpv;
        }
        return;
    }
    else {
        return false;
    }
}

function changeConvertPriceBudget(elem, role) {
    var value = elem.value;
    // console.log(value * 0.75);
    var role = role;
    var label = elem.previousElementSibling;
    if (role === 'developer') {
        var cpv = (Number(value) * Number(0.75)).toFixed(2);
        // label.innerHTML = cpv;
    } else {
        var cpv = (Number(value) * Number(1.33)).toFixed(2);
        // label.innerHTML = cpv;
    }
}