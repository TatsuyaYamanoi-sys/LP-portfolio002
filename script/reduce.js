$.reduce = function(list, func, init){
    var acc = init;
    // console.log(list)
    // console.log(func)
    // console.log(init)
    for(var i = 0; i < list.length; i++) {
        if(i == 0 && init == undefined) {
            acc = list[i];
        }
        else {
            acc = func.call(acc, list[i]);
        }
    }
    return acc;
};