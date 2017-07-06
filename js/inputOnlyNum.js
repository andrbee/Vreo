function inputOnlyNum(input, event) {
    var e = event;
    var value = input.value;
    var reg = /^[.]/g;
    if (e.which > 47 && e.which < 58 || e.which == 46 && !((value).indexOf('.') + 1 )) { // Проверка на ввод только цифр и одной "."
        if (reg.exec(value + e.key)) { // Проверка на ввод первого символа только цифры, а потом уже "."
            return false;
        } else {
            return;
        }
    } else {
        return false;
    }
}

function inputOnlyInteger(input, event) {
    var e = event;
    if (e.which > 47 && e.which < 58) { // Проверка на ввод только цифр
        if (!(Number(input.value + e.key) >= 1)) {
        }
        
        return;

    } else {
        return false;
    }
}
// function iterCostPerView(el) {
//     var classElement = el.className;
//     var costEl = document.getElementById('cost-campaign');
//     var costValue = Number(costEl.value);
//     switch (classElement) {
//         case 'iter_up':
//             costEl.value = (costValue + Number(0.05)).toFixed(2);
//             break;
//         case 'iter_down':
//             if (costValue > 0.05) {
//                 if (costValue - Number(0.05) >= 0.05) {
//                     costEl.value = (costValue - Number(0.05)).toFixed(2);
//                 } else {
//                     costEl.value = 0.05;
//                 }
//             } else {
//                 costEl.value = 0.05;
//             }
//             break;
//         default:
//             break
//     }
//
// }