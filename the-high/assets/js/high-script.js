var arr = ['1', '2','3','4','5', '6', '7','8', '9', '10' ];

(function recurse(counter) {
    var color = arr[counter];
    $('#count').val(color);
    delete arr[counter];
    arr.push(color);
    setTimeout(function() {
        recurse(counter + 1);
    }, 200);
})(0);